<?php
require_once('models/services.php');

if(isset($_GET['article_id']) && isset($_GET['action']) && $_GET['action'] == 'edit') {

    $service = getService($_GET['article_id']);


    if (!$service) {
        header('location:index.php');
        exit;
    }
}

if (isset($_POST['save'])) {
    $messages = addService($_POST['title'], $_FILES['image'], $_POST['adress'],
        $_POST['dayOpen'], $_POST['morning'], $_POST['afternoon'],
        $_POST['phone'], $_POST['longi'], $_POST['lati']);
}

require_once('views/service-form.php');
