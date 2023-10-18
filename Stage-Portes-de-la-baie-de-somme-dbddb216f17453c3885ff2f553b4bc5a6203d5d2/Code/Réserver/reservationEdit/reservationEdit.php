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

require "reservationEditAff.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>

    <link rel="stylesheet" href="../css/style-adminReservationAll.css">
    <link rel="stylesheet" href="../css/style-adminReservation.css">
</head>

<body>

    <form action="" method="post">
        <button type="submit" class="custom-btn btn-16 top-left-input textEnBlanc" name="deconnexion">Se
            déconnecter</button>
    </form>
    <form action="" method="post">
        <button type="submit" class="custom-btn btn-16 top-left-down textEnBlanc" name="menu">Menu</button>
    </form>

    <main>
        <div class="jumbotron centerTextReservation textEnBlanc">
            <h1>Modifier réservations</h1>
        </div>
        <div class="all">

            <div class="messageError">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    // Supprimer le message de la session
                    unset($_SESSION['msg']);
                }
                ?>
            </div>

            <section class="tableau">
                <div class="table-responsive-sm tableauPlusBas">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">ID
                                    réservation</th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Nom / Prénom
                                </th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Date
                                    d'entrée</th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Date de
                                    sortie</th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Nuits</th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Type
                                    d'emplacement</th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Adultes /
                                    Enfants(+12/-12)</th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Électricité
                                </th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Véhicule
                                </th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Animaux</th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Mail /
                                    Numéro téléphone
                                </th>
                                <th class="jumbotron textEnBlanc" style="vertical-align: middle;">Prix</th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Emplacement
                                </th>
                                <th class="jumbotron centerTextReservation textEnBlanc" style="vertical-align: middle;">Valider</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Boucle d'affichage des variables
                            // Stocker les résultats
                            foreach ($results as $row) {
                                $idReservation = $row['id'];
                                $idUser = $row['user_id'];
                                $typeEmplacement = $row['typeEmplacement'];
                                $nbrAdultes = $row['nbrAdultes'];
                                $nbrEnfantsM12 = $row['nbrEnfantsM12'];
                                $nbrEnfantsP12 = $row['nbrEnfantsP12'];
                                $electricite = $row['electricite'];
                                $vehicule = $row['vehicule'];
                                $nbrAnimaux = $row['nbrAnimaux'];
                                $dateEntree = $row['dateEntree'];
                                $dateSortie = $row['dateSortie'];
                                $prix = $row['prix'];
                                $numeroEmplacement = $row['numeroEmplacement'];

                                // Convertir les textes en objets DateTime
                                $date10 = DateTime::createFromFormat('Y-m-d', $dateEntree);
                                $date20 = DateTime::createFromFormat('Y-m-d', $dateSortie);
                                // Convertir en bon format de date
                                $date100 = date_format($date10, "d-m-Y");
                                $date200 = date_format($date20, "d-m-Y");

                                // Convertir les dates en objets DateTime
                                $depart = new DateTime($dateEntree);
                                $arrivee = new DateTime($dateSortie);
                                // Calculer la différence entre les dates
                                $diff = $depart->diff($arrivee);
                                // Récupérer le nombre de nuits
                                $nombreNuits = $diff->days;

                                if ($idUser == 0) {
                                    $sql = "SELECT info_reservation.name2, info_reservation.mail2, info_reservation.phoneCountry2, info_reservation.phone2 
                                            FROM info_reservation 
                                            WHERE info_reservation.reservation_id = :reservationId";
                                    $stmt = $bdd->prepare($sql);
                                    $stmt->bindParam(':reservationId', $idReservation);
                                    $stmt->execute();
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $nomUtilisateur = $result['name2'];
                                    $mail = $result['mail2'];
                                    $phoneCountry = $result['phoneCountry2'];
                                    $phone = $result['phone2'];
                                } else {
                                    $sql = "SELECT user.name, user.mail, user.phoneCountry, user.phone 
                                            FROM reservation 
                                            JOIN user ON reservation.user_id = user.id 
                                            WHERE reservation.id = :reservationId";
                                    $stmt = $bdd->prepare($sql);
                                    $stmt->bindParam(':reservationId', $idReservation);
                                    $stmt->execute();
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $nomUtilisateur = $result['name'];
                                    $mail = $result['mail'];
                                    $phoneCountry = $result['phoneCountry'];
                                    $phone = $result['phone'];
                                }
                                ?>
                                <form action="traitementValider.php" method="post">
                                    <tr>
                                        <td class="centerTextReservation">
                                            <?php echo $idReservation; ?>
                                        </td>
                                        <td class="centerTextReservation">
                                            <?php echo $nomUtilisateur; ?>
                                        </td>
                                        <td class="centerTextReservation">
                                            <input class="largeS" name="date1" type="text" value="<?php echo $date100; ?>">
                                        </td>
                                        <td class="centerTextReservation">
                                            <input class="largeS" name="date2" type="text" value="<?php echo $date200; ?>">
                                        </td>
                                        <td class="centerTextReservation">
                                            <?php echo $nombreNuits; ?>
                                        </td>
                                        <td class="centerTextReservation">
                                            <select name="typeEmplacement">
                                                <option value="Mobil-home" <?php if ($typeEmplacement == "Mobil-home")
                                                    echo "selected"; ?>>Mobil-home</option>
                                                <option value="Tente/Caravane" <?php if ($typeEmplacement == "Tente/Caravane")
                                                    echo "selected"; ?>>Tente/Caravane</option>
                                                <option value="Camping-Car" <?php if ($typeEmplacement == "Camping-Car")
                                                    echo "selected"; ?>>Camping-car</option>
                                            </select>
                                        </td>
                                        <td class="centerTextReservation">
                                            <input class="largeXS" name="nbrAdultes" type="text"
                                                value="<?php echo $nbrAdultes; ?>">
                                            /
                                            <input class="largeXS" name="nbrEnfantsP12" type="text"
                                                value="<?php echo $nbrEnfantsP12; ?>">
                                            /
                                            <input class="largeXS" name="nbrEnfantsM12" type="text"
                                                value="<?php echo $nbrEnfantsM12; ?>">
                                        </td>
                                        <td class="centerTextReservation">
                                            <select name="electricite">
                                                <option value="Oui" <?php if ($electricite == "Oui")
                                                    echo "selected"; ?>>Oui</option>
                                                <option value="Non" <?php if ($electricite == "Non")
                                                    echo "selected"; ?>>Non</option>
                                            </select>
                                        </td>
                                        <td class="centerTextReservation">
                                            <input class="largeXSS" name="vehicule" type="text"
                                                value="<?php echo $vehicule; ?>">
                                        </td>
                                        <td class="centerTextReservation">
                                            <input class="largeXS" name="nbrAnimaux" type="text"
                                                value="<?php echo $nbrAnimaux; ?>">
                                        </td>
                                        <td class="centerTextReservation">
                                            <?php echo $mail; ?>
                                            <p>
                                                <?php echo $phoneCountry . " " . $phone; ?>
                                            </p>
                                        </td>
                                        <td class="centerTextReservation">
                                            <div class="container">
                                                <input class="largeM" name="prix" type="text" value="<?php echo $prix; ?>">
                                                <span>€</span>
                                            </div>
                                        </td>
                                        <td class="centerTextReservation">
                                            <input class="largeXSS" name="numeroEmplacement" type="text"
                                                value="<?php echo $numeroEmplacement; ?>">
                                        </td>
                                        <td class="centerTextReservation">
                                            <input type="hidden" name="idReservation" value="<?php echo $idReservation; ?>">
                                            <button type="submit" class="btn btn-maj">Valider</button>
                                </form>
                                </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <script src=".js"></script>

</body>

</html>