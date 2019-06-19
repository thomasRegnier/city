<?php


function getSectors(){


    $db = dbConnect();

    $query = $db->query('SELECT * FROM sectors');

    return  $query->fetchAll();

}


/*
function getChoices($sectorId){
$db = dbConnect();

$queryString = 'SELECT choices.name, choices.id
 FROM choices INNER JOIN sectors_services
 ON choices.id = sectors_services.choices_id
 INNER JOIN sectors
 ON sectors_services.sector_id = sectors.id
     ';

if ($sectorId){
    $queryString .= ' AND sectors_services.sector_id = ' . $sectorId;
}

$query = $db->query($queryString);
return  $homeArticles=$query->fetchAll();
}

*/


