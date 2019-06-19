<?php
require_once('models/events.php');



$events = getEvents(false, false , false);


require_once('views/events.php');
