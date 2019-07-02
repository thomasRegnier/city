<?php
require_once('assets/toolsDb.php');



session_start();


$id = $_SESSION['user']['id'] ;
$update = 1;


$response = new \stdClass();


$query = $db->prepare('UPDATE user SET
		is_update = :is_update 
		WHERE id = :id'
);

//mise à jour avec les données du formulaire
$resultUser = $query->execute([
    'is_update' => $update,
    'id' => $id,
]);

if($resultUser){
    $response-> msg = "user mis a jour";


}
else{
    $response-> msg = "erreur";
}

echo json_encode($response);