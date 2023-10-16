var nbrNuitsAvril = 0;
var nbrNuitsMai = 0;
var nbrNuitsJuin = 0;
var nbrNuitsJuillet = 0;
var nbrNuitsAout = 0;
var nbrNuitsSeptembre = 0;

var differenceDays = 0;
var selectedValue = 0;
var nbrEnfantsM12 = 0;
var nbrEnfantsM12Prix = 0;
var nbrEnfantsP12 = 0;
var nbrEnfantsP12Prix = 0;
var nbrAdultesPrix = 0;
var valeurElectricite = 0;
var valeurVehicule = 0;
var valeurAnimaux = 0;
var maxOptionAdultes = -1;
var nbrAdultesConditions = 0;
var taxeSejour = 0.2;
var septJours = 0;
var month = 0;
var moisDate1 = 0;
var moisDate2 = 0;

errorLabel.textContent = "Veuillez sélectionner une date.";

function checkDates() {
    date1 = document.getElementById("date1").value;
    date2 = document.getElementById("date2").value;
    var errorLabel = document.getElementById("errorLabel");
    var desactivateButton = document.getElementById("desactivateButton");

    if (date1 || date2) {
        errorLabel.textContent = "Veuillez sélectionner une deuxième date.";
    }

    if (date1 && date2) {
        document.getElementById("date1Input").value = date1;
        document.getElementById("date2Input").value = date2;

        if (date1 >= date2) {
            var date1Obj = new Date(date1);
            var date2Obj = new Date(date2);

            errorLabel.textContent = "Veuillez sélectionner une date plus grande que la première.";
            desactivateButton.disabled = true;
            differenceDays = 0;

            updateNbrAdultes();

            return false;
        } else {
            var date1Obj = new Date(date1);
            var date2Obj = new Date(date2);

            var differenceMs = date2Obj - date1Obj;
            differenceDays = Math.floor(differenceMs / (1000 * 60 * 60 * 24));

            errorLabel.textContent = "Nombre de nuits : " + differenceDays;

            // Réinitialisation des valeurs
            nbrNuitsAvril = 0;
            nbrNuitsMai = 0;
            nbrNuitsJuin = 0;
            nbrNuitsJuillet = 0;
            nbrNuitsAout = 0;
            nbrNuitsSeptembre = 0;

            // Mise à jour du nombre de nuits pour chaque mois
            for (var i = 1; i <= differenceDays; i++) {
                var currentDate = new Date(date1Obj.getTime() + i * 24 * 60 * 60 * 1000);
                month = currentDate.getMonth();

                switch (month) {
                    case 3: // Avril
                        nbrNuitsAvril++;
                        break;
                    case 4: // Mai
                        nbrNuitsMai++;
                        break;
                    case 5: // Juin
                        nbrNuitsJuin++;
                        break;
                    case 6: // Juillet
                        nbrNuitsJuillet++;
                        break;
                    case 7: // Août
                        nbrNuitsAout++;
                        break;
                    case 8: // Septembre
                        nbrNuitsSeptembre++;
                        break;
                    default:
                        break;
                }
            }

            moisDate1 = date1Obj.getMonth();
            moisDate2 = date2Obj.getMonth();

            if ((moisDate1 < 3 || moisDate1 > 8) || (moisDate2 < 3 || moisDate2 > 8)) {
                errorLabel.textContent = "Veuillez sélectionner des dates comprises entre avril et septembre.";
                desactivateButton.disabled = true;

                return false;
            } else {
                desactivateButton.disabled = false;
            }

            updatePrix();
            updateNbrEnfants(parseFloat(nbrAdultes.value)); // Ajout pour mettre à jour le nombre d'enfants
            septJours = Math.floor(differenceDays / 7);

            return true;
        }
    }
}

