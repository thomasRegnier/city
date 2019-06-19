<?php




function getBills($ssId){


    $db = dbConnect();


    $query = $db->prepare('SELECT * FROM bills WHERE user_id = ?');
    $query->execute( array($ssId));

    return $query->fetchAll();
}