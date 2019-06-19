<?php
//connexion à la base de données
require_once ('assets/toolsDb.php');


$response = new \stdClass();
$data = file_get_contents('php://input');
$json = json_decode($data);

$prepareString = 'INSERT INTO message (';

$i = 0;
$count = count(get_object_vars($json));
$execute  = array();


foreach ($json as $key => $value) {

$i++;


    $prepareString .= $key;

    if ($i != $count){
        $prepareString .= ",";
    }else{
        $prepareString .= ")";
    }

    array_push($execute,$value);

}

$prepareString .= ' VALUES (';

for($i = 1; $i<=$count; $i++){

    $prepareString .= "?";

    if ($i != $count){
        $prepareString .= ",";
    }
    else{
        $prepareString .= ")";
    }

}





$query_user = $db->prepare($prepareString);
$query_user->execute($execute);

$response->type = 1;
$response->msg = "Votre message a bien été envoyé";
echo json_encode($response);

