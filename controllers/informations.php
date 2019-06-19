<?php
require_once('models/informations.php');
require_once('models/history.php');





$services = getServices();

$history = getHistory(2);

require_once('views/informations.php');