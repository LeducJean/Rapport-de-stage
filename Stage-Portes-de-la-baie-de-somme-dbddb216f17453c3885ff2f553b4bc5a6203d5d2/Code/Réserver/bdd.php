<?php
$ipbdd = "localhost";
$usernamebdd = "root";
$passwordbdd = "";
$namebdd = "campinglesportesdelabaiedesomme";

try {
    $bdd = new PDO("mysql:host=$ipbdd;dbname=$namebdd;charset=utf8", $usernamebdd, $passwordbdd);
    // Activer le mode d'erreur PDO pour afficher les erreurs de requête
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>