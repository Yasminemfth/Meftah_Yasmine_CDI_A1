<?php
session_start();

// vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour voir votre inventaire.";
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=harrypotter_cards;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // requête SQL pour récupérer les cartes de l'utilisateur connecté , fait le lien entre la table carte et celle inventaire user mais aussi de la database utilisateur qui enregistre les données des users
    $stmt = $pdo->prepare("
        SELECT cartes.* 
        FROM cartes
        INNER JOIN inventaire_utilisateur 
        ON cartes.id = inventaire_utilisateur.carte_id
        WHERE inventaire_utilisateur.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $user_id]);
    $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);//renvoie toutes ses cartes

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inventaire</title>
    <link rel="stylesheet" href=" stylecartes.css">
</head>
<body>

<h1>Mon inventaire</h1>
<!-- -->
<?php if (empty($cartes)): ?>
<div class="container">
    <p>Aucune carte dans votre inventaire</p>
<?php else: ?>
     <!-- boucle pour afficher chaque carte de l'inventaire -->
    <?php foreach ($cartes as $carte): ?>
        <div class="carte">
        <div>
             <!-- affichage des infos de la carte (image nom,etc...) -->
            <h2><?php echo htmlspecialchars($carte['nom']); ?></h2>
            <?php if (!empty($carte['images'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($carte['images']); ?>" alt="Image" width="200">
            <?php endif; ?>
            <p>Genre : <?php echo htmlspecialchars($carte['genre']); ?></p>
            <p>Sang : <?php echo htmlspecialchars($carte['sang']); ?></p>
            <p>Date de naissance : <?php echo htmlspecialchars($carte['date_naissance']); ?></p>
            <hr>
        </div>
         <!--form pour supprimer la carte de l'inventaire-->
        <form action="supprimer_carte_inventaire.php" method="POST" onsubmit="return confirm('Supprimer cette carte de votre inventaire ?');">
    <input type="hidden" name="carte_id" value="<?php echo $carte['id']; ?>">
    <button type="submit">✖️ Retirer de l'inventaire ✖️</button>
</form>

    <?php endforeach; ?>
<?php endif; ?>

<a href="harrypotter.php">Retour à l'accueil</a>

</body>
</html>
