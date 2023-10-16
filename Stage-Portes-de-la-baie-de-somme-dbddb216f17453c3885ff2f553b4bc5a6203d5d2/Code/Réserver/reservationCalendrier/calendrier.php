<?php
require "../bdd.php";


$sql = "SELECT * FROM reservation WHERE etat IS NULL OR etat = 'Valide' ORDER BY CAST(numeroEmplacement AS UNSIGNED), numeroEmplacement";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inverser l'ordre des éléments du tableau
// $reversedResults = array_reverse($results);

if (isset($_POST['menu'])) {
    header("Location: ../adminMenu.php");
    exit();
}


// Obtention de la date actuelle
$dateActuelle = new DateTime();
$moisActuel = $dateActuelle->format('m');
$anneeActuelle = $dateActuelle->format('Y');

// Récupération des paramètres GET pour le mois et l'année
$mois = isset($_GET['mois']) ? $_GET['mois'] : $moisActuel;
$annee = isset($_GET['annee']) ? $_GET['annee'] : $anneeActuelle;

// Vérification de la validité de la date
if (!checkdate($mois, 1, $annee)) {
    $mois = $moisActuel;
    $annee = $anneeActuelle;
}

// Détermination du premier jour et du dernier jour du mois
$premierJour = new DateTime("$annee-$mois-01");
$dernierJour = new DateTime($premierJour->format('Y-m-t'));

// Boutons pour passer au mois précédent et au mois suivant
$moisPrecedent = ($mois > 1) ? $mois - 1 : 12;
$anneePrecedente = ($mois > 1) ? $annee : $annee - 1;
$moisSuivant = ($mois < 12) ? $mois + 1 : 1;
$anneeSuivante = ($mois < 12) ? $annee : $annee + 1;

if (isset($_POST["suivant"])) {
    header("Location: calendrierPage.php?mois=$moisSuivant&annee=$anneeSuivante");
    exit();
}
if (isset($_POST["precedent"])) {
    header("Location: calendrierPage.php?mois=$moisPrecedent&annee=$anneePrecedente");
    exit();
}
?>