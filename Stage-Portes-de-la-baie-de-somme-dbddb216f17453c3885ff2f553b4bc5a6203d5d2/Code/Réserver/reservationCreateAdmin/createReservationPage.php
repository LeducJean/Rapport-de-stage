<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il a les droits d'administrateur
if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['isAdmin'] == 0) {
    // Rediriger vers une page d'erreur ou de connexion
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['deconnexion'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['menu'])) {
    header("Location: ../adminMenu.php");
    exit();
}

require "createReservation.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
    <link rel="stylesheet" href="../css/style-createReservation.css">
</head>

<body>

    <link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
    <div class="main">
        <div class="all">

            <form action="" method="post">
                <button type="submit" class="custom-btn btn-16 top-left-input" name="deconnexion">Se
                    déconnecter</button>
                <button type="submit" class="custom-btn btn-16 top-left-down" name="menu">Menu</button>
            </form>


            <h1 class="center">Réservations</h1>


            <form action="createReservation.php" method="post">
                <div class="calendar">
                    <label for="date1"><a class="motDe">De</a></label>
                    <input name="date1" type="text" value="<?php echo date('d-m-Y'); ?>" required>
                    <label for="date2"><a class="lettreA">à</a></label>
                    <a class="date2CSS"><input name="date2" type="text" value="<?php echo date('d-m-Y'); ?>"
                            required></a>
                </div>

                <div class="rooms">
                    <div class="formroom">
                        Emplacements :
                        <select name="typeEmplacement" required>
                            <option value="Mobil-home">Mobil-home</option>
                            <option value="Tente/Caravane">Tente/Caravane</option>
                            <option value="Camping-Car">Camping-car</option>
                        </select>
                    </div>
                    <div class="formroom">
                        Adulte(s) <u>(18 ans et +)</u> :
                        <input type="text" name="nbrAdultes" class="small-input">
                    </div>
                    <div class="formroom">
                        Enfant(s) <u>(11 ans et -)</u> :
                        <input type="text" name="nbrEnfantsM12" class="small-input">
                    </div>
                    <div class="formroom">
                        Enfant(s) <u>(12 ans et +)</u> :
                        <input type="text" name="nbrEnfantsP12" class="small-input">
                    </div>
                </div>

                <div class="rooms">
                    <div class="formroom">
                        Électricité :
                        <select name="electricite">
                            <option value="Non">Non</option>
                            <option value="Oui">Oui</option>
                        </select>
                    </div>
                    <div class="formroom">
                        Véhicule :
                        <input type="text" name="vehicule" class="small-input">
                    </div>
                    <div class="formroom">
                        Nombres d'animaux :
                        <input type="text" name="nbrAnimaux" class="small-input">
                    </div>
                    <div class="formroom">
                        Numéro emplacement :
                        <input type="text" name="numEmplacement" class="small-input">
                    </div>
                </div>

                <div class="rooms">
                    <div class="formroom">
                        Nom / Prénom :
                        <input type="text" name="name"">
                    </div>
                    <div class=" formroom">
                        Mail :
                        <input type="text" name="mail"">
                    </div>
                    <div class=" formroom">
                        Téléphone :
                        <select name="phoneCountry">
                            <option disabled selected>+ ...</option>
                            <?php for ($i = 0; $i <= 99; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo " + " . $i; ?></option>
                            <?php } ?>
                        </select>
                        <input type="text" name="phone"">
                    </div>
                </div>

                <div class=" formroom">
                        <p></p>
                        Prix :
                        <input type="text" value="0.00" name="prix" class="small-input2">
                        État :
                        <select name="etat" required>
                            <option value="Validé">Validé</option>
                            <option value="">En attente</option>
                        </select>
                    </div>

                    <button type="submit" name="submit" class="buttonValider" id="desactivateButton">Valider
                        votre
                        réservation</button>

                    <div class="formroom"></div>

                    <a class="msgConfirmation">
                        <div class="msgErrorCreaReserva" style="color: red;">
                            <?php
                            if (isset($_SESSION['msg'])) {
                                echo $_SESSION['msg'];
                                // Supprimer le message de la session
                                unset($_SESSION['msg']);
                            }
                            ?>
                        </div>
                    </a>

            </form>

        </div>

    </div>

    <!-- partial -->
    <script src="../js/script-createReservation.js"></script>

</body>

</html>