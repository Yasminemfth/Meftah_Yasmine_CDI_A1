<?php
session_start();

// vérifie s'il y a une maison selectioné
if (!isset($_SESSION['maison']) || empty(trim($_SESSION['maison']))) {
    echo "Aucun personnage sélectionné.<br>";
    echo '<a href="formulaire.php">Retour au formulaire</a>';
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=harrypotter_cards;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// recherche exacte du personnage ou des personnages de la maison
$maison = trim($_SESSION['maison']);

$stmt = $pdo->prepare("SELECT * FROM cartes WHERE maison = :maison");
$stmt->execute(['maison' => $maison]);
$cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cartes)) { 
    echo "Aucun personnage trouvé pour la maison " . htmlspecialchars($maison) . ".<br>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Personnages de la maison <?php echo htmlspecialchars($maison); ?></title>
    <link rel="stylesheet" href="stylecartes.css">
</head>
<body>
    
<div class="container">
<?php foreach ($cartes as $carte): ?>
    <div class="carte">
         <!-- affichage des infos de la carte (image nom,etc...) -->
        <h2><?php echo htmlspecialchars($carte['nom']); ?></h2>
        
        <?php if (!empty($carte['images'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($carte['images']); ?>" alt="Image de <?php echo htmlspecialchars($carte['nom']); ?>">
        <?php endif; ?>

        <p><strong>Genre :</strong> <?php echo htmlspecialchars($carte['genre']); ?></p>
        <p><strong>Sang :</strong> <?php echo htmlspecialchars($carte['sang']); ?></p>
        <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($carte['date_naissance']); ?></p>

        <!-- formulaire d'ajout à l'inventaire -->
        <form action="ajouter_inventaire.php" method="POST">
            <input type="hidden" name="carte_id" value="<?php echo $carte['id']; ?>">
            <button type="submit">Ajouter à l'inventaire</button>
        </form>
    </div>
<?php endforeach; ?>

 <!-- actions du user -->
<div class="actions">
    <a class="btn-link" href="harrypotter.php">Retour à l'accueil</a>

    <form class="delete-form" action="supprimez_cartes.php" method="POST">
        <input type="text" name="nom" placeholder="Nom de la carte à supprimer" required>
        <button type="submit">Supprimer</button>
    </form>
</div>
</body>
</html>
