<?php


function getService($id){

    $db = dbConnect();


    $query = $db->prepare('SELECT * FROM services WHERE id = ?');
    $query->execute(array($id));
    return  $query->fetch();

}






function addService($title, $image, $adress, $dayOpen, $morning, $afternoon, $phone, $long, $lat){

    $db = dbConnect();

    $messages = [];

    $query = $db->prepare('INSERT INTO services (title,image,adress, days_opened, open_at, close_at, phone ,longitude, lattitude) VALUES (?, ?, ?, ?, ?,?,?,?,?)');


    if (empty($title)) {
        $messages['title'] = 'le titre est obligatoire';
    }

    if (empty($adress)) {
        $messages['adress'] = 'l\'adresse est obligatoire';
    }

    if (isset($_FILES['image'])){

        if ($_FILES['image']['error'] === 0 ) {

            $allowed_extensions = array('jpg', 'jpeg','png','gif');

            $my_file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);


            if (in_array($my_file_extension, $allowed_extensions)) {

                do {
                    $new_file_name = time() . rand();

                    $nameImg = $new_file_name . '.' . $my_file_extension;

                    $destination = '/Applications/MAMP/htdocs/projet-city/assets/image/' . $new_file_name . '.' . $my_file_extension;
                } while (file_exists($destination));
            }
            else {
                $messages['error'] = "Fichiers non autorisé";
            }

        }

        else{
            $messages['image'] = 'l\'image est obligatoire';
        }



    }


    if (empty($dayOpen)) {
        $messages['days'] = 'Information obligatoire';
    }
    if (empty($morning)) {
        $messages['morning'] = 'Information obligatoire';
    }

    if (empty($afternoon)) {
        $messages['afternoon'] = 'Information obligatoire';
    }
    if (empty($phone)) {
        $messages['phone'] = 'phone obligatoire';
    }

    if (empty($long)) {
        $messages['long'] = 'long obligatoire';
    }
    if (empty($lat)) {
        $messages['lat'] = 'lat obligatoire';
    }


    if (empty($messages)){
        $newServices = $query->execute([
            $title,
            $nameImg,
            $adress,
            $dayOpen,
            $morning,
            $afternoon,
            $phone,
            $long,
            $lat
        ]);

        move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        $messages['success'] = "Services enregistré avec succées";
    }

    return $messages;
}