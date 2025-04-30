<?php
session_start();

// connexion à la bdd
try {
    $pdo = new PDO('mysql:host=localhost;dbname=harrypotter_cards;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


echo htmlspecialchars($_SESSION['email']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaires/la recherche
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $maison = isset($_POST['maison']) ? trim($_POST['maison']) : '';
    $genre = isset($_POST['genre']) ? trim($_POST['genre']) : '';
    $sang = isset($_POST['sang']) ? trim($_POST['sang']) : '';
    $date_naissance = isset($_POST['date_naissance']) ? trim($_POST['date_naissance']) : '';
    $images = '';

    // gestion de l'upload d'image (sont dans le dossier uploads)
    if (isset($_FILES['images']) && $_FILES['images']['error'] == 0) {
        $dossier = 'uploads/';
        $fichier = basename($_FILES['images']['name']);
        $chemin = $dossier . $fichier;
    
        if (move_uploaded_file($_FILES['images']['tmp_name'], $chemin)) {
            $images = $fichier;
        } else {
            echo "Erreur lors de l'upload de l'image.";
            exit();
        }
    }

    
    if (!empty($nom)) {
        // recherche de la carte
        $stmt = $pdo->prepare("SELECT * FROM cartes WHERE nom = :nom");
        $stmt->execute(['nom' => $nom]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // carte existante - redirection = vers acceuil1 cad affiche la carte recherché
            $_SESSION['nom'] = $nom;
            header('Location: acceuil1.php');
            exit();
        } else {
            // nouvelle carte - insertion dans la bdd
            $stmt = $pdo->prepare("INSERT INTO cartes (nom, maison, genre, sang, date_naissance, images) 
                                 VALUES (:nom, :maison, :genre, :sang, :date_naissance, :images)");
            $stmt->execute([
                'nom' => $nom,
                'maison' => $maison,
                'genre' => $genre,
                'sang' => $sang,
                'date_naissance' => $date_naissance,
                'images' => $images,
            ]);
//amene aussi vers acceuil1 car affiche la carte crée/ajouté par l'user 
            $_SESSION['nom'] = $nom;
            header('Location: acceuil1.php');
            exit();
        }
    } elseif (!empty($maison)) {
        // recherche par maison (grace a une liste déroulante )
        $stmt = $pdo->prepare("SELECT * FROM cartes WHERE maison = :maison");
        $stmt->execute(['maison' => $maison]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['maison'] = $maison;
            header('Location: maison.php');
            exit();
        } else {
            echo "Aucun personnage trouvé dans cette maison.<br>";
            echo '<a href="harrypotter.php">Retour</a>';
            exit();
        }
    } else {
        // gestion des erreurs de formulaire
        echo "Veuillez remplir le nom ou la maison.<br>";
        echo '<a href="harrypotter.php">Retour</a>';
    }
}
?>