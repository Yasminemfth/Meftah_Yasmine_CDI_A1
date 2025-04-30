<?php
session_start(); 

try {
    $pdo = new PDO('mysql:host=localhost;dbname=exercices_login;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}

// vérifier si les données du formulaire sont envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email invalide.";
        exit();
    }

    // rechercher l'utilisateur 
    $stmt = $pdo->prepare("SELECT id, mot_de_passe FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // vérifier le mdp
        if (password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user['id'];
            header('Location: harrypotter.php');
            exit();
        } else {
            echo "Mot de passe incorrect.";
            exit();
        }
    } else {
        // Nouvel utilisateur : l'inscrire
        $mot_de_passe_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :mot_de_passe)");
        $stmt->execute([
            'email' => $email,
            'mot_de_passe' => $mot_de_passe_hash
        ]);

        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $pdo->lastInsertId(); // Récupérer l'ID nouvellement créé
        header('Location: harrypotter.php');
        exit();
    }
}