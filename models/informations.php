<?php


function getServices(){


    $db = dbConnect();

    $queryString = 'SELECT * FROM services';

    $query = $db->query($queryString);


    return  $homeEvents=$query->fetchAll();

}


function getOneServices ($id){

    $db = dbConnect();


    $queryID = $db->prepare('SELECT * FROM services WHERE id = ?');
    $queryID->execute(array($id));

    return $queryID->fetch();
}