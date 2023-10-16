<?php
require "../bdd.php";

$sql = "SELECT * FROM reservation WHERE etat = '' OR etat = 'Validé'";
$stmt = $bdd->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['menu'])) {
    header("Location: ../adminMenu.php");
    exit();
}
?>
