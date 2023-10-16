<?php

$to = 'jean.leduc80@gmail.com';
$subject = 'C\'est un test tkt bro';
$message = 'Le contenu est là mamenne';

// En-têtes de l'e-mail
$headers = 'jean.leduc80@gmail.com' . "\r\n" .
    'Reply-To: jean.leduc80@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Envoi de l'e-mail
$mailSent = mail($to, $subject, $message, $headers);

// Vérification si l'e-mail a été envoyé avec succès
if ($mailSent) {
    echo "L'e-mail a été envoyé avec succès.";
} else {
    echo "Une erreur s'est produite lors de l'envoi de l'e-mail.";
}
?>