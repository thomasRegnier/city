<?php
//connexion à la base de données
try{
    $db = new PDO('mysql:host=thomasrejwthomas.mysql.db;dbname=thomasrejwthomas;charset=utf8', 'thomasrejwthomas', 'Moimoi95', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $exception)
{
    die( 'Erreur : ' . $exception->getMessage() );
}

?>

<?php


header("Access-Control-Allow-Origin: *");
