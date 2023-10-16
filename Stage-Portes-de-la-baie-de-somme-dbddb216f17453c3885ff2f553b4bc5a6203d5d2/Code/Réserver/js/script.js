e = true;
eye.addEventListener('click', () => {
  if (e) {
    document.getElementById("mdp").setAttribute("type", "text");
    document.getElementById("eye").src = "image/oeil.png";
    e = false
  }
  else {
    document.getElementById(("mdp")).setAttribute("type", "password");
    document.getElementById("eye").src = "image/les-yeux-croises.png";
    e = true
  }
})

e2 = true;
eye2.addEventListener('click', () => {
  if (e2) {
    document.getElementById("mdp2").setAttribute("type", "text");
    document.getElementById("eye2").src = "image/oeil.png";
    e2 = false
  }
  else {
    document.getElementById(("mdp2")).setAttribute("type", "password");
    document.getElementById("eye2").src = "image/les-yeux-croises.png";
    e2 = true
  }
})

// Récupérer l'élément select par son ID
var selectElement = document.getElementById("country_code");
var desactivateButton = document.getElementById("desactivateButton");

desactivateButton.disabled = true;

function numero() {
  // Récupérer la valeur sélectionnée
  var phoneCountry = selectElement.value;

  desactivateButton.disabled = false;

  // Afficher la valeur sélectionnée dans la console
  console.log(phoneCountry);

  // Définir la valeur dans le champ de formulaire caché
  document.getElementById("phone_country_input").value = phoneCountry;
}

// Écouteur d'événement pour détecter les changements de sélection
selectElement.addEventListener("change", function () {
  numero();
});