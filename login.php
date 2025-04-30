<?php
session_start(); // Toujours démarrer la session avant tout

try {
    $pdo = new PDO('mysql:host=localhost;dbname=exercices_login;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sécurisé : éviter les erreurs si les champs ne sont pas présents
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($email) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email invalide.";
        exit();
    }

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id, mot_de_passe FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Connexion (on compare le mot de passe)
        if (password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['email'] = $email;
            header('Location: acceuil.php');
            exit();
        } else {
            echo "Mot de passe incorrect.";
            exit();
        }
    } else {
        // Inscription
        $mot_de_passe_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :mot_de_passe)");
        $stmt->execute([
            'email' => $email,
            'mot_de_passe' => $mot_de_passe_hash
        ]);

        $_SESSION['email'] = $email;
        header('Location: acceuil.php');
        exit();
    }
}
?>
