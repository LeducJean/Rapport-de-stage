<?php
require "../bdd.php";

// Vérifier si l'ID de réservation est présent dans la requête POST
if (isset($_POST['idReservation'])) {
    session_start();

    $idReservation = $_POST['idReservation'];

    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
    // Convertir les textes en objets DateTime
    $date10 = DateTime::createFromFormat('d-m-Y', $date1);
    $date20 = DateTime::createFromFormat('d-m-Y', $date2);
    // Convertir en bon format de date
    $date100 = date_format($date10, "Y-m-d");
    $date200 = date_format($date20, "Y-m-d");

    // Vérifier la condition avant l'exécution de la requête
    if ($date100 < $date200) {
        $typeEmplacement = $_POST['typeEmplacement'];
        $nbrAdultes = $_POST['nbrAdultes'];
        $nbrEnfantsM12 = $_POST['nbrEnfantsM12'];
        $nbrEnfantsP12 = $_POST['nbrEnfantsP12'];
        $electricite = $_POST['electricite'];
        $vehicule = $_POST['vehicule'];
        $nbrAnimaux = $_POST['nbrAnimaux'];
        $prix = $_POST['prix'];
        $numeroEmplacement = $_POST['numeroEmplacement'];
        $etat = "Validé";

        $numeroEmplacement = htmlspecialchars($numeroEmplacement);
        $numeroEmplacementMaj = strtoupper($numeroEmplacement);

        if (!empty($numeroEmplacement)) {
            // Assurez-vous d'ajuster les noms de table et de colonne selon votre schéma de base de données
            $sql = "UPDATE reservation SET dateEntree = :date1, dateSortie = :date2, typeEmplacement = :typeEmplacement, nbrAdultes = :nbrAdultes, nbrEnfantsM12 = :nbrEnfantsM12, nbrEnfantsP12 = :nbrEnfantsP12, electricite = :electricite, vehicule = :vehicule, nbrAnimaux = :nbrAnimaux, prix = :prix, etat = :etat, numeroEmplacement = :numeroEmplacement WHERE id = :idReservation";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':date1', $date100);
            $stmt->bindParam(':date2', $date200);
            $stmt->bindParam(':typeEmplacement', $typeEmplacement);
            $stmt->bindParam(':nbrAdultes', $nbrAdultes);
            $stmt->bindParam(':nbrEnfantsM12', $nbrEnfantsM12);
            $stmt->bindParam(':nbrEnfantsP12', $nbrEnfantsP12);
            $stmt->bindParam(':electricite', $electricite);
            $stmt->bindParam(':vehicule', $vehicule);
            $stmt->bindParam(':nbrAnimaux', $nbrAnimaux);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':numeroEmplacement', $numeroEmplacementMaj);
            $stmt->bindParam(':etat', $etat);
            $stmt->bindParam(':idReservation', $idReservation);
            $stmt->execute();

            // Rediriger vers la page d'administration des réservations après le traitement
            header("Location: reservationEdit.php");
            exit();
        } else {
            $_SESSION['msg'] = "Veuillez entrer un numéro d'emplacement";
            header("Location: reservationEdit.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = "Veuillez sélectionner une deuxième date plus grande que la première.";
        header("Location: reservationEdit.php");
        exit();
    }
} else {
    // Rediriger vers une page d'erreur ou une autre page appropriée si l'ID de réservation n'est pas présent
    header("Location: ../error.php");
    exit();
}
?>
