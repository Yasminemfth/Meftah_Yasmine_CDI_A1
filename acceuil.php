<?php
session_start(); // Toujours démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
</head>
<body>

    <h1>Bienvenue sur la page d'accueil !</h1>

    <p>Bonjour, <?php echo htmlspecialchars($_SESSION['email']); ?> !</p>

    <!-- Formulaire pour se déconnecter -->
    <form action="logout.php" method="POST">
        <button type="submit">Se déconnecter</button>
    </form>

</body>
</html>
