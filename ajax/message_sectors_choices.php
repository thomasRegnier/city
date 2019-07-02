<?php
//connexion à la base de données
require_once('assets/toolsDb.php');



$choiceId = $_POST['choice'];
$mail = $_POST['mailMess'];
$message = $_POST['messageSignal'];

$response = new \stdClass();


if ($mail == '' || $message == '') {
    $response->type = 0;
    $response->msg = "Au moins un champ est manquant";
    echo json_encode($response);
}


if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

    $query_user = $db->prepare('INSERT INTO messageSector (choice_id, mail, message) VALUES (?, ?,?)');
    $query_user->execute(
        array(
            $choiceId,
            $mail,
            $message
        ));



    $last_insert = $db -> lastInsertId();

    $query_select = $db-> prepare('SELECT messageSector.mail, messageSector.message, choice.name, sectors.name_sector                   
                            FROM messageSector
                            JOIN choice  
                            ON messageSector.choice_id = choice.id
                            JOIN sectors
                            ON choice.sector_id = sectors.id
                            WHERE messageSector.id = ? ');

    $query_select -> execute(array($last_insert));

    $msg=$query_select->fetch();

   // $event=$query_select->fetch();

  //  echo '<pre>';
  //  print_r($event);
  //  echo '</pre>';

    $to      = 'thomas.regnier3001@gmail.com';
    $subject = 'Envoyé depuis Mairie saint leu';
    $message = "SECTEUR : ".$msg['name_sector'] ." ,". " CHOIX : " .$msg['name'] ." , ". " MESSAGE : ".$msg['message'];
    $headers = array(
        'From' => $mail,
        'Reply-To' => $mail,
        'X-Mailer' => 'PHP/' . phpversion()
    );

    mail($to, $subject, $message, $headers);

   // $response->forMail = $event=$query_select->fetch();

    $response->type = 1;
    $response->msg = "Votre message a bien été envoyé";
    echo json_encode($response);

}
else{
    $response->type = 0;
    $response->msg = "le mail est invalide";
    echo json_encode($response);
}
