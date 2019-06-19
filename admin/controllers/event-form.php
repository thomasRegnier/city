<?php
require_once('models/events.php');


if(isset($_GET['event_id']) && isset($_GET['action']) && $_GET['action'] == 'edit') {


    $event = getOneEvent($_GET['event_id']);


    if (!$event) {
        header('location:index.php');
        exit;
    }
}

if (isset($_POST['save']) OR isset($_POST['update'])){
    $messages = [];

    if (empty($_POST['title'])) {
        $messages['title'] = 'le titre est obligatoire';
    }

    if (empty($_POST['adress'])) {
        $messages['adress'] = 'l\'adresse est obligatoire';
    }


    if (empty($_POST['content'])) {
        $messages['content'] = 'Contenu obligatoire';
    }
    if (empty($_POST['description'])) {
        $messages['description'] = 'Description obligatoire';
    }

    if (empty($_POST['dateEvent'])) {
        $messages['event_date'] = 'Information obligatoire';
    }
    if (empty($_POST['publish_at'])) {
        $messages['publish_at'] = 'Date de publication obligatoire';
    }

    if (empty($_POST['is_published'])) {
        $messages['is_publish'] = 'Publié  obligatoire';
    }

    if (empty($_POST['longi'])) {
        $messages['long'] = 'long obligatoire';
    }
    if (empty($_POST['lati'])) {
        $messages['lat'] = 'lat obligatoire';
    }

    elseif (isset($_POST['save'])) {
        if ($_FILES['image']['error'] != 0 ) {

            $messages['image'] = 'Image Obligatoire';
        }

        if (empty($messages)){
            $result = addEvent($_POST['title'],$_POST['description'],$_POST['content'], $_FILES, $_POST['adress'],
                $_POST['dateEvent'], $_POST['publish_at'], $_POST['is_published'],
                $_POST['longi'], $_POST['lati']);

            if ($result){
                $_SESSION['success']['success'] = 'Evénement enregistré avec succées';
                header('Location: index.php?page=events');

            }
        }

    }
    elseif (isset($_POST['update'])){

        $resultUpdate = updateEvent($_POST['title'],$_POST['description'],$_POST['content'], $_POST['adress'],
            $_POST['dateEvent'], $_POST['publish_at'], $_POST['is_published'],
            $_POST['longi'], $_POST['lati'], $_POST['event_id'], $_FILES);

    }


    $event['title'] = $_POST['title'];
    $event['description'] = $_POST['description'];
    $event['content'] = $_POST['content'];
    $event['event_date'] = $_POST['dateEvent'];
    $event['publish_at'] = $_POST['publish_at'];
    $event['adress'] = $_POST['adress'];
    $event['longitude'] = $_POST['longi'];
    $event['lattitude'] = $_POST['lati'];
    $event['is_publish'] = $_POST['is_published'];

}









require_once('views/event-form.php');
