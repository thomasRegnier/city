<?php
//connexion à la base de données
require_once('assets/toolsDb.php');


$homeArticles = new \stdClass();


$query = $db->query('SELECT * FROM history LIMIT 2, 4');
$homeArticles=$query->fetchAll();


echo json_encode($homeArticles);
