<?php
require "../bdd.php";


// Vérifier si l'ID de réservation est présent dans la requête POST
if (isset($_POST['idReservation'])) {
    $idReservation = $_POST['idReservation'];

    // Assurez-vous d'ajuster les noms de table et de colonne selon votre schéma de base de données
    $sql = "UPDATE reservation SET etat = 'Refusé', numeroEmplacement = '' WHERE id = :idReservation";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':idReservation', $idReservation);
    $stmt->execute();

    // Rediriger vers la page d'administration des réservations après le traitement
    header("Location: reservationValide.php");
    exit();
} else {
    // Rediriger vers une page d'erreur ou une autre page appropriée si l'ID de réservation n'est pas présent
    header("Location: ../error.php");
    exit();
}
?>