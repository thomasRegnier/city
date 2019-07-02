<?php
//connexion à la base de données
require_once('assets/toolsDb.php');


$name = $_POST['name'];
$firstName = $_POST['firstName'];
$email = $_POST['email'];
$mess = $_POST['message'];

$response = new \stdClass();


if ($name != '' AND $firstName != '' AND $email != '' AND $mess != '') {

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $query_user = $db->prepare('INSERT INTO message (name, firstname, email,  message) VALUES (?, ?,?,?)');
        $query_user->execute(
            array(
                $name,
                $firstName,
                $email,
                $mess
            ));


            $to      = 'thomas.regnier3001@gmail.com';
            $subject = 'Envoyé depuis Mairie saint leu';
            $message = "Nom ," . $name. " , Prénom : ".$firstName. ", Message :" .$mess;
            $headers = array(
                'From' => $email,
                'Reply-To' => $email,
                'X-Mailer' => 'PHP/' . phpversion()
            );

            mail($to, $subject, $message, $headers);


        $response = new \stdClass();
        $response->type = 1;
        $response->msg = "Votre message a bien été envoyé";
        echo json_encode($response);
    } else {
        $response->type = 0;
        $response->msg = "Adresse  mail  invalide";
        echo json_encode($response);
    }
} else {
    $response->type = 0;
    $response->msg = "Au moins un champ est manquant";
    echo json_encode($response);
}



