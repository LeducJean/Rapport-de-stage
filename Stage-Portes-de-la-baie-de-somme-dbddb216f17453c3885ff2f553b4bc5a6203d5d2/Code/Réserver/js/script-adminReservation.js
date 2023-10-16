// Récupérer le bouton Accepter par son ID dynamique
var boutonAccepter = document.getElementById("<?php echo $typeEmplacement; ?>");

// Vérifier si le bouton existe
if (boutonAccepter) {
    console.log("Accept button clicked");
    // Ajouter un gestionnaire d'événements au clic sur le bouton
    boutonAccepter.addEventListener("click", function () {
        if (boutonAccepter.id === "<?php echo $typeEmplacement; ?>") {
            console.log(1); // Affiche la valeur 1 si le bouton a l'ID correspondant à la variable $typeEmplacement
        } else {
            console.log(2); // Affiche la valeur 2 pour les autres boutons
        }
    });
}

function afficherChamp(id) {
    // Récupérer tous les éléments ayant la classe "champ-saisie"
    var champs = document.getElementsByClassName('champ-saisie');

    // Masquer tous les champs sauf celui avec l'ID donné
    for (var i = 0; i < champs.length; i++) {
        if (champs[i].id === id) {
            champs[i].style.display = 'block';
        } else {
            champs[i].style.display = 'none';
        }
    }

    // Défiler vers le haut de la page
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function fermerChamp(id) {
    var champ = document.getElementById(id);
    champ.style.display = "none";
}