<?php
//connexion à la base de données
try{
    $db = new PDO('mysql:host=localhost;dbname=city;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $exception)
{
    die( 'Erreur : ' . $exception->getMessage() );
}

?>

<?php


header("Access-Control-Allow-Origin: *");

$idCat = $_POST['idCat'];

$queryID = $db->prepare('SELECT * FROM faq_questions WHERE id_faq_category = ?');
$queryID->execute(array($idCat));

$category=$queryID->fetchAll();

echo json_encode($category);