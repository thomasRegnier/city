<?php


function getEvents($admin = false, $date = false){

    $db = dbConnect();

    $queryString = 'SELECT * FROM events ORDER BY publish_at ASC';

    $queryParam = [];

    if (!$admin){
        $queryString .= 'WHERE is_publish = ?';
        $queryParam []= 1;
    }

    if ($date){
        $queryString .= 'WHERE event_date = ?';
        $queryParam[] = $date;
    }

    $query = $db->prepare($queryString);
    $query->execute($queryParam);

    return  $query->fetchAll();

}



function getOneEvent($id){

    $db = dbConnect();

    $query = $db->prepare('SELECT * FROM events WHERE id = ?');

    $query->execute(array($id));

    return $query->fetch();
}




function chekImg($files){

    $messages = [];
    $nameImg = "";

    if (isset($files['image'])){

        if ($files['image']['error'] === 0 ) {

            $allowed_extensions = array('jpg', 'jpeg','png','gif');

            $my_file_extension = pathinfo($files['image']['name'], PATHINFO_EXTENSION);


            if (in_array($my_file_extension, $allowed_extensions)) {

                do {
                    $new_file_name = time() . rand();

                    $nameImg = $new_file_name . '.' . $my_file_extension;

                    $destination = '/Applications/MAMP/htdocs/projet-city/assets/image/' . $new_file_name . '.' . $my_file_extension;
                } while (file_exists($destination));

                move_uploaded_file($files['image']['tmp_name'], $destination);

            }
            else {
                $messages['error'] = "Fichiers non autorisé";
                exit;
            }

        }

        else{
            $_SESSION['errorMessages']['empty'] = 'l\'image est obligatoire';
            exit;
        }

    }
        return $nameImg;

};

function addEvent($title, $description, $content, $files, $adress, $event_date, $publish_at, $is_publish, $long, $lat){

    $db = dbConnect();
    $image = chekImg($files);

    $query = $db->prepare('INSERT INTO events (title, description, content, image, adress, event_date, publish_at, is_publish ,longitude, lattitude) VALUES (?, ?, ?, ?, ?,?,?,?,?, ?)');
    $queyParameters = [
        $title,
        $description,
        $content,
        $image,
        $adress,
        $event_date,
        $publish_at,
        $is_publish,
        $long,
        $lat
    ];

     //   move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        //$messages['success'] = "Evénement enregistré avec succées";

    return $query->execute($queyParameters);
}








function updateEvent($title, $description, $content, $adress, $event_date, $publish_at, $is_publish, $long, $lat, $id, $files){

    $db = dbConnect();



    $queryString = 'UPDATE events SET title = :title,
		description = :description,
		content = :content,
		adress = :adress,
		event_date = :event_date,
		publish_at = :publish_at,
		is_publish = :is_publish,
		longitude = :longitude,
		lattitude = :lattitude';


    $parameter =[
        'title' => $title,
        'description' => $description,
        'content' => $content,
        'adress' => $adress,
        'event_date' => $event_date,
        'publish_at' => $publish_at,
        'is_publish' => $is_publish,
        'longitude' => $long,
        'lattitude'=> $lat,
        'id' => $id,
    ];



    if (isset($files) AND !empty($files)){
        $image = chekImg($files);
        $queryString .= ', image = :image ';
        $parameter['file'] = $image;
    }

    $queryString .= ' WHERE id = :id';

    $query = $db->prepare($queryString);

    return $query->execute($parameter);



};