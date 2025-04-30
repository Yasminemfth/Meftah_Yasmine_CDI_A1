<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title> 
    <link rel="stylesheet" href="styleconnexion.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <!-- formulaire de connexion : envoie les données à login1.php -->
<div class="form-box">
    <h2>Connectez-vous ou inscrivez-vous pour accéder à vos cartes Harry Potter 🧙</h2>

    <form action="login1.php" method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button> <br>

        <br><button type="submit">S'inscrire</button>
    </form>
<!-- formulaire de connexion : envoie les données à logout1.php -->
    <form action="logout1.php" method="POST" style="margin-top: 10px;">
        <button type="submit">Se déconnecter</button>
    </form>
</div>

</body>
</html>