function updateNbrAdultes() {
    var emplacements = document.getElementById("emplacements");
    var nbrAdultes = document.getElementById("nbrAdultes");

    nbrAdultes.innerHTML = ""; // Ajout de cette ligne pour vider les options précédentes

    var selectedValue = emplacements.value;
    var variablePrix = "";

    if (selectedValue === "1") {
        for (i = 0; i < 7; i++) {
            nbrAdultes.innerHTML += "<option value=" + i + ">" + i + "</option>";
            maxOptionAdultes++;
        }

        if (differenceDays < 1) {
            variablePrix = 0;
        } else if (differenceDays > 1) {
            variablePrix = calculatePrixMobilHome(parseFloat(nbrAdultes.value));
        }
    } else if (selectedValue === "2") {
        for (i = 0; i < 11; i++) {
            nbrAdultes.innerHTML += "<option value=" + i + ">" + i + "</option>";
            maxOptionAdultes++;
        }

        if (differenceDays < 1) {
            variablePrix = 0;
        } else {
            variablePrix = calculatePrixTente(parseFloat(nbrAdultes.value));
        }
    } else if (selectedValue === "3") {
        for (i = 0; i < 11; i++) {
            nbrAdultes.innerHTML += "<option value=" + i + ">" + i + "</option>";
            maxOptionAdultes++;
        }

        if (differenceDays < 1) {
            variablePrix = 0;
        } else {
            variablePrix = calculatePrixCampingCar(parseFloat(nbrAdultes.value));
        }
    }

    // Mettre à jour la valeur du champ de formulaire caché
    document.getElementById("selectedValueInput").value = selectedValue;

    var variablePrixLabel = document.getElementById("prix");
    variablePrixLabel.textContent = "Prix : " + variablePrix + " €";
}

function calculatePrixMobilHome(nbrAdultesPrix) {
    if (differenceDays === 0) {
        return 0;
    }

    var prix1 = 0;
    var prix2 = 0;
    var prix3 = 0;

    if (nbrNuitsAvril !== 0 || nbrNuitsSeptembre !== 0) {
        prix1 = (60 + (0.2 * nbrAdultesPrix)) * (nbrNuitsAvril + nbrNuitsSeptembre) + 20;
    }
    if (nbrNuitsMai !== 0 || nbrNuitsJuin !== 0) {
        if (differenceDays < 5) {
            prix2 = (70 + (0.2 * nbrAdultesPrix)) * (nbrNuitsMai + nbrNuitsJuin) + 20;
        } else if (differenceDays < 7) {
            prix2 = (70 + (0.2 * nbrAdultesPrix)) * (nbrNuitsMai + nbrNuitsJuin) + 30;
        } else if (differenceDays === 7) {
            prix2 = (70 + (0.2 * nbrAdultesPrix)) * (nbrNuitsMai + nbrNuitsJuin) + 10;
        } else if (differenceDays > 7) {
            prix2 = (71 + (0.2 * nbrAdultesPrix)) * (nbrNuitsMai + nbrNuitsJuin) + 10;
        }
    }
    if (nbrNuitsJuillet !== 0 || nbrNuitsAout !== 0) {
        if (differenceDays < 4) {
            prix3 = (84 + (0.2 * nbrAdultesPrix)) * (nbrNuitsJuillet + nbrNuitsAout) + 6;
        } else if (differenceDays === 4) {
            prix3 = (85 + (0.2 * nbrAdultesPrix)) * (nbrNuitsJuillet + nbrNuitsAout);
        } else if (differenceDays === 5) {
            prix3 = (84 + (0.2 * nbrAdultesPrix)) * (nbrNuitsJuillet + nbrNuitsAout);
        } else if (differenceDays === 6) {
            prix3 = (83 + (0.2 * nbrAdultesPrix)) * (nbrNuitsJuillet + nbrNuitsAout) + 2;
        } else if (differenceDays > 6) {
            prix3 = (80 + (0.2 * nbrAdultesPrix)) * (nbrNuitsJuillet + nbrNuitsAout);
        }
    }

    var prix = prix1 + prix2 + prix3;
    document.getElementById("prixInput").value = prix;
    document.getElementById("nbrEnfantsM12Input").value = nbrEnfantsM12Prix;
    document.getElementById("nbrEnfantsP12Input").value = nbrEnfantsP12Prix;
    return prix.toFixed(2); // Formate le nombre avec 2 décimales après la virgule
}

