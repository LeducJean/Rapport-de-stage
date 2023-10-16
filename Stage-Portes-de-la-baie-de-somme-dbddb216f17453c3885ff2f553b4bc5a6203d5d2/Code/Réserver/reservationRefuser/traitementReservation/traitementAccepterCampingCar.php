<?php
require "../../bdd.php";

if (isset($_POST['valideCampingCar_' . $_POST["idReservation"]])) {
    $idReservation = $_POST["idReservation"];
    $numeroEmplacement = $_POST["valeur"];

    // Vérification que le champ "numeroEmplacement" n'est pas vide
    if (!empty($numeroEmplacement)) {
        // Sécurisation des données
        $idReservation = htmlspecialchars($idReservation); // Échappement des caractères spéciaux
        $numeroEmplacement = htmlspecialchars($numeroEmplacement);
        $numeroEmplacementMaj = strtoupper($numeroEmplacement);

        // Requête SQL pour mettre à jour la colonne "etat" et "numeroEmplacement"
        $requete = "UPDATE reservation SET etat = 'Validé', numeroEmplacement = :numeroEmplacement WHERE id = :idReservation";

        // Préparation de la requête avec des paramètres préparés
        $stmt = $bdd->prepare($requete);
        $stmt->bindValue(':numeroEmplacement', $numeroEmplacementMaj);
        $stmt->bindValue(':idReservation', $idReservation);

        // Exécution de la requête préparée
        if ($stmt->execute()) {
            // Redirection vers la page adminReservationAtt.php
            header("Location: ../reservationRefuse.php");
            exit();
        } else {
            // Gestion de l'erreur
            echo "Erreur lors de la mise à jour de la réservation : " . $stmt->errorInfo();
        }

        // Fermeture du curseur du statement
        $stmt->closeCursor();
    } else {
        // Le champ "numeroEmplacement" est vide, effectuer la redirection
        header("Location: ../reservationRefuse.php");
        exit();
    }
}
?>