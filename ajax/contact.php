<?php
require_once('assets/toolsDb.php');



$id = intval($_POST['id']);
$response = New stdClass();

if (is_int($id)) {

    $queryID = $db->prepare('SELECT * FROM choice WHERE sector_id = ?');
    $queryID->execute(array($id));

    $article = $queryID->fetchAll();

    echo json_encode($article);


}else{
    $response->msg = "Non autorisé";
    $response -> type = 1;
    echo json_encode($response);
}

