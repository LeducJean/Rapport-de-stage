<?php
require "bdd.php";


$sql = "SELECT * FROM reservation WHERE etat IS NULL OR etat = ''";
$stmt = $bdd->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inverser l'ordre des éléments du tableau
// $reversedResults = array_reverse($results);

if (isset($_POST['menu'])) {
    header("Location: adminMenu.php");
    exit();
}
?>