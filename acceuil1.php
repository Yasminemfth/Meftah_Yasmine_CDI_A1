<?php
session_start();

// Vérifie s'il y a un nom dans la session
if (!isset($_SESSION['nom']) || empty(trim($_SESSION['nom']))) {
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

// Recherche exacte du personnage
$nom = trim($_SESSION['nom']);

$stmt = $pdo->prepare("SELECT * FROM cartes WHERE nom = :nom");
$stmt->execute(['nom' => $nom]);
$carte = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$carte) {
    echo "Personnage non trouvé dans la base.<br>";
    echo '<a href="formulaire.php">Retour au formulaire</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte de <?php echo htmlspecialchars($carte['nom']); ?></title>
    <link rel="stylesheet" href="stylecartes.css">
</head>
<body>
<div class="container">
<div class="carte">
    <h1><?php echo htmlspecialchars($carte['nom']); ?></h1>
    
    <?php if (!empty($carte['images'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($carte['images']); ?>" alt="Image de <?php echo htmlspecialchars($carte['nom']); ?>" width="200">
    <?php endif; ?>
    
    <p><strong>Maison :</strong> <?php echo htmlspecialchars($carte['maison']); ?></p>
    <p><strong>Genre :</strong> <?php echo htmlspecialchars($carte['genre']); ?></p>
    <p><strong>Sang :</strong> <?php echo htmlspecialchars($carte['sang']); ?></p>
    <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($carte['date_naissance']); ?></p>

    <!-- Formulaire d'ajout à l'inventaire -->
    <form action="ajouter_inventaire.php" method="POST">
        <input type="hidden" name="carte_id" value="<?php echo $carte['id']; ?>">
        <button type="submit">Ajouter à l'inventaire</button>
    </form>
</div>

<a href="harrypotter.php">Retour à l'accueil</a>

<form action="supprimez_cartes.php" method="POST">
    <input type="text" name="nom" placeholder="Nom de la carte à supprimer">
    <button type="submit">Supprimer</button>
</form>

</body>
</html>
