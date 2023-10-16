<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver</title>
    <link rel="stylesheet" href="css/style-reservation.css">
</head>

<body>
    <?php
    session_start();

    // Vérifier si la session utilisateur existe
    if (!isset($_SESSION['utilisateur'])) {
        // Rediriger vers la page de connexion
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['deconnexion'])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    if (isset($_POST["submit"])) {
        require_once "reservation.php";
    }
    ?>


    <link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
    <div class="main">
        <div class="all">

            <form action="" method="post">
                <button type="submit" class="custom-btn btn-16 top-left-input" name="deconnexion">Se
                    déconnecter</button>
            </form>

            <h1 class="center">Réservations</h1>
            <div class="calendar">

                <form action="" name="dates" id="reservation">
                    De
                    <input type="date" id="date1" onchange="checkDates()" required>
                    à
                    <input type="date" id="date2" onchange="checkDates()" required>
                </form>

            </div>

            <div class="nbrNuitées">
                <span id="errorLabel" style="color: red;"></span>
                <span id="nbrNuits"></span>

                <p>
                    <span id="messageMaxPersons" style="color: red;"></span>
                </p>

            </div>

            <div class="rooms">
                <div class="formroom">
                    <form action="" name="chambres" id="chambres">
                        Emplacements :
                        <select id="emplacements">
                            <option value="1">Mobil-home</option>
                            <option value="2">Tente/Caravane</option>
                            <option value="3">Camping-car</option>
                        </select>
                    </form>
                </div>
                <div class="formroom">
                    <form action="" name="nbrAdultes">
                        Adulte(s) <u>(18 ans et +)</u> :
                        <select id="nbrAdultes" name="nbrAdultes"> <!-- Ajout de l'attribut "name" -->
                            <!-- Les options seront mises à jour dynamiquement via JavaScript -->
                        </select>
                    </form>
                </div>
                <div class="formroom">
                    <form action="" name="nbrEnfantsM12">
                        Enfant(s) <u>(11 ans et -)</u> :
                        <select id="nbrEnfantsM12" name="nbrEnfantsM12"> <!-- Ajout de l'attribut "name" -->
                            <!-- Les options seront mises à jour dynamiquement via JavaScript -->
                        </select>
                    </form>
                </div>
                <div class="formroom">
                    <form action="" name=nbrEnfantsP12">
                        Enfant(s) <u>(12 ans et +)</u> :
                        <select id="nbrEnfantsP12">
                            <!-- Les options seront mises à jour dynamiquement via JavaScript -->
                        </select>


                        <!-- Récupération de l'ID de l'utilisateur -->
                        <?php /* if (isset($_SESSION['id_utilisateur'])) { echo $_SESSION['id_utilisateur']; } */?>
                    </form>
                </div>
            </div>
            <div class="rooms">
                <div class="formroom">
                    <form action="" name="electricite" id="electricite">
                        Électricité :
                        <select id="electriciteSelect"> <!-- Ajout de l'ID "electriciteSelect" -->
                            <option value="non">Non</option>
                            <option value="oui">Oui</option>
                        </select>
                    </form>
                </div>
                <div class="formroom">
                    <form action="" name="vehicule" id="vehicule">
                        Véhicule :
                        <select id="vehiculeSelect"> <!-- Ajout de l'ID "vehiculeSelect" -->
                            <option value="non">Non</option>
                            <option value="oui">Oui</option>
                        </select>
                    </form>
                </div>
                <div class="formroom">
                    <form action="" name="nbrAnimaux">
                        Nombres d'animaux :
                        <select id="nbrAnimauxSelect">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </form>
                </div>
            </div>

            <form action="" method="POST" id="myForm">
                <!-- Ajoutez vos éléments existants ici -->
                <input type="hidden" name="selectedValue" id="selectedValueInput">
                <input type="hidden" name="nbrAdultesPrix" id="nbrAdultesPrixInput">
                <input type="hidden" name="nbrEnfantsM12" id="nbrEnfantsM12Input">
                <input type="hidden" name="nbrEnfantsP12" id="nbrEnfantsP12Input">
                <input type="hidden" name="electricite" id="electriciteInput">
                <input type="hidden" name="vehicule" id="vehiculeInput">
                <input type="hidden" name="nbrAnimaux" id="nbrAnimauxInput">
                <input type="hidden" name="date1" id="date1Input">
                <input type="hidden" name="date2" id="date2Input">
                <input type="hidden" name="prix" id="prixInput">

                <button type="submit" name="submit" class="buttonValider" id="desactivateButton" disabled>Valider votre
                    réservation</button>
            </form>

            <a class="prixReservation">
                <span id="prix"></span>
            </a>

            <a class="msgConfirmation">
                <div style="color: red;">
                    <?php if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        // Supprimer le message de la session
                        unset($_SESSION['msg']);
                    } ?>
                </div>
                <p></p>
                <?php if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msgInfo'];
                    // Supprimer le message de la session
                    unset($_SESSION['msgInfo']);
                } ?>
            </a>

        </div>

    </div>

    <!-- partial -->
    <script src="js/script-reservation.js"></script>

</body>

</html>