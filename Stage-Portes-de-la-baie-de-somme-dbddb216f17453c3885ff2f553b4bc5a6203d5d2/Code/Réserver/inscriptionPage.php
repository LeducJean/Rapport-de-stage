<?php
session_start();

// Commande sql pour s'inscrire
if (isset($_POST["submit"])) {
    require_once "inscriptionUser.php";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="centre" align="center">
        <form name="fo" method="POST" action="">
            <h2>Inscription</h2>
            <p>
            <p>
            <table>
                <tr>
                    <td align="right">
                        <label for="name">Nom Prénon :</label>
                    </td>
                    <td>
                        <input type="text" name="name" autocomplete="off" placeholder="Nom Prénom" pattern=".{4,}"
                            title="Le nom doit comporter au moins 4 caractères" required>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mail">Mail :</label>
                    </td>
                    <td>
                        <input type="email" name="mail" autocomplete="off" placeholder="Email" id="mail"
                            pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                            title="Veuillez fournir une adresse e-mail valide" title="Veuillez entrer un mail valide"
                            required />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mail2">Confimation mail :</label>
                    </td>
                    <td>
                        <input type="email" name="confirm_mail" autocomplete="off" placeholder="Confirmer l'Email"
                            id="mail2" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                            title="Veuillez fournir une adresse e-mail valide" required />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mdp">Mot de passe :</label>
                    </td>
                    <td>
                        <input class="password" type="password" name="password" autocomplete="off"
                            placeholder="Mot de passe" id="mdp"
                            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                            title="Le mot de passe doit comporter au moins 8 caractères, inclure une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&)"
                            required>
                        <!-- ICONES -->
                        <div class="password-icon">
                            <img src="image/les-yeux-croises.png" class="eye" id="eye">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mdp2">Confirmez le mot de passe :</label>
                    </td>
                    <td>
                        <input class="password" type="password" name="confirm_password" autocomplete="off"
                            placeholder="Confirmer le mdp" id="mdp2"
                            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                            title="Le mot de passe doit comporter au moins 8 caractères, inclure une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&)"
                            required>
                        <!-- ICONES -->
                        <div class="password-icon">
                            <img src="image/les-yeux-croises.png" class="eye" id="eye2">
                    </td>
                </tr>
                <!-- ... code précédent ... -->

                <tr>
                    <td align="right">
                        <label for="phone">Numéro de téléphone :</label>
                    </td>
                    <td>
                        <div class="phone-input-group">
                            <div class="lettrePlus">
                                +
                            </div>
                            <select id="country_code" required>
                                <option disabled selected>...</option>
                                <?php for ($i = 0; $i <= 99; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <input type="number" name="phone" autocomplete="off" placeholder="Numéro" required>
                            <!-- Champ de formulaire caché pour stocker la valeur de "phoneCountry" -->
                            <input type="hidden" id="phone_country_input" name="phone_country" value="">
                        </div>
                    </td>
                </tr>
                <!-- ... code suivant ... -->

                <tr>
                    <td></td>
                    <td class="inscription" align="center">
                        <p><input id="desactivateButton" class="inscription" type="submit" name="submit"
                                value="Je m'inscris">
                    </td>
                </tr>
            </table>
            Vous avez déjà un compte ?<a href="index.php">Connectez-vous</a>

            <div class="errormail">
                <?php
                // Vérifier     si un message d'erreur est présent dans la session
                if (isset($_SESSION['error_message'])) {
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']); // Supprimer le message d'erreur de la session
                }

                if (isset($_SESSION['messagemailincorrect'])) {
                    echo $_SESSION['messagemailincorrect'];

                    // Supprimer le message de la session
                    unset($_SESSION['messagemailincorrect']);
                }

                if (isset($_SESSION['messagemdpincorrect'])) {
                    echo $_SESSION['messagemdpincorrect'];

                    // Supprimer le message de la session
                    unset($_SESSION['messagemdpincorrect']);
                }

                if (isset($_SESSION['error_message_inscription'])) {
                    echo $_SESSION['error_message_inscription'];

                    // Supprimer le message de la session
                    unset($_SESSION['error_message_inscription']);
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