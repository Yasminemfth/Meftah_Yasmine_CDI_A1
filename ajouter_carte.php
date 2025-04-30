<?php
include 'connexion.php'; // Assure-toi que ce fichier existe pour te connecter à MySQL

header('Content-Type: application/json');

// Lire le JSON reçu
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['error' => 'Données invalides']);
    exit();
}

// Insertion de la carte dans la base de données
$stmt = $pdo->prepare("
    INSERT INTO cartes (nom, maison, genre, sang, date_naissance, annee_naissance, acteur, patronus, role, statut, image)
    VALUES (:nom, :maison, :genre, :sang, :date_naissance, :annee_naissance, :acteur, :patronus, :role, :statut, :image)
");

$stmt->execute([
    'nom' => $input['nom'],
    'maison' => $input['maison'],
    'genre' => $input['genre'],
    'sang' => $input['sang'],
    'date_naissance' => $input['date_naissance'],
    'annee_naissance' => $input['annee_naissance'],
    'acteur' => $input['acteur'],
    'patronus' => $input['patronus'],
    'role' => $input['role'],
    'statut' => $input['statut'],
    'image' => $input['image']
]);

echo json_encode(['message' => 'Carte ajoutée avec succès']);
?>
