<?php
require "bdd.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nbrAdultes = filter_input(INPUT_POST, 'nbrAdultesPrix', FILTER_VALIDATE_INT);
    $nbrEnfantsM12 = filter_input(INPUT_POST, 'nbrEnfantsM12', FILTER_VALIDATE_INT);
    $nbrEnfantsP12 = filter_input(INPUT_POST, 'nbrEnfantsP12', FILTER_VALIDATE_INT);
    $electricite = filter_input(INPUT_POST, 'electricite', FILTER_VALIDATE_INT);
    $vehicule = filter_input(INPUT_POST, 'vehicule', FILTER_VALIDATE_INT);
    $nbrAnimaux = filter_input(INPUT_POST, 'nbrAnimaux', FILTER_VALIDATE_INT);
    $date1 = filter_input(INPUT_POST, 'date1', FILTER_SANITIZE_STRING);
    $date2 = filter_input(INPUT_POST, 'date2', FILTER_SANITIZE_STRING);
    $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);

    // Récupérer la valeur de selectedValue
    $selectedValue = filter_input(INPUT_POST, 'selectedValue', FILTER_SANITIZE_STRING);

    if ($selectedValue == 1) {
        if (($nbrAdultes + $nbrEnfantsM12 + $nbrEnfantsP12) > 6) {
            $_SESSION['msg'] = "Veuillez sélectionner au maximum 6 personnes dans un mobil-home.";
            header("Location: reservationPage.php");
            exit();
        }
        $selectedValue = "Mobil-home";
    } else if ($selectedValue == 2) {
        $selectedValue = "Tente/Caravane";
    } else if ($selectedValue == 3) {
        $selectedValue = "Camping-Car";
    }

    if ($selectedValue === false || $nbrAdultes === false || $date1 === false || $date2 === false || $prix === false) {
        // Gestion des erreurs de validation des données
        $_SESSION['msg'] = "Les données de réservation sont invalides.";
        header("Location: reservationPage.php");
        exit();
    }

    if ($nbrAdultes === 0) {
        // Gestion des erreurs de validation des données
        $_SESSION['msg'] = "Veuillez sélectionner au moins 1 adulte.";
        header("Location: reservationPage.php");
        exit();
    }

    $electricite = ($electricite == 0) ? "Non" : "Oui";
    $vehicule = ($vehicule == 0) ? "Non" : "Oui";
    $nbrAnimaux = ($nbrAnimaux >= 1) ? $nbrAnimaux : 0;

    $userId = $_SESSION['id_utilisateur'];

    // Vérifier si l'utilisateur a déjà effectué trois réservations pour la date actuelle
    $dateReservation = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $dateReservationFormatted = $dateReservation->format('Y-m-d');

    $sqlCount = "SELECT COUNT(*) FROM `reservation` WHERE `user_id` = :userId AND DATE(`dateReservation`) = :dateReservation";
    $queryCount = $bdd->prepare($sqlCount);
    $queryCount->bindParam(':userId', $userId, PDO::PARAM_INT);
    $queryCount->bindParam(':dateReservation', $dateReservationFormatted, PDO::PARAM_STR);
    $queryCount->execute();
    $reservationCount = $queryCount->fetchColumn();

    if ($reservationCount >= 3) {
        $_SESSION['msg'] = "Vous avez atteint la limite de réservations pour aujourd'hui.";
        header("Location: reservationPage.php");
        exit();
    }

    $dateReservation = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $dateReservationFormatted = $dateReservation->format('Y-m-d H:i:s');

    $sql = "INSERT INTO `reservation`
    (`id`, `user_id`, `dateReservation`, `typeEmplacement`, `nbrAdultes`, `nbrEnfantsM12`, `nbrEnfantsP12`, `electricite`, `vehicule`, `nbrAnimaux`, `dateEntree`, `dateSortie`, `prix`)
    VALUES (NULL, :userId, :dateReservation, :selectedValue, :nbrAdultes, :nbrEnfantsM12, :nbrEnfantsP12, :electricite, :vehicule, :nbrAnimaux, :date1, :date2, :prix)";

    $query = $bdd->prepare($sql);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->bindParam(':dateReservation', $dateReservationFormatted, PDO::PARAM_STR);
    $query->bindParam(':selectedValue', $selectedValue, PDO::PARAM_STR);
    $query->bindParam(':nbrAdultes', $nbrAdultes, PDO::PARAM_INT);
    $query->bindParam(':nbrEnfantsM12', $nbrEnfantsM12, PDO::PARAM_INT);
    $query->bindParam(':nbrEnfantsP12', $nbrEnfantsP12, PDO::PARAM_INT);
    $query->bindParam(':electricite', $electricite, PDO::PARAM_STR);
    $query->bindParam(':vehicule', $vehicule, PDO::PARAM_STR);
    $query->bindParam(':nbrAnimaux', $nbrAnimaux, PDO::PARAM_INT);
    $query->bindParam(':date1', $date1, PDO::PARAM_STR);
    $query->bindParam(':date2', $date2, PDO::PARAM_STR);
    $query->bindParam(':prix', $prix, PDO::PARAM_STR);
    $query->execute();

    $_SESSION['msg'] = "Votre demande de réservation a été envoyée.";
    $_SESSION['msgInfo'] = "Veuillez vous attendre à un délai de 2 jours maximum pour avoir une réponse.";
    header("Location: reservationPage.php");
    exit();
}
?>
