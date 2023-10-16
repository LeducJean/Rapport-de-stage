<?php
require_once "bdd.php";

// Vérifier si le formulaire est soumis
if (isset($_POST['name'], $_POST['password'], $_POST['mail'], $_POST['confirm_mail'], $_POST['confirm_password'])) {
    // Récupérer les valeurs du formulaire
    $name = $_POST['name'];
    $password = $_POST['password'];
    $mail = $_POST['mail'];
    $confirmMail = $_POST['confirm_mail'];
    $confirmPassword = $_POST['confirm_password'];
    $phoneCountry = $_POST["phone_country"];
    $phone = $_POST['phone'];

    // Vérification de la correspondance des mails
    if ($mail !== $confirmMail) {
        $_SESSION['messagemailincorrect'] = "Les adresses email ne correspondent pas.";
        header("Location: inscriptionPage.php");
        exit();
    } else {
        // Vérification de la correspondance des mots de passe
        if ($password !== $confirmPassword) {
            $_SESSION['messagemdpincorrect'] = "Les mots de passe ne correspondent pas.";
            header("Location: inscriptionPage.php");
            exit();
        } else {
            // Vérification de la longueur minimale du nom
            if (strlen($name) >= 4) {
                // Vérification de l'adresse e-mail
                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    // Vérification de la longueur minimale du mot de passe et des exigences de complexité
                    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
                        // Vérification si l'e-mail est déjà utilisé
                        $sql = "SELECT COUNT(*) AS count FROM `user` WHERE `mail` = :mail";
                        $query = $bdd->prepare($sql);
                        $query->bindValue(':mail', $mail);
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_ASSOC);

                        if ($result['count'] > 0) {
                            // L'e-mail est déjà utilisé, rediriger vers la page d'inscription avec un message d'erreur
                            session_start();
                            $_SESSION['error_message'] = "L'e-mail est déjà utilisé.";
                            header("Location: inscriptionPage.php");
                            exit();
                        } else {
                            // Hachage du mot de passe
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                            // Commande SQL
                            $sql = "INSERT INTO `user` (`name`, `password`, `mail`, `phoneCountry` ,`phone`) VALUES (:name, :password, :mail, '+' :phoneCountry, :phone)";

                            // Préparation de la requête SQL
                            $query = $bdd->prepare($sql);

                            // Attribution des valeurs aux paramètres
                            $query->bindValue(':name', $name);
                            $query->bindValue(':password', $hashedPassword);
                            $query->bindValue(':mail', $mail);
                            $query->bindValue(':phoneCountry', $phoneCountry);
                            $query->bindValue(':phone', $phone);

                            // Exécution de la requête SQL
                            $query->execute();

                            // Récupérer l'ID de l'utilisateur nouvellement inscrit
                            $userId = $bdd->lastInsertId();

                            // Stocker l'ID de l'utilisateur dans la session
                            session_start();
                            $_SESSION['user_id'] = $userId;

                            header("Location: index.php");
                            exit();
                        }
                    } else {
                        $_SESSION['error_message_inscription'] = "Le mot de passe doit comporter au moins 8 caractères, inclure au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial. (@$!%*?&)";
                        header("Location: inscriptionPage.php");
                        exit();
                    }
                } else {
                    $_SESSION['error_message_inscription'] = "Veuillez saisir une adresse e-mail valide. (exemple@gmail.com)";
                    header("Location: inscriptionPage.php");
                    exit();
                }
            } else {
                $_SESSION['error_message_inscription'] = "Le nom doit comporter au moins 4 caractères.";
                header("Location: inscriptionPage.php");
                exit();
            }
        }
    }
}
?>