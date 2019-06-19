<?php
require_once('./models/events.php');


$events = getEvents(true);

require_once('views/events.php');