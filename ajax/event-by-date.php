<?php
require_once('assets/toolsDb.php');



$eventResp = new \stdClass();

$date = $_POST['date'];

$date = str_replace('/','-',$date);


$queryID = $db->prepare('SELECT id, title, description, image, event_date FROM events WHERE event_date = ? AND is_publish = 1');
$queryID->execute(array($date));

$event=$queryID->fetchAll();


if(count($event) > 0){

    echo json_encode($event);

}

else{

    $eventResp -> type = 0;
    $eventResp -> message = "Il n'y aucun événément à cette date";

    echo json_encode($eventResp);
}