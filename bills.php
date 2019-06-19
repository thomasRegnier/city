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

$response = new \stdClass();

$id = $_POST['id'];


$query = $db->prepare('SELECT * FROM bills WHERE user_id = ?');
$query->execute( array($id));

$bills=$query->fetchAll();

if ($bills){

      echo json_encode($bills);

}

else{
    $response -> type = 1;
    $response -> msg = "Il n'y a aucune facture";
    echo json_encode($response);
}