<?php
require_once('models/user.php');



$users = getUser();

require_once('views/user.php');
