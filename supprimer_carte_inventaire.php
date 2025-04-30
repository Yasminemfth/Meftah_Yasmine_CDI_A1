<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carte_id'])) {
    $carte_id = intval($_POST['carte_id']);
    $user_id = $_SESSION['user_id'];

    try {// connexion à la bdd
        $pdo = new PDO('mysql:host=localhost;dbname=harrypotter_cards;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Suppression de la carte de l'inventaire
        $stmt = $pdo->prepare("DELETE FROM inventaire_utilisateur WHERE user_id = :user_id AND carte_id = :carte_id");
        $stmt->execute(['user_id' => $user_id, 'carte_id' => $carte_id]);

        echo " Carte retirée de votre inventaire.";
        echo '<br><a href="inventaire_utilisateur.php"><button>Retour à l\'inventaire</button></a>';
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Requête invalide.";
}
