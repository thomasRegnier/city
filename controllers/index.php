<?php
require_once('models/index.php');



$events = getEvents(5);

//$events = getEvents(false, false , 5)

require_once('views/index.php');