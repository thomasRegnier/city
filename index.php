<?php

function dbConnect(){

    try{
        return  $db = new PDO('mysql:host=thomasrejwthomas.mysql.db;dbname=thomasrejwthomas;charset=utf8', 'thomasrejwthomas', 'Moimoi95', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $exception)
    {
        die( 'Erreur : ' . $exception->getMessage());
    }

}

$db = dbConnect();

session_start();

if (isset($_GET['logout'])){
    session_destroy();
    header('Location: index.php?page=connect');
}

if (isset($_GET['page'])) {

    switch ($_GET['page']) {

        case 'informations':
            require('./controllers/informations.php');
            break;

        case 'index':
            require('./controllers/index.php');
            break;

        case'events':
            require ('./controllers/events.php');
            break;

        case'contact':
            require ('./controllers/contact.php');
            break;

        case'connect':
            require ('./controllers/connect.php');
            break;

        case'mentions':
            require ('./controllers/mentions.php');
            break;

        case'faq':
            require ('./controllers/faq.php');
            break;


        default:
            require('./controllers/index.php');
            break;
    }

}

else{
    require ('controllers/index.php');

}

