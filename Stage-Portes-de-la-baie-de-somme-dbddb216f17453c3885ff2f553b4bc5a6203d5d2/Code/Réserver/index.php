<?php
session_start();
require_once "bdd.php";

// Vérification des informations de connexion
if (isset($_POST["submit"])) {
    require_once "connexionUser.php";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="centre" align="center">
        <form name="fo" method="POST" action="">
            <h2>Connexion</h2>
            <p>
            <p>
            <table>
                <tr>
                    <td align="right">
                        <label for="mail">Mail :</label>
                    </td>
                    <td>
                        <input type="email" name="mail" placeholder="Email" id="mail">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mdp">Mot de passe :</label>
                    </td>
                    <td>
                        <input class="password" type="password" name="password" placeholder="Mot de passe" id="mdp">
                        <!-- ICONES -->
                        <div class="password-icon">
                            <img src="image/les-yeux-croises.png" class="eye" id="eye">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="connexion" align="center">
                        <p><input class="connexion" type="submit" name="submit" value="Je me connecte">
                    </td>
                </tr>
            </table>
            Vous n'avez pas de compte ?<a href="inscriptionPage.php">Inscrivez-vous</a>

            <div class="erroridentifiant">
                <?php if (isset($_SESSION['message'])): ?>
                    <p>
                        <?php echo $_SESSION['message']; ?>
                        <?php unset($_SESSION['message']); // Supprimer la variable $message de la session ?>
                    </p>
                <?php endif;

                if (isset($_SESSION['error_message'])) {
                    echo $_SESSION['error_message'];

                    // Supprimer le message de la session
                    unset($_SESSION['error_message']);
                }

                if (isset($_SESSION['identifiantsInvalides'])) {
                    echo $_SESSION['identifiantsInvalides'];

                    // Supprimer le message de la session
                    unset($_SESSION['identifiantsInvalides']);
                } ?>
            </div>

        </form>

        <!-- OMBRES -->
        <div class="drop drop-1"></div>
        <div class="drop drop-2"></div>
        <div class="drop drop-3"></div>
        <div class="drop drop-4"></div>
        <div class="drop drop-5"></div>
    </div>


    <!-- partial -->
    <script src="js/script.js"></script>


</body>

</html>