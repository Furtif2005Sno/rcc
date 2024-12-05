<?php
// Adresse email du destinataire
$receiving_email_address = 'contact@example.com';

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from_name = htmlspecialchars($_POST['name']);
    $from_email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Vérifier que les champs requis sont remplis
    if (!empty($from_name) && !empty($from_email) && !empty($subject) && !empty($message)) {
        $headers = "From: $from_name <$from_email>\r\n";
        $headers .= "Reply-To: $from_email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $full_message = "Nom : $from_name\n";
        $full_message .= "Email : $from_email\n\n";
        $full_message .= "Message :\n$message";

        // Envoyer l'email
        if (mail($receiving_email_address, $subject, $full_message, $headers)) {
            echo "Message envoyé avec succès.";
        } else {
            echo "Erreur lors de l'envoi de l'email.";
        }
    } else {
        echo "Veuillez remplir tous les champs requis.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
