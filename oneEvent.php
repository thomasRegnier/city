<?php
//connexion à la base de données
require_once ('assets/toolsDb.php');


$id = intval($_POST['id']);

$response = New stdClass();

if (is_int($id)) {

    $queryID = $db->prepare('SELECT e.*, GROUP_CONCAT(m.image) AS medias_image, GROUP_CONCAT(m.type) AS medias_type
      FROM events  e JOIN medias m
      ON e.id = m.events_id 
      WHERE e.id = ? AND is_publish = 1');
    $queryID->execute(array($id));

    $article = $queryID->fetch();

    if ($article == false){
        $response->msg = "Aucun événement";
        $response -> type = 1;

        echo json_encode($response);

    }

    else{
        echo json_encode($article);
    }

}
else{
    $response->msg = "Aucun événement";
    $response -> type = 1;

    echo json_encode($response);
}