function calculatePrixTente(nbrAdultesPrix) {
    if (differenceDays === 0) {
        return 0;
    }
    var prix = (5 + 4 * (nbrAdultesPrix + nbrEnfantsP12Prix) + 2 * nbrEnfantsM12Prix + valeurElectricite + valeurVehicule + valeurAnimaux) * (differenceDays - septJours) + taxeSejour * nbrAdultesPrix * differenceDays;
    // console.log("Valeur de slectedOption : " + nbrAdultesPrix + ". Valeur differenceDays :" + differenceDays + ". Valeur nbrEnfantsM12Prix :" + nbrEnfantsM12Prix);

    document.getElementById("prixInput").value = prix;
    document.getElementById("nbrEnfantsM12Input").value = nbrEnfantsM12Prix;
    document.getElementById("nbrEnfantsP12Input").value = nbrEnfantsP12Prix;
    return prix.toFixed(2);
}

function calculatePrixCampingCar(nbrAdultesPrix) {
    if (differenceDays === 0) {
        return 0;
    }
    var prix = (8 + 4 * (nbrAdultesPrix + nbrEnfantsP12Prix) + 2 * nbrEnfantsM12Prix + valeurElectricite + valeurVehicule + valeurAnimaux) * (differenceDays - septJours) + taxeSejour * nbrAdultesPrix * differenceDays;
    document.getElementById("prixInput").value = prix;
    document.getElementById("nbrEnfantsM12Input").value = nbrEnfantsM12Prix;
    document.getElementById("nbrEnfantsP12Input").value = nbrEnfantsP12Prix;
    return prix.toFixed(2);
}

function calculatePrix(nbrAdultesPrix, selectedValue) {
    if (selectedValue === "1") {
        return calculatePrixMobilHome(nbrAdultesPrix);
    } else if (selectedValue === "2") {
        return calculatePrixTente(nbrAdultesPrix);
    } else if (selectedValue === "3") {
        return calculatePrixCampingCar(nbrAdultesPrix);
    } else {
        return 0;
    }
}

function updatePrix() {
    var emplacements = document.getElementById("emplacements");
    var nbrAdultes = document.getElementById("nbrAdultes");
    var nbrAdultesPrix = parseFloat(nbrAdultes.value);
    var selectedValue = emplacements.value;
    var variablePrix = 0;
    var variablePrixLabel = document.getElementById("prix");
    var desactivateButton = document.getElementById("desactivateButton");
    var errorLabel = document.getElementById("errorLabel");

    if (selectedValue === "1" && differenceDays === 1) {
        desactivateButton.disabled = true;
        errorLabel.textContent = "Veuillez réserver au moins 2 jours en mobil-home.";
        variablePrix = "(2 jours minimum)";
        variablePrixLabel.textContent = "Prix : " + variablePrix + " €";
    } else {
        variablePrix = calculatePrix(nbrAdultesPrix, selectedValue);
        variablePrixLabel.textContent = "Prix : " + variablePrix + " €";

        if (differenceDays > 1 && nbrAdultesPrix == 0) {
            messageMaxPersons.textContent = "Veuillez sélectionner au moins 1 adulte.";
            desactivateButton.disabled = true;
        } else {
            // Réinitialiser le message
            messageMaxPersons.textContent = "";
            desactivateButton.disabled = false;
        }
    }
    document.getElementById("nbrAdultesPrixInput").value = nbrAdultesPrix;
    nbrAdultesConditions = nbrAdultesPrix;
}

var nbrEnfantsM12 = document.getElementById("nbrEnfantsM12");
nbrEnfantsM12.innerHTML = "";

