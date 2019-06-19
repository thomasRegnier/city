<?php
function dbConnect(){

try{
return  $db = new PDO('mysql:host=thomasrejwthomas.mysql.db;dbname=thomasrejwthomas;charset=utf8', 'thomasrejwthomas', 'Moimoi95', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $exception)
{
die( 'Erreur : ' . $exception->getMessage() );
}

}

$db = dbConnect();

session_start();
