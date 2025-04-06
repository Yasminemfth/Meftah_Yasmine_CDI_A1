<!DOCTYPE html>

<html lang="fr">

<head>
  
  <meta charset="UTF-8">
  
  <title>Personnages Harry Potter</title>
  
  <link rel="stylesheet" href="css/style1.css">
  
</head>
<body>
  <!-- header de la page -->
<header>
  <nav class="navbar"> <!-- Barre de nav -->
    <div class="navdiv">
      <div class="logo"><a href="#">HarryPotter Cards</a></div>
      <!--  liens de nav -->
      <ul class="menu-links">
        <li><a href="#" id="homeBtn">Accueil</a></li>
         <!-- bouton Dark Mode  -->
        <li><a href="#" id="darkModeToggle">🌙 Dark Mode 🌙</a></li>
        <li><a href="#" id="sortsBtn">Sortilèges</a></li>
        <li><a href="#">Échangez</a></li>
        <li><a href="#">Favoris</a></li>
        <li><a href="connexion.html" class="btn-nav">Connexion</a></li>
        <li><a href="inscription.html" class="btn-nav">Inscription</a></li>
      </ul>
    </div>
    <p class="intro-text">
      Découvrez les cartes à collectionner et échangez-les avec vos amis sur le monde de Harry Potter 
    </p>
  </nav>
</header>

<h1>Rechercher un personnage de Harry Potter</h1>

<!-- pour la mise en page du filtre -->
<div class="filtres">
  <input type="text" id="characterInput" placeholder="Entrez un personnage" />
  <select id="houseSelect">    <!-- liste déroulante  -->
    <option value="">-- Toutes les maisons --</option>    <!-- option par défaut -->
    <option value="Gryffindor">Gryffondor</option>
    <option value="Slytherin">Serpentard</option>
    <option value="Ravenclaw">Serdaigle</option>
    <option value="Hufflepuff">Poufsouffle</option>
  </select>
</div>

<button id="getCharacter">Voir les résultats</button>
<div class="contenu" id="characters"></div>

<!-- Les Sortilèges -->
<div class="sorts-liste" id="spellsList" style="display: none;">
  <h2>Liste des Sortilèges</h2>
  <ul id="spellsContainer"></ul>  <!-- liste ou seront montrer les sortileges quand on cliquera dessus-->
</div>

