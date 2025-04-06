<?php
// autoloader de Composer pour Guzzle (comme dans le cours)
require 'vendor/autoload.php';

use GuzzleHttp\Client;

// Identifiants 
$client_id = 'f375ff0ab4cf4d76938f7225f1fce163';
$client_secret = '3d0289edba94480bbb5d29ad266ba36f';

// création d’un client HTTP pour les requêtes à l’API Spotify
$client = new Client();

// demander un token d’accès à Spotify et le token se met a jour a chaque fois pour eviter d'avoir des problèmes
$response = $client->post('https://accounts.spotify.com/api/token', [
    'headers' => [
        'Authorization' => 'Basic ' . base64_encode("$client_id:$client_secret"),
        'Content-Type'  => 'application/x-www-form-urlencoded',
    ],
    'form_params' => [
        'grant_type' => 'client_credentials',
    ],
]);

// on recup le token avec json
$token_data = json_decode($response->getBody(), true);
$access_token = $token_data['access_token'];

// rechercher de l'artiste ENHYPEN via l’API de recherche Spotify (forme propre a l'api spotify)
$response = $client->get('https://api.spotify.com/v1/search', [
    'headers' => [
        'Authorization' => 'Bearer ' . $access_token 
    ],
    'query' => [
        'q' => 'ENHYPEN',
        'type' => 'artist',
        'limit' => 1
    ]
]);

// récupération des infos de l’artiste (nom , image , id etcc)
$data = json_decode($response->getBody(), true);
$artist = $data['artists']['items'][0]; 
$artist_id = $artist['id'];
$artist_image = $artist['images'][0]['url']; // URL de l’image principale du groupe (qui s'affiche sur spotify)
$artist_name = $artist['name'];

// récupérer les albums de l’artiste à partir de son ID 
$response = $client->get("https://api.spotify.com/v1/artists/$artist_id/albums", [
    'headers' => [
        'Authorization' => 'Bearer ' . $access_token
    ],
    'query' => [
        'include_groups' => 'album', 
        'limit' => 6     // Limite à 6 albums (modifiable)
    ]
]);

// stock la liste d'albums 
$albums = json_decode($response->getBody(), true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Albums de <?= $artist_name ?></title>
    <link rel="stylesheet" href="css/style.css"> <!-- Ton fichier CSS perso -->
</head>
<body>

<h1>Albums de <?= $artist_name ?></h1>

<!-- affiche la photo officielle de enhypen au-dessus des albums -->
<div style="text-align: center; margin-bottom: 30px;">
    <img src="<?= $artist_image ?>" alt="Photo de <?= $artist_name ?>" style="max-width: 300px; border-radius: 12px;">
</div>

<!-- foreach sur tous les albums pour les afficher -->
<div class="contenu">
    <?php foreach ($albums['items'] as $album): ?>
        <div class="album">
            <!-- affiche la pochette de l'album -->
            <img src="<?= $album['images'][0]['url'] ?>" alt="Pochette">
            <!-- titre de l’album -->
            <h3><?= $album['name'] ?></h3>
            <!-- lien vers l’album sur Spotify -->
            <a href="<?= $album['external_urls']['spotify'] ?>" target="_blank">Écouter sur Spotify</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
