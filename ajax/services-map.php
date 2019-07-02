<?php
////connexion à la base de données
//try{
//    $db = new PDO('mysql:host=localhost;dbname=city;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//}
//catch (Exception $exception)
//{
//    die( 'Erreur : ' . $exception->getMessage() );
//}
//
//



//header("Access-Control-Allow-Origin: *");

require_once ('assets/toolsDb.php');

$id = intval($_POST['id']);

$response = New stdClass();

if (is_int($id)){


    $queryID = $db->prepare('SELECT * FROM services WHERE id = ?');
    $queryID->execute(array($id));

    $service=$queryID->fetch();

//    $service = getOneServices($id);


    if ($service == false){
        $response->msg = "Aucun services";
        $response -> type = 1;

        echo json_encode($response);

    }

    else{
        echo json_encode($service);
    }

}
else{
    $response->msg = "Aucun services";
    $response -> type = 1;
    echo json_encode($response);

}


