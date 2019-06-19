<?php

function getEvents($date = false , $order = false , $limit = false){


    $db = dbConnect();

    $queryString = 'SELECT * FROM events WHERE is_publish = 1 AND publish_at < NOW()';

    $queryParameters  = [];


    if ($date){
        $queryString .= ' AND event_date = ' . $date;
        $queryParameters[] = $date;
    }

    if ($order){
        $queryString .= ' ORDER BY title ';
    }


    if ($limit){
        $queryString .= ' ORDER BY event_date ASC LIMIT ' . $limit;
    }


    else{
        $queryString .= ' ORDER BY event_date ASC ';
    }

    $queryEvents = $db->prepare($queryString);
    $queryEvents->execute($queryParameters);



    return $queryEvents->fetchAll();
}

