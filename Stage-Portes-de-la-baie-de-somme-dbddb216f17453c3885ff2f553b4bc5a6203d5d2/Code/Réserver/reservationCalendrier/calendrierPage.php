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

require "calendrier.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>

    <link rel="stylesheet" href="../css/style-adminReservationAll.css">
    <link rel="stylesheet" href="../css/style-adminReservation.css">
    <link rel="stylesheet" href="../css/style-calendrier.css">
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
            <h1>Planning</h1>
        </div>

        <div class="all">
            <?php

            // Génération des dates du mois sous forme de tableau
            $dates = array();
            $dateCourante = clone $premierJour;
            while ($dateCourante <= $dernierJour) {
                $dates[] = clone $dateCourante;
                $dateCourante->modify('+1 day');
            }

            // Définir la locale en français
            setlocale(LC_TIME, 'fr_FR.UTF-8');

            // Tableau associatif des mois en français
            $moisEnFrancais = array(
                'January' => 'janvier',
                'February' => 'février',
                'March' => 'mars',
                'April' => 'avril',
                'May' => 'mai',
                'June' => 'juin',
                'July' => 'juillet',
                'August' => 'août',
                'September' => 'septembre',
                'October' => 'octobre',
                'November' => 'novembre',
                'December' => 'décembre'
            );

            // Récupérer le mois et l'année
            $mois = $moisEnFrancais[$premierJour->format('F')];
            $annee = $premierJour->format('Y');

            // Affichage du mois et de l'année au-dessus du planning
            echo '<div class="month-year">' . $mois . ' ' . $annee . '</div>';

            // Affichage du tableau du planning
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Emplacement</th>';

            // Affichage des dates (colonnes horizontales)
            foreach ($dates as $date) {
                echo '<th>' . $date->format('d') . '</th>';
            }

            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $previousEmplacement = null;
            $reservations = array();

            foreach ($results as $row) {
                // Récupérer les données de la réservation
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

                // Convertir les dates en objets DateTime
                $depart = new DateTime($dateEntree);
                $arrivee = new DateTime($dateSortie);
                // Calculer la différence entre les dates
                $diff = $depart->diff($arrivee);
                // Récupérer le nombre de nuits
                $nombreNuits = $diff->days;

                // Vérifier si la valeur de $numeroEmplacement a changé
                if ($numeroEmplacement != $previousEmplacement) {
                    if ($previousEmplacement !== null) {
                        // Afficher les réservations pour l'emplacement précédent
                        displayReservationsForEmplacement($reservations);
                    }

                    // Mettre à jour l'emplacement précédent et réinitialiser les réservations
                    $previousEmplacement = $numeroEmplacement;
                    $reservations = array();
                }

                // Ajouter la réservation au tableau correspondant à l'emplacement
                $reservations[$numeroEmplacement][] = array(
                    'dateEntree' => $dateEntree,
                    'dateSortie' => $dateSortie
                );
            }

            // Afficher les réservations pour le dernier emplacement
            displayReservationsForEmplacement($reservations);

            function displayReservationsForEmplacement($reservations)
            {
                global $dates;

                foreach ($reservations as $numeroEmplacement => $reservationDates) {
                    // Afficher une nouvelle ligne avec le numéro d'emplacement
                    echo '<tr>';
                    echo '<td>' . $numeroEmplacement . '</td>';

                    // Parcourir les dates pour chaque réservation et afficher les cases correspondantes
                    foreach ($dates as $date) {
                        $dateReservation = $date->format('Y-m-d');

                        $isReserved = false;
                        $isOverlap = false; // Variable pour vérifier la superposition des dates de réservation
            
                        foreach ($reservationDates as $reservationDate) {
                            $dateEntreeReservation = new DateTime($reservationDate['dateEntree']);
                            $dateSortieReservation = new DateTime($reservationDate['dateSortie']);

                            if ($dateReservation >= $dateEntreeReservation->format('Y-m-d') && $dateReservation <= $dateSortieReservation->format('Y-m-d')) {
                                $isReserved = true;

                                // Vérifier si la date de réservation se superpose à une autre réservation
                                foreach ($reservationDates as $otherReservationDate) {
                                    if ($otherReservationDate !== $reservationDate) {
                                        $otherDateEntree = new DateTime($otherReservationDate['dateEntree']);
                                        $otherDateSortie = new DateTime($otherReservationDate['dateSortie']);

                                        if ($dateReservation >= $otherDateEntree->format('Y-m-d') && $dateReservation <= $otherDateSortie->format('Y-m-d')) {
                                            $isOverlap = true;
                                            break;
                                        }
                                    }
                                }
                                break;
                            }
                        }
                        if ($isOverlap) {
                            echo '<td class="red"></td>'; // Case rouge pour une superposition de réservations
                        } elseif ($isReserved) {
                            echo '<td class="green"></td>'; // Case verte pour une période de réservation
                        } else {
                            echo '<td></td>'; // Case vide
                        }
                    }
                    echo '</tr>';
                }
            }
            ?>

            <form action="" method="post">
                <button type="submit" class="custom-btn btn-16 top-left-down moisSuivant custom-btn-top-right textEnBlanc"
                    name="suivant">Mois suivant</button>
                <button type="submit" class="custom-btn btn-16 top-left-down moisPrecedent custom-btn-top-right textEnBlanc"
                    name="precedent">Mois Précédent</button>
            </form>
        </div>

        <script src=".js"></script>

</body>

</html>