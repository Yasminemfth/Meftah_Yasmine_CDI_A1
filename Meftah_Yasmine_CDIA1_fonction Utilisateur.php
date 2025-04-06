<?php

// calcule la moyenne de 3 nombres
function calculerMoyenne($nbre1, $nbre2, $nbre3) {
    return ($nbre1 + $nbre2 + $nbre3) / 3;
}

// affiche la moyenne
function afficherResultat($nom, $moyenne) {
    if ($moyenne >= 10) {
        echo "La moyenne de $nom est suffisante : voici sa moyenne $moyenne/20";
    } else {
        echo "La moyenne de $nom est insuffisante : voici sa moyenne $moyenne/20";
    }
}

// Pour l'étudiante Alice
$notesAlice = [15, 20, 8];
$moyenneAlice = calculerMoyenne($notesAlice[0], $notesAlice[1], $notesAlice[2]);

return afficherResultat("Alice", $moyenneAlice);


?>
