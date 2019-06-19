<?php

function getHistory($limit = false){


    $db = dbConnect();

    $queryString = 'SELECT * FROM history';

    if ($limit){
        $queryString .= ' LIMIT ' . $limit;
    }

    $query = $db->query($queryString);


    return  $homeEvents=$query->fetchAll();

}