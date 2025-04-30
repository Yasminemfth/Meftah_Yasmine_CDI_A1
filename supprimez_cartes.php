<?php

session_start();

try { //se connecter à la dtbase
    $pdo = new PDO('mysql:host=localhost;dbname=harrypotter_cards;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';

    if (!empty($nom)) {
        try {
            // Suppression de la carte de l'inventaire
            $stmt = $pdo->prepare("DELETE FROM cartes WHERE nom = :nom");
            $stmt->execute(['nom' => $nom]);
            
            header('Location: harrypotter.php');
            exit();
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression : " . $e->getMessage();
        }
    } else {
        echo "Nom non fourni pour la suppression.";
    }
} else {
    echo "Méthode invalide.";
}
?>