function updateNbrEnfants() {
    var nbrEnfantsM12 = document.getElementById("nbrEnfantsM12");
    var nbrEnfantsP12 = document.getElementById("nbrEnfantsP12");
    var selectedValuenbrEnfantsM12 = parseFloat(nbrEnfantsM12.value);
    var selectedValuenbrEnfantsP12 = parseFloat(nbrEnfantsP12.value);

    nbrEnfantsM12.innerHTML = "";
    nbrEnfantsP12.innerHTML = "";

    // Boucle pour nbrEnfantsM12
    for (var i = 0; i < maxOptionAdultes; i++) {
        var optionM12 = document.createElement("option");
        optionM12.value = i;
        optionM12.textContent = i;

        if (i === selectedValuenbrEnfantsM12) {
            optionM12.selected = true;
            nbrEnfantsM12Prix = i; // Stocke la valeur sélectionnée dans nbrEnfantsM12Prix
        }

        nbrEnfantsM12.appendChild(optionM12);
    }

    // Boucle pour nbrEnfantsP12
    for (var i = 0; i < maxOptionAdultes; i++) {
        var optionP12 = document.createElement("option");
        optionP12.value = i;
        optionP12.textContent = i;

        if (i === selectedValuenbrEnfantsP12) {
            optionP12.selected = true;
            nbrEnfantsP12Prix = i; // Stocke la valeur sélectionnée dans nbrEnfantsP12Prix
        }

        nbrEnfantsP12.appendChild(optionP12);
    }

    nbrEnfantsM12Prix = selectedValuenbrEnfantsM12;
    nbrEnfantsP12Prix = selectedValuenbrEnfantsP12;

    updatePrix();
}

// Appel de la fonction updateNbrEnfants au chargement de la page
window.onload = function () {
    updateNbrEnfants();
};

// Désactive le bouton au chargement de la page
window.onload = function () {
    desactivateButton.disabled = true;
};

// Écouter les changements dans le premier select
var emplacements = document.getElementById("emplacements");

// Écouter les changements dans la liste déroulante nbrEnfantsM12
nbrEnfantsM12.addEventListener("change", function () {
    updateNbrEnfants();

    if (emplacements.value === "1" && (nbrAdultesConditions + nbrEnfantsM12Prix + nbrEnfantsP12Prix) > 6) {
        // Afficher le message correspondant
        messageMaxPersons.textContent = "6 personnes maximum dans un mobil-home.";
        desactivateButton.disabled = true;
    } else {
        // Réinitialiser le message
        messageMaxPersons.textContent = "";
        desactivateButton.disabled = false;
    }

    updateMoisInvalides();
});

var nbrEnfantsP12 = document.getElementById("nbrEnfantsP12");

nbrEnfantsP12.addEventListener("change", function () {
    updateNbrEnfants();

    if (emplacements.value === "1" && (nbrAdultesConditions + nbrEnfantsM12Prix + nbrEnfantsP12Prix) > 6) {
        // Afficher le message correspondant
        messageMaxPersons.textContent = "6 personnes maximum dans un mobil-home.";
        desactivateButton.disabled = true;
    } else {
        // Réinitialiser le message
        messageMaxPersons.textContent = "";
        desactivateButton.disabled = false;
    }

    updateMoisInvalides();
});

// Appel initial pour mettre à jour les options de l'autre select au chargement de la page
updateNbrAdultes();

emplacements.addEventListener("change", function () {
    if (emplacements.value === "1" && (nbrAdultesConditions + nbrEnfantsM12Prix + nbrEnfantsP12Prix) > 6) {
        // Afficher le message correspondant
        messageMaxPersons.textContent = "6 personnes maximum dans un mobil-home.";
        desactivateButton.disabled = true;
    } else {
        // Réinitialiser le message
        messageMaxPersons.textContent = "";
        desactivateButton.disabled = false;
    }
    maxOptionAdultes = -1;
    updateNbrAdultes();
    checkDates();
    updateMoisInvalides();
});

