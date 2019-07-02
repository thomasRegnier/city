
<?php
require_once ('assets/toolsDb.php');

//require_once ('./models/events.php');



$eventResp = new \stdClass();



$queryID = $db->query('SELECT id, title, description, image, event_date 
                                FROM events 
                                WHERE is_publish = 1 AND publish_at < NOW() 
                                ORDER By title');

$event=$queryID->fetchAll();


//$event = getEvents(false, true, false);


echo json_encode($event);
