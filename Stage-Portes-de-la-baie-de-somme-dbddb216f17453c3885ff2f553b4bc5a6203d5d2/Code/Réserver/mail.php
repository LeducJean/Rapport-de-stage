<?php
$destinataire = "destinataire@example.com";
$sujet = "Sujet de l'e-mail";
$message = "Contenu de l'e-mail";

// En-têtes de l'e-mail
$headers = "From: expediteur@example.com\r\n";
$headers .= "Reply-To: expediteur@example.com\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

// Envoyer l'e-mail
if (mail($destinataire, $sujet, $message, $headers)) {
    echo "L'e-mail a été envoyé avec succès.";
} else {
    echo "Une erreur s'est produite lors de l'envoi de l'e-mail.";
}
?>