// Écouter les changements dans le deuxième select
var nbrAdultes = document.getElementById("nbrAdultes");
nbrAdultes.addEventListener("change", function () {
    var nbrAdultesPrix = parseFloat(nbrAdultes.value);
    updatePrix();
    updateNbrEnfants(nbrAdultesPrix);

    if (nbrAdultesPrix === 0) {
        desactivateButton.disabled = true;
    } else {
        desactivateButton.disabled = false;
    }

    if (emplacements.value === "1" && (nbrAdultesConditions + nbrEnfantsM12Prix + nbrEnfantsP12Prix) > 6) {
        // Afficher le message correspondant
        messageMaxPersons.textContent = "6 personnes maximum dans un mobil-home.";
        desactivateButton.disabled = true;
    } else {
        // Réinitialiser le message
        messageMaxPersons.textContent = "";
        desactivateButton.disabled = false;
    }

    updateMoisInvalides();
    console.log("Avril : " + nbrNuitsAvril + ". Mai : " + nbrNuitsMai + ". Juin : " + nbrNuitsJuin + ". Juillet : " + nbrNuitsJuillet + ". Aout : " + nbrNuitsAout + ". Septembre : " + nbrNuitsSeptembre);
});

// Écouter les changements dans le champ de date
var date1 = document.getElementById("date1");
date1.addEventListener("change", function () {
    checkDates();
    updateElectricite();
    updateVehicule();

    if (nbrAdultesConditions === 0) {
        desactivateButton.disabled = true;
    } else {
        desactivateButton.disabled = false;
    }

    updateMoisInvalides();
});

// Écouter les changements dans le champ de date
var date2 = document.getElementById("date2");
date2.addEventListener("change", function () {
    checkDates();

    if (nbrAdultesConditions === 0) {
        desactivateButton.disabled = true;
    } else {
        desactivateButton.disabled = false;
    }

    updateMoisInvalides();
});

var electriciteSelect = document.getElementById("electriciteSelect"); // Renommage de la variable pour éviter la confusion

electriciteSelect.addEventListener("change", function () {
    updateElectricite();
    updatePrix();
    updateMoisInvalides();
});

function updateElectricite() {
    if (electriciteSelect.value === "non") { // Utilisation de electriciteSelect.value pour accéder à la valeur sélectionnée
        valeurElectricite = 0;
    } else if (electriciteSelect.value === "oui") {
        valeurElectricite = 3;
    }
    document.getElementById("electriciteInput").value = valeurElectricite;
}

var nbrEnfantsM12 = document.getElementById("nbrEnfantsM12");

document.getElementById("vehiculeInput").value = nbrEnfantsM12.value;


var vehiculeSelect = document.getElementById("vehiculeSelect"); // Renommage de la variable pour éviter la confusion

vehiculeSelect.addEventListener("change", function () {
    updateVehicule();
    updatePrix();
    updateMoisInvalides();
});

function updateVehicule() {
    if (vehiculeSelect.value === "non") { // Utilisation de vehiculeSelect.value pour accéder à la valeur sélectionnée
        valeurVehicule = 0;
    } else if (vehiculeSelect.value === "oui") {
        valeurVehicule = 2;
    }
    document.getElementById("vehiculeInput").value = valeurVehicule;
}


var nbrAnimauxSelect = document.getElementById("nbrAnimauxSelect");

nbrAnimauxSelect.addEventListener("change", function () {
    valeurAnimaux = parseInt(nbrAnimauxSelect.value) * 2;
    updatePrix();
    updateMoisInvalides();

    document.getElementById("nbrAnimauxInput").value = parseInt(nbrAnimauxSelect.value);
});

function updateMoisInvalides() {
    var moisDate1 = (new Date(date1)).getMonth();
    var moisDate2 = (new Date(date2)).getMonth();

    if ((moisDate1 < 3 || moisDate1 > 8) || (moisDate2 < 3 || moisDate2 > 8)) {
        errorLabel.textContent = "Veuillez sélectionner des dates comprises entre avril et septembre.";
        desactivateButton.disabled = true;

        return false;
    } else {
        desactivateButton.disabled = false;
    }
}
