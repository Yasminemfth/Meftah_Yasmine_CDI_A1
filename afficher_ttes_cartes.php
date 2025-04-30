<?php
// Démarrage de session et connexion à la bdd avec l'utilisateur
session_start();

try {
    // connexion PDO à la base MySQL
    $pdo = new PDO('mysql:host=localhost;dbname=harrypotter_cards;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// récupération de toutes les cartes depuis la bdd
try {
    $stmt = $pdo->prepare("SELECT * FROM cartes");
    $stmt->execute();
    $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la requête : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cartes Harry Potter</title>
    <link rel="stylesheet" href="stylecartes.css">
</head>
<body>
<div class="container">
    <h1>Liste des Cartes Harry Potter</h1>
    
    <!-- affichage dynamique de chaque carte une par une -->
    <?php foreach ($cartes as $carte): ?>
        <div class="carte">
            <h3><?= htmlspecialchars($carte['nom']) ?></h3>
            
            <!-- détails de la carte (catégorie de la table dans la dtbase) -->
            <p><strong>Maison:</strong> <?= htmlspecialchars($carte['maison']) ?></p>
            <p><strong>Genre:</strong> <?= htmlspecialchars($carte['genre']) ?></p>
            <p><strong>Sang:</strong> <?= htmlspecialchars($carte['sang']) ?></p>
            <p><strong>Naissance:</strong> <?= htmlspecialchars($carte['date_naissance']) ?></p>
            
            <!-- pour l'image -->
            <?php if (!empty($carte['images'])): ?>
                <img src="uploads/<?= htmlspecialchars($carte['images']) ?>" alt="<?= htmlspecialchars($carte['nom']) ?>">
            <?php else: ?>
                <p>Aucune image</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<!--actions utilisateur : retour a l'acceuil ou supprimez une carte -->
<div class="actions">
    <a class="btn-link" href="harrypotter.php"> Retour à l'accueil</a>
    
    <form class="delete-form" action="supprimez_cartes.php" method="POST">
        <input type="text" name="nom" placeholder="Nom de la carte à supprimer" required>
        <button type="submit">Supprimer</button>
    </form>
</div>

</body>
</html>