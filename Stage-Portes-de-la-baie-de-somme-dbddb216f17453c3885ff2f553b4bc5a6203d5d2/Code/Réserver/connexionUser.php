<?php
require_once "bdd.php";
session_start();

$mail = $_POST['mail'];
$password = $_POST['password'];

// Vérifier le nombre de tentatives de connexion
$loginAttempts = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] : 0;

if ($loginAttempts >= 5) {
    // Récupérer la date de blocage actuelle de l'utilisateur
    $sqlLockout = "SELECT lockout_time FROM `user` WHERE `mail` = :mail";
    $queryLockout = $bdd->prepare($sqlLockout);
    $queryLockout->bindValue(':mail', $mail);
    $queryLockout->execute();
    $lockoutTime = $queryLockout->fetchColumn();

    // Vérifier si le délai est écoulé depuis le blocage
    $currentDateTime = new DateTime('now', new DateTimeZone('Europe/Paris'));

    if (!empty($lockoutTime)) {
        $lockoutDateTime = new DateTime($lockoutTime, new DateTimeZone('Europe/Paris'));

        // En minutes
        $interval = new DateInterval('PT10M');
        $lockoutDateTime->add($interval);

        // En heures
        //$interval = new DateInterval('PT1H');
        //$lockoutDateTime->add($interval);

        if ($lockoutDateTime > $currentDateTime) {
            // Le délai n'est pas encore écoulé, afficher un message d'erreur
            $remainingTime = $lockoutDateTime->diff($currentDateTime)->format('%i minute(s) et %s seconde(s)');
            $_SESSION['error_message'] = "Trop de tentatives de connexion. Veuillez réessayer dans $remainingTime.";
            header("Location: index.php");
            exit();
        }
    }

    // Le délai est écoulé, réinitialiser le nombre de tentatives de connexion et le temps de blocage
    unset($_SESSION['login_attempts']);

    $sqlResetLockout = "UPDATE `user` SET `login_attempts` = 0, `lockout_time` = NULL WHERE `mail` = :mail";
    $queryResetLockout = $bdd->prepare($sqlResetLockout);
    $queryResetLockout->bindValue(':mail', $mail);
    $queryResetLockout->execute();
}

// Commande SQL pour vérifier les informations de connexion
$sql = "SELECT * FROM `user` WHERE `mail` = :mail";
$query = $bdd->prepare($sql);
$query->bindValue(':mail', $mail);
$query->execute();

// Récupérer les informations de l'utilisateur
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Authentification réussie, réinitialiser le nombre de tentatives de connexion
    unset($_SESSION['login_attempts']);

    // Stocker l'ID de l'utilisateur dans la session
    $_SESSION['id_utilisateur'] = $user['id'];

    // Stocker les informations de l'utilisateur dans la session
    $_SESSION['utilisateur'] = $user;

    if ($user['isAdmin'] == 1) {
        // Rediriger vers la page réservée aux administrateurs
        header("Location: adminMenu.php");
    } else {
        // Rediriger vers la page de réservation normale
        header("Location: reservationPage.php");
    }
    exit();
} else {
    // Identifiants invalides, afficher un message d'erreur
    $_SESSION['identifiantsInvalides'] = "Identifiants invalides.";

    // Incrémenter le nombre de tentatives de connexion
    $_SESSION['login_attempts'] = $loginAttempts + 1;

    // Mettre à jour le nombre de tentatives de connexion et le temps de blocage dans la base de données
    $lockoutTimeParis = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $lockoutTimeParisFormatted = $lockoutTimeParis->format('Y-m-d H:i:s');

    $sqlUpdate = "UPDATE `user` SET `login_attempts` = `login_attempts` + 1, `lockout_time` = :lockoutTime WHERE `mail` = :mail";
    $queryUpdate = $bdd->prepare($sqlUpdate);
    $queryUpdate->bindValue(':lockoutTime', $lockoutTimeParisFormatted, PDO::PARAM_STR);
    $queryUpdate->bindValue(':mail', $mail);
    $queryUpdate->execute();

    header("Location: index.php");
    exit();
}
?>