<?php
require "bdd.php";


if (isset($_POST['deleteDemandes'])) {
    // Sélectionner les ID des réservations à supprimer
    $selectQuery = "SELECT id FROM reservation WHERE dateSortie < DATE_SUB(NOW(), INTERVAL 2 MONTH)";
    $selectStatement = $bdd->prepare($selectQuery);
    $selectStatement->execute();
    $reservations = $selectStatement->fetchAll(PDO::FETCH_ASSOC);

    // Supprimer les éléments de la table "info_reservation" liés aux réservations
    foreach ($reservations as $reservation) {
        $deleteInfoQuery = "DELETE FROM info_reservation WHERE reservation_id = :reservationId";
        $deleteInfoStatement = $bdd->prepare($deleteInfoQuery);
        $deleteInfoStatement->bindValue(':reservationId', $reservation['id']);
        $deleteInfoStatement->execute();
    }

    // Supprimer les réservations de la table "reservation"
    $deleteQuery = "DELETE FROM reservation WHERE dateSortie < DATE_SUB(NOW(), INTERVAL 2 MONTH)";
    $deleteStatement = $bdd->prepare($deleteQuery);
    $deleteStatement->execute();

    header("Location: adminMenu.php");
    exit();
}

if (isset($_POST['deleteDemandesValide'])) {
    // Sélectionner les ID des réservations validées à supprimer
    $selectQuery = "SELECT id FROM reservation WHERE etat = 'Validé'";
    $selectStatement = $bdd->prepare($selectQuery);
    $selectStatement->execute();
    $reservations = $selectStatement->fetchAll(PDO::FETCH_ASSOC);

    // Supprimer les éléments de la table "info_reservation" liés aux réservations validées
    foreach ($reservations as $reservation) {
        $deleteInfoQuery = "DELETE FROM info_reservation WHERE reservation_id = :reservationId";
        $deleteInfoStatement = $bdd->prepare($deleteInfoQuery);
        $deleteInfoStatement->bindValue(':reservationId', $reservation['id']);
        $deleteInfoStatement->execute();
    }

    // Supprimer les réservations validées de la table "reservation"
    $deleteQuery = "DELETE FROM reservation WHERE etat = 'Validé'";
    $deleteStatement = $bdd->prepare($deleteQuery);
    $deleteStatement->execute();

    header("Location: adminMenu.php");
    exit();
}

if (isset($_POST['deleteDemandesRefuse'])) {
    // Sélectionner les ID des réservations validées à supprimer
    $selectQuery = "SELECT id FROM reservation WHERE etat = 'Refusé'";
    $selectStatement = $bdd->prepare($selectQuery);
    $selectStatement->execute();
    $reservations = $selectStatement->fetchAll(PDO::FETCH_ASSOC);

    // Supprimer les éléments de la table "info_reservation" liés aux réservations validées
    foreach ($reservations as $reservation) {
        $deleteInfoQuery = "DELETE FROM info_reservation WHERE reservation_id = :reservationId";
        $deleteInfoStatement = $bdd->prepare($deleteInfoQuery);
        $deleteInfoStatement->bindValue(':reservationId', $reservation['id']);
        $deleteInfoStatement->execute();
    }

    // Supprimer les réservations validées de la table "reservation"
    $deleteQuery = "DELETE FROM reservation WHERE etat = 'Refusé'";
    $deleteStatement = $bdd->prepare($deleteQuery);
    $deleteStatement->execute();

    header("Location: adminMenu.php");
    exit();
}

$sql = "SELECT * FROM reservation WHERE etat IS NULL OR etat = ''";
$stmt = $bdd->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$notifReservations = $notifReservations = $stmt->rowCount();
?>