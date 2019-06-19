<?php

require_once('models/bills.php');


if (isset($_SESSION['user'])){
    $bills = getBills($_SESSION['user']['id']);
}


require_once('views/connect.php');
