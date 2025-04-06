// Sélectionner tous les boutons des onglets et les contenus
let tabs = document.querySelectorAll(".tab"); // Récupère tous les éléments ayant la classe "tab"
let contents = document.querySelectorAll(".content"); // Récupère tous les éléments ayant la classe "content"

tabs.forEach((tab, index) => { // Permet de parcourir chaque onglet
    tab.addEventListener("click", function () { // Ajoute l'animation "click" à chaque onglet
        // Supprimer les classes actives des onglets et contenus
        tabs.forEach(t => t.classList.remove("tab-active")); // Retire la classe "tab-active" de tous les onglets
        contents.forEach(c => c.classList.remove("active")); // Retire la classe "active" de tous les contenus

        // Ajouter la classe active au bouton cliqué
        this.classList.add("tab-active"); // Ajoute la classe "tab-active" à l'onglet cliqué

        // Afficher le contenu correspondant
        contents[index].classList.add("active"); // Ajoute la classe "active" au contenu correspondant à l'onglet
    });
});

// Fonction pour gérer le mode sombre
function mode() {
    let element = document.body; // Sélectionne l'élément <body>
    element.classList.toggle("light-mode"); // Ajoute ou retire la classe "dark-mode" pour basculer le mode sombre
}

// Sélection du formulaire
let form = document.querySelector('form'); // Sélectionne l'élément <form> de la page

// Ajouter un gestionnaire d'événement pour le formulaire
form.addEventListener('submit', function (event) {
    event.preventDefault(); // Empêche l'envoi par défaut du formulaire

    // Sélection des champs du formulaire
    let email = document.querySelector('#email'); // Récupère le champ email
    let pseudo = document.querySelector('#pseudo'); // Récupère le champ pseudo
    let password = document.querySelector('#password'); // Récupère le champ mot de passe
    let passwordRepeat = document.querySelector('#password2'); // Récupère le champ confirmation du mot de passe
    let errorContainer = document.querySelector('.message-error'); // Conteneur pour les messages d'erreur
    let errorList = errorContainer.querySelector('ul'); // Liste des erreurs dans le conteneur
    let successContainer = document.querySelector('.message-success'); // Conteneur pour les messages de succès

    // Réinitialisation des messages et des styles
    errorList.innerHTML = ""; // Vide les messages d'erreur précédents
    errorContainer.classList.remove('visible'); // Cache le conteneur des erreurs
    successContainer.classList.remove('visible'); // Cache le conteneur des succès

    // Réinitialise les styles des champs
    email.classList.remove('error', 'success');
    pseudo.classList.remove('error', 'success');
    password.classList.remove('error', 'success');
    passwordRepeat.classList.remove('error', 'success');

    let valid = true; // Initialise le statut de validation

    // Validation de l'email
    if (email.value.trim() === '') { // Vérifie si le champ email est vide
        let err = document.createElement('li'); // Crée un élément <li> pour l'erreur
        err.innerText = "L'adresse email est requise."; // Message d'erreur
        errorList.appendChild(err); // Ajoute l'erreur à la liste
        email.classList.add('error'); // Applique la classe "error" au champ
        valid = false; // Indique que le formulaire n'est pas valide
    } else {
        email.classList.add('success'); // Applique la classe "success" si valide
    }

    // Validation du pseudo
    if (pseudo.value.trim().length < 6) { // Vérifie si le pseudo fait moins de 6 caractères
        let err = document.createElement('li'); // Crée un élément <li> pour l'erreur
        err.innerText = "Le pseudo doit contenir au moins 6 caractères."; // Message d'erreur
        errorList.appendChild(err); // Ajoute l'erreur à la liste
        pseudo.classList.add('error'); // Applique la classe "error" au champ
        valid = false; // Indique que le formulaire n'est pas valide
    } else {
        pseudo.classList.add('success'); // Applique la classe "success" si valide
    }

    // Validation du mot de passe
    let passCheck = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[-+_!@#$%^&*.,?]).{10,}$/; // Expression régulière pour valider le mot de passe
    if (!passCheck.test(password.value.trim())) { // Vérifie si le mot de passe ne respecte pas les règles
        let err = document.createElement('li'); // Crée un élément <li> pour l'erreur
        err.innerText =
            "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial."; // Message d'erreur
        errorList.appendChild(err); // Ajoute l'erreur à la liste
        password.classList.add('error'); // Applique la classe "error" au champ
        valid = false; // Indique que le formulaire n'est pas valide
    } else {
        password.classList.add('success'); // Applique la classe "success" si valide
    }

    // Validation de la confirmation du mot de passe
    if (passwordRepeat.value.trim() !== password.value.trim()) { // Vérifie si la confirmation ne correspond pas au mot de passe
        let err = document.createElement('li'); 
        err.innerText = "Les mots de passe ne correspondent pas."; // Message d'erreur
        errorList.appendChild(err); // Ajoute l'erreur à la liste
        passwordRepeat.classList.add('succes'); // Applique la classe "success" par erreur (corriger à "error")
        valid = false; // Indique que le formulaire n'est pas valide
    } else {
        passwordRepeat.classList.add('error'); // Applique la classe "error" par erreur (corriger à "success")
        successContainer.classList.add('message-success')
    }

  // Affichage des messages
  if (!valid) {
    // Si le formulaire est invalide, affiche les erreurs
    errorContainer.classList.add('visible');
} else {
    // Si le formulaire est valide, affiche le message de succès
    successContainer.innerHTML = "<p>Inscription réussie ! Bienvenue !</p>";
    successContainer.classList.add('visible');
    successContainer.classList.add('message-success')
}
});