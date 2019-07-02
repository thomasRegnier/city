<?php
require_once ('assets/toolsDb.php');


$mail = $_POST['mail'];
$password = $_POST['password'];

$response = new \stdClass();

//ne pas oublier le mD5 password


if ($mail == ''|| $password == '') {
    $response->type = 0;
    $response->msg = "Au moins un champ est manquant";
   // echo json_encode($response);
}

else{

    $query = $db->prepare('SELECT * FROM user WHERE mail = ? AND password = ?');


    // SI PAS DE FACTURE REFUS DE CONNECTION ????


   // $query = $db->prepare('SELECT user.id , user.name ,user.firstname , user.adress, user.mail, user.phone,
   //                                   user.is_admin, user.is_update, bills.id,  bills.user_id, bills.title, bills.date, bills.status, bills.file, bills.amount
   //                                 FROM user
   //                                 JOIN bills
   //                                 ON user.id = bills.user_id
   //                                 WHERE mail = ? AND password = ?');
    $query->execute( array($mail,md5($password)));

    $user=$query->fetch();

    if ($user){
     //  $response -> type = 0;
     //   $response -> msg = "Vous êtes connecté";

        session_start();


        $_SESSION['user']['is_admin'] = $user['is_admin'];
        $_SESSION['user']['firstname'] = $user['firstname'];
        $_SESSION['user']['name'] = $user['name'];
        $_SESSION['user']['adress'] = $user['adress'];
        $_SESSION['user']['mail'] = $user['mail'];
        $_SESSION['user']['id'] = $user['id'];
        $_SESSION['user']['is_update'] = $user['is_update'];
        $_SESSION['user']['phone'] = $user['phone'];
        $_SESSION['user']['numberStreet'] = $user['streetNumber'];
        $_SESSION['user']['street'] = $user['street'];
        $_SESSION['user']['zipcode'] = $user['zipcode'];
        $_SESSION['user']['city'] = $user['city'];




        $response -> type = 1;
        $response -> msg = "Vous êtes connecté";
        $response->user = $user;


        $query = $db->prepare('SELECT * FROM bills WHERE user_id = ?');
        $query->execute( array($_SESSION['user']['id']));

        $bills=$query->fetchAll();

        if ($bills){
            $response->bills = $bills;
        }
        else{
            $response->msgBills = "Il n'ya pas de facture pour le moment";
        }
    }

    else{
        $response -> type = 0;
        $response -> msg = "Identifiant ou mot de passe incorrect";
    }
}




echo json_encode($response);