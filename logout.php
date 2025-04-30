<?php
session_start();          // Démarrer la session
session_unset();          // Supprimer toutes les variables de session
session_destroy();        // Détruire la session

header('Location: formulaire.html'); // Redirection vers la page de connexion
exit();                  // Fin du script proprement
?>
