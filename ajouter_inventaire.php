<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour ajouter une carte.";
    exit();
}

// gère l'ajout d'une carte à l'inventaire de l'user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carte_id'])) {
    $carte_id = intval($_POST['carte_id']); // Sécurisation de l'input
    $user_id = $_SESSION['user_id'];

    try {
        // connexion à la bdd
        $pdo = new PDO('mysql:host=localhost;dbname=harrypotter_cards;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // verifie si la carte existe déja dans l'inventaire de l'utilisateur
        $check = $pdo->prepare("SELECT * FROM inventaire_utilisateur WHERE user_id = :user_id AND carte_id = :carte_id");
        $check->execute(['user_id' => $user_id, 'carte_id' => $carte_id]);

        if ($check->rowCount() === 0) {
            // ajout de la carte si elle n'est pas dans l'inventaire
            $stmt = $pdo->prepare("INSERT INTO inventaire_utilisateur (user_id, carte_id) VALUES (:user_id, :carte_id)");
            $stmt->execute(['user_id' => $user_id, 'carte_id' => $carte_id]);
            echo "Carte ajoutée à votre inventaire.";
        } else {
            echo "Carte déjà présente dans votre inventaire.";
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
// lien vers l'inventaire
echo '<br><br><a href="inventaire_utilisateur.php"><button>Voir mon inventaire</button></a>';