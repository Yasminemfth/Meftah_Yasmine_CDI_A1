
<?php
session_start();

// redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['email'])) {
    header('Location: formulaire1.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une carte Harry Potter</title>
    <link rel="stylesheet" href=" styleharryform.css">

</head>
<body>
<p>Bonjour, <?php echo htmlspecialchars($_SESSION['email']); ?> !</p>

<form action="cartes_harrypotter.php" method="POST" enctype="multipart/form-data">
<div class="container">
    <!-- partie recherche -->
    <div class="form-section">
    <form action="login1.php" method="POST">
        <h2>🃏 Rechercher une carte</h2>
        <form action="recherche_carte.php" method="GET">
            <label for="nom_recherche">Nom :</label>
            <input type="text" name="nom" id="nom_recherche">

            <label for="maison_recherche">Maison :</label>
            <select name="maison" id="maison_recherche">
                <option value="">--Choisissez une maison--</option>
                <option value="Slytherin">Slytherin</option>
                <option value="Ravenclaw">Ravenclaw</option>
                <option value="Gryffindor">Gryffindor</option>
                <option value="Hufflepuff">Hufflepuff</option>
            </select>

            <button type="submit">Rechercher</button>
        </form>
    </div>

    <!-- partie création de la carte -->
    <div class="form-section">
        <h2>Créez votre carte 🧙‍♂️</h2>
        <form action="cartes_harrypotter.php" method="POST" enctype="multipart/form-data">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>

            <label for="maison">Maison :</label>
            <select name="maison" id="maison" required>
                <option value="">--Choisissez une maison--</option>
                <option value="Slytherin">Slytherin</option>
                <option value="Ravenclaw">Ravenclaw</option>
                <option value="Gryffindor">Gryffindor</option>
                <option value="Hufflepuff">Hufflepuff</option>
            </select>

            <label for="genre">Genre :</label>
            <input type="text" name="genre" id="genre" required>

            <label for="sang">Sang :</label>
            <input type="text" name="sang" id="sang" required>

            <label for="date_naissance">Date de naissance :</label>
            <input type="date" name="date_naissance" id="date_naissance" required>

            <label for="images">Image :</label>
            <input type="file" name="images" id="images" accept="image/*">

            <button type="submit">Valider</button>
        </form>
    </div>
</div>
<!--actions du user : afficher ttes_les cartes, acceder a l'inventaire ou se deconnecter -->
<div class="actions">
    <a class="btn-link" href="inventaire_utilisateur.php">Votre inventaire</a>
    <a class="btn-link" href="afficher_ttes_cartes.php">Afficher toutes les cartes</a>
    <a class="btn-link" href="logout1.php">Se deconnecter</a>
    </form>
</div>

</body>
</html>
