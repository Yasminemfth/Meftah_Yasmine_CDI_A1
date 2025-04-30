<?php
session_start();         
session_unset();          // supprimer toutes les variables de la session
session_destroy();        // détruire la session

header('Location: formulaire1.php'); // redirection vers la page de connexion
exit();                  
?>
