<?php


function getEvents($limit = false){

    $db = dbConnect();


    $queryString = 'SELECT * FROM events WHERE is_publish = 1 AND publish_at < NOW() ';

    if ($limit){
        $queryString .= ' ORDER BY event_date ASC LIMIT ' . $limit;
    }


    else{
        $queryString .= ' ORDER BY event_date ASC ';
    }

    $query = $db->query($queryString);

    return  $homeEvents=$query->fetchAll();

}