<?php
require "../bdd.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['submit'])) {

    session_start();

    $userId = 0;
    $typeEmplacement = $_POST['typeEmplacement'];
    $nbrAdultes = $_POST['nbrAdultes'];
    $nbrEnfantsM12 = $_POST['nbrEnfantsM12'];
    $nbrEnfantsP12 = $_POST['nbrEnfantsP12'];
    $electricite = $_POST['electricite'];
    $vehicule = $_POST['vehicule'];
    $nbrAnimaux = $_POST['nbrAnimaux'];
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
    $prix = $_POST['prix'];
    $etat = $_POST['etat'];
    $numEmplacement = $_POST['numEmplacement'];
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $phoneCountry = $_POST['phoneCountry'];
    $phone = $_POST['phone'];

    if (strtotime($date2) > strtotime($date1)) {
        if (empty($vehicule)) {
            $vehicule = "Non";
        }
        if (empty($phoneCountry)) {
            $phoneCountry = "";
        }

        // Convertir les textes en objets DateTime
        $date10 = DateTime::createFromFormat('d-m-Y', $date1);
        $date20 = DateTime::createFromFormat('d-m-Y', $date2);
        // Convertir en bon format de date
        $date100 = date_format($date10, "Y-m-d");
        $date200 = date_format($date20, "Y-m-d");

        $dateReservation = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $dateReservationFormatted = $dateReservation->format('Y-m-d H:i:s');

        if ($etat == "Validé" && empty($numEmplacement)) {
            $_SESSION['msg'] = "Veuillez entrer un numéro d'emplacement.";

            header("Location: createReservationPage.php");
            exit();
        } else {

            $sql = "INSERT INTO `reservation`
            (`user_id`, `dateReservation`, `typeEmplacement`, `nbrAdultes`, `nbrEnfantsM12`, `nbrEnfantsP12`, `electricite`, `vehicule`,
            `nbrAnimaux`, `dateEntree`, `dateSortie`, `prix`, `etat`, `numeroEmplacement`) VALUES (:userId, :dateReservation, :typeEmplacement,
            :nbrAdultes, :nbrEnfantsM12, :nbrEnfantsP12, :electricite, :vehicule, :nbrAnimaux, :date1, :date2, :prix, :etat, :numEmplacement)";

            $query = $bdd->prepare($sql);
            $query->bindParam(':userId', $userId, PDO::PARAM_INT);
            $query->bindParam(':dateReservation', $dateReservationFormatted, PDO::PARAM_STR);
            $query->bindParam(':typeEmplacement', $typeEmplacement, PDO::PARAM_STR);
            $query->bindParam(':nbrAdultes', $nbrAdultes, PDO::PARAM_INT);
            $query->bindParam(':nbrEnfantsM12', $nbrEnfantsM12, PDO::PARAM_INT);
            $query->bindParam(':nbrEnfantsP12', $nbrEnfantsP12, PDO::PARAM_INT);
            $query->bindParam(':electricite', $electricite, PDO::PARAM_STR);
            $query->bindParam(':vehicule', $vehicule, PDO::PARAM_STR);
            $query->bindParam(':nbrAnimaux', $nbrAnimaux, PDO::PARAM_INT);
            $query->bindParam(':date1', $date100, PDO::PARAM_STR);
            $query->bindParam(':date2', $date200, PDO::PARAM_STR);
            $query->bindParam(':prix', $prix, PDO::PARAM_STR);
            $query->bindParam(':etat', $etat, PDO::PARAM_STR);
            $query->bindParam(':numEmplacement', $numEmplacement, PDO::PARAM_STR);
            $query->execute();

            // Obtenir l'ID de la dernière réservation insérée
            $reservationId = $bdd->lastInsertId();

            $sql2 = "INSERT INTO `info_reservation` (`reservation_id`, `name2`, `mail2`, `phoneCountry2`, `phone2`) VALUES (:reservationId, :name, :mail,'+' :phoneCountry, :phone)";

            $query2 = $bdd->prepare($sql2);
            $query2->bindParam(':reservationId', $reservationId, PDO::PARAM_INT);
            $query2->bindParam(':name', $name, PDO::PARAM_STR);
            $query2->bindParam(':mail', $mail, PDO::PARAM_STR);
            $query2->bindParam(':phoneCountry', $phoneCountry, PDO::PARAM_STR);
            $query2->bindParam(':phone', $phone, PDO::PARAM_INT);
            $query2->execute();

            $_SESSION['msg'] = "La réservation a été enregistrée.";

            header("Location: createReservationPage.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = "Veuillez sélectionner une deuxième date plus grande que la première.";
        header("Location: createReservationPage.php");
        exit();
    }
}
?>