<script>
  // JavaScript
  const charactersContainer = document.getElementById('characters');
  const spellsSection = document.getElementById('spellsList');
  // récupère la liste des sortilèges à afficher lorsqu'on clique sur le bouton Sortilèges
  const spellsContainer = document.getElementById('spellsContainer');
  const personnagesChoisis = [ // j'ai choisi des persos que je mets par défaut dès qu'on ouvre le site pour éviter que ça fasse vide, je les ai mis sous forme de liste
    "Harry Potter",
    "Hermione Granger",
    "Ron Weasley",
    "Severus Snape",
    "Draco Malfoy",
    "Luna Lovegood"
  ];

  function afficherPersonnages(data) {
    // affiche les persos
    spellsSection.style.display = "none";
    charactersContainer.innerHTML = '';
    // vide le conteneur des personnages
    data.forEach(char => {
      const div = document.createElement('div');
      div.classList.add('carte'); //class carte pour le style css
       // convertit les données JSON de l'API en cartes HTML avec gestion des données manquantes car par ex l'api a des images que pour les perso souvent vu dans les films
      div.innerHTML = `
        <img src="${char.image}" alt="${char.name}">
        <strong>${char.name}</strong>
        <p>Maison : ${char.house || 'Non attribuée'}</p>
        <p>Genre : ${char.gender || 'Inconnu'}</p>
        <p>Sang : ${char.ancestry || 'Non précisé'}</p>
        <p>Date de naissance : ${char.dateOfBirth || 'Inconnue'}</p>
        <p>Année de naissance : ${char.yearOfBirth || 'Inconnue'}</p>
        <p>Acteur : ${char.actor || 'Inconnu'}</p>
        <p>Patronus : ${char.patronus || 'Non connu'}</p>
        <p>Rôle : ${
          char.hogwartsStudent ? 'Élève à Poudlard' :
          char.hogwartsStaff ? 'Personnel de Poudlard' :
          'Autre'
        }</p>
        <p>Statut : ${char.alive ? 'Vivant(e)' : 'Décédé(e)'}</p>
      `;
      charactersContainer.appendChild(div);
      // ajoute la carte du personnage au conteneur
    });
  };

  async function chargerPersonnages() { 
    try {
      const response = await fetch('https://hp-api.onrender.com/api/characters');// requête a l'API Harry Potter
      const data = await response.json();
       // converti en JSON
      const selection = data.filter(char =>
        // filtre pour garder que les perso que j'ai choisi dans la liste
        personnagesChoisis.includes(char.name)
      );
      afficherPersonnages(selection);    // affiche les perso choisi par defaut
    } catch (error) {
      charactersContainer.innerHTML = '<p>Erreur de chargement des personnages.</p>';
      console.error(error);
    }
  }

  async function rechercherPersonnages() {
    const searchName = document.getElementById('characterInput').value.toLowerCase();
    // recupère le perso entré
    const selectedHouse = document.getElementById('houseSelect').value;
  // récupère la maison sélectionnée dans le filtre déroulant

    try {
      const response = await fetch('https://hp-api.onrender.com/api/characters');
      const data = await response.json();
      const filtered = data.filter(char =>
        // filtre les personnages selon la maison
        (searchName === "" || char.name.toLowerCase().includes(searchName)) &&
        (selectedHouse === "" || char.house === selectedHouse)
      );
      if (filtered.length === 0) {
        charactersContainer.innerHTML = '<p>Aucun personnage trouvé.</p>';
        return;
      }
      afficherPersonnages(filtered);
    } catch (error) {
      charactersContainer.innerHTML = '<p>Erreur lors de la recherche.</p>';
      console.error(error);
    }
  }

  //chercher le personnage
  document.addEventListener('DOMContentLoaded', chargerPersonnages);
  // lorsqu'on click sur le bouton "Voir les résultats", on lance la recherche personnalisée via la fonction rechercherPersonnages()
  document.getElementById('getCharacter').addEventListener('click', rechercherPersonnages);

  // Dark MODE , je me suis aidé de la doc 
  const toggle = document.getElementById('darkModeToggle');
  // récup le bouton dark mode
  toggle.addEventListener('click', function (e) {
    // click
    e.preventDefault();
    document.body.classList.toggle('dark');
    // met la classe 'dark' sur le body
    toggle.textContent = document.body.classList.contains('dark') 
    // change le txte  du bouton selon le mode
      ? '☀️ White Mode ☀️' 
      : '🌙 Dark Mode 🌙';
    
  });

  // affiche les sortileges 
  document.getElementById('sortsBtn').addEventListener('click', async (e) => {
    e.preventDefault();
    charactersContainer.innerHTML = '';
    spellsSection.style.display = 'block';
    // montre la section des sortilèges
    
    try {
      const response = await fetch('https://hp-api.onrender.com/api/spells');
      //  demande a l'api pour les sortilèges
      const spells = await response.json();
      spellsContainer.innerHTML = '';
      spells.forEach(spell => {
        // j'ai fait une liste pour les sortilège
        const li = document.createElement('li');
        li.innerHTML = `<strong>${spell.name}</strong> – ${spell.description}`;
        // met le nom du sort et la description
        spellsContainer.appendChild(li);
      });
    } catch (err) {
      spellsContainer.innerHTML = '<li>Erreur lors du chargement des sortilèges.</li>';
      
      console.error(err);
    }
  });
  

// ACCUEIL
// réinitialise les filtres (champ texte et maison), la lsite sortilèges et recharge les personnages par défaut, comme à l'ouverture de la page
  document.getElementById('homeBtn').addEventListener('click', async (e) => {
    e.preventDefault();
    document.getElementById('characterInput').value = '';
    document.getElementById('houseSelect').selectedIndex = 0;
    spellsSection.style.display = 'none';
    await chargerPersonnages();
  });

</script>

<!-- bas de page -->
<footer class="footer">
  <div class="footer-content">
    <p>&copy; 2025 HarryPotter Cards. Tous droits réservés.</p>
    <div class="footer-links">
      <!-- liens du footer -->
      <a href="#">Mentions légales</a>
      <a href="#">Politique de confidentialité</a>
      <a href="#">Contact</a>
    </div>
  </div>
</footer>

</body>
</html>
