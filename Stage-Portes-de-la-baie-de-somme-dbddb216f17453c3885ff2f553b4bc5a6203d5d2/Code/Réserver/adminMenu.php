<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il a les droits d'administrateur
if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['isAdmin'] == 0) {
    // Rediriger vers une page d'erreur ou de connexion
    header("Location: index.php");
    exit();
}

if (isset($_POST['deconnexion'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

require "administrateur.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
    <link rel="stylesheet" href="css/style-adminAll.css">
    <link rel="stylesheet" href="css/style-admin.css">
</head>

<body>

    <form action="" method="post">
        <button type="submit" class="custom-btn btn-16 top-left-input" name="deconnexion">Se
            déconnecter</button>
    </form>

    <div class="main-container allPage">

        <!-- HEADER -->
        <form method="POST" action="">

            <header class="block">
                <ul class="header-menu horizontal-list">
                    <li>
                        <a class="header-menu-tab" href="adminReservationAtt.php"><span
                                class="icon scnd-font-color"></span>Réservations en
                            attentes</a>
                        <?php if ($notifReservations > 0): ?>
                            <a class="header-menu-number" href="#4">
                                <?php echo $notifReservations; ?>
                            </a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <a class="header-menu-tab" href="reservationCalendrier/calendrierPage.php"><span
                                class="icon scnd-font-color"></span>Calendrier</a>
                    </li>
                    <li>
                        <a class="header-menu-tab" href="reservationAccepter/reservationValide.php"><span
                                class="icon scnd-font-color"></span>Réservations
                            acceptées</a>
                    </li>
                    <li>
                        <a class="header-menu-tab" href="reservationRefuser/reservationRefuse.php"><span
                                class="icon scnd-font-color"></span>Réservations
                            refusées</a>
                    </li>
                </ul>
            </header>
        </form>

        <!-- LEFT-CONTAINER -->
        <div class="left-container container">
            <div class="menu-box block"> <!-- MENU BOX (LEFT-CONTAINER) -->
                <h2 class="titular">MENU BOX</h2>
                <ul class="menu-box-menu">
                    <li>
                        <a class="menu-box-tab" href="reservationCreateAdmin/createReservationPage.php"><span
                                class="icon entypo-calendar scnd-font-color"></span>Créer une réservation</a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="reservationEdit/reservationEdit.php"><span
                                class="icon entypo-edit scnd-font-color"></span>Modifier
                            une
                            réservation</a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="#10"><span class="icon entypo-comment scnd-font-color"></span></a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="#12"><span class="icon entypo-search scnd-font-color"></span></a>
                    </li>
                    <li>
                        <a class="menu-box-tab" href="#13">
                            <sapn class="icon entypo-mail scnd-font-color"></sapn>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- MIDDLE-CONTAINER -->
        <div class="middle-container container">
            <div class="profile block"> <!-- PROFILE (MIDDLE-CONTAINER) -->
                <div class="clear"></div>
            </div>
        </div>

        <!-- RIGHT-CONTAINER -->
        <div class="right-container container">
            <div class="join-newsletter block"> <!-- JOIN NEWSLETTER (RIGHT-CONTAINER) -->
                <h2 class="titular">Supprimer les demandes (+2 mois)</p>
                </h2>
                <form action="" method="post">
                    <button type="submit" class="subscribe button" name="deleteDemandes">SUPPRIMER</button>
                </form>
            </div>
            <div class="join-newsletter block"> <!-- JOIN NEWSLETTER (RIGHT-CONTAINER) -->
                <h2 class="titular">Supprimer les demandes refusées</p>
                </h2>
                <form action="" method="post">
                    <button type="submit" class="subscribe button" name="deleteDemandesRefuse">SUPPRIMER</button>
                </form>
            </div><!-- end calendar-month block -->
        </div> <!-- end right-container -->
    </div> <!-- end main-container -->


    <script src="js/script-admin.js"></script>

</body>

</html>