<?php


function getUser(){

    $db = dbConnect();


    $query = $db->query('SELECT * FROM user ORDER BY id DESC');

    return  $query->fetchAll();

}
