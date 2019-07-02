<?php require ('tools/tools.php');

if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
    header('location:../index.php');
    exit;
}



//suppression d'une image
if(isset($_POST['delete_image'])){
    $query = $db->prepare('SELECT image,type FROM medias WHERE id = ?');
    $query->execute([$_POST['img_id']]);
    $ImgToUnlink = $query->fetch();




    if($ImgToUnlink){

        if ($ImgToUnlink['type'] == 'image'){

            $pathForImg = '../assets/image/';

            unlink($pathForImg. $ImgToUnlink['image']);
        }


        $queryDelete = $db->prepare('DELETE FROM medias WHERE id=?');
        $queryDelete->execute([$_POST['img_id']]);

        $imgMessage = "Image Supprimée avec succès !";
    }
}






$name = isset($_POST['title']) ? $_POST['title'] : NULL ;
$description = isset($_POST['description']) ? $_POST['description'] : NULL ;
$content = isset($_POST['content']) ? $_POST['content'] : NULL ;
$adress = isset($_POST['adress']) ? $_POST['adress'] : NULL ;
$dateEvent = isset($_POST['dateEvent']) ? $_POST['dateEvent'] : NULL ;
$publish_at = isset($_POST['publish_at']) ? $_POST['publish_at'] : NULL ;
$longi = isset($_POST['longi']) ? $_POST['longi'] : NULL ;
$lati = isset($_POST['lati']) ? $_POST['lati'] : NULL ;
$streetNumber = isset($_POST['numberStreet']) ? $_POST['numberStreet'] : NULL ;
$street = isset($_POST['street']) ? $_POST['street'] : NULL ;
$zipcode =  isset($_POST['zipcode']) ? $_POST['zipcode'] : NULL ;
$city = isset($_POST['city']) ? $_POST['city'] : NULL ;



if(isset($_GET['event_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){

    $query = $db->prepare('SELECT * FROM events WHERE id = ?');
    $query->execute(array($_GET['event_id']));
    //$article contiendra les informations de l'article dont l'id a été envoyé en paramètre d'URL
    $event = $query->fetch();

    //ici aller chercher les images liées à l'articles pour les lister dans l'onglet des images
    $query = $db->prepare('SELECT * FROM medias WHERE events_id = ?');
    $query->execute(array($_GET['event_id']));
    $eventImages = $query->fetchAll();


    $id = $event['id'];
    $name = $event['title'];
    $description = $event['description'];
    $content = $event['content'];
    $adress = $event['adress'];
    $dateEvent = $event['event_date'];
    $publish_at = $event['publish_at'];
    $longi = $event['longitude'];
    $lati = $event['lattitude'];
    $streetNumber = intval($event['streetNumber']);
    $street = $event['street'];
    $zipcode = intval($event['zipcode']);
    $city = $event['city'];

}



if (isset($_POST['save']) OR isset($_POST['update'])) {
    $messages = [];

    $newNum = intval($_POST['numberStreet']);
    $newZip = intval($_POST['zipcode']);

    if (empty($_POST['title'])) {
        $messages['title'] = 'le titre est obligatoire';
    }

  //  if (empty($_POST['adress'])) {
   //     $messages['adress'] = 'l\'adresse est obligatoire';
   // }


    if (empty($_POST['content'])) {
        $messages['content'] = 'Contenu obligatoire';
    }
    if (empty($_POST['description'])) {
        $messages['description'] = 'Description obligatoire';
    }

    if (empty($_POST['dateEvent'])) {
        $messages['event_date'] = 'Information obligatoire';
    }
    if (empty($_POST['publish_at'])) {
        $messages['publish_at'] = 'Date de publication obligatoire';
    }

    if (empty($newNum)) {
        $messages['numberS'] = 'Numéro de voie obligatoire';
    }


    if (!is_int($newNum)){
        $messages['number'] = 'Veuillez entrer des nombres';

    }

    if (!is_int($newZip)){
        $messages['number'] = 'Veuillez entrer des nombres';
    }



    if (empty($_POST['street'])) {
        $messages['street'] = 'Voie obligatoire';
    }

    if (empty($newZip)) {
        $messages['zipcode'] = 'Code postal obligatoire';
    }

    if (empty($_POST['city'])) {
        $messages['city'] = 'Ville obligatoire';
    }


    // if (empty($_POST['is_published'])) {
   //     $messages['is_publish'] = 'Publié  obligatoire';
   // }

    if (empty($_POST['longi'])) {
        $messages['long'] = 'longitude obligatoire';
    }
    if (empty($_POST['lati'])) {
        $messages['lat'] = 'latitude obligatoire';
    }

    if (isset($_POST['save'])) {
        if (isset($_FILES['image'])) {

            if ($_FILES['image']['error'] === 0) {

                $allowed_extensions = array('jpg', 'jpeg', 'png');

                $my_file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);


                if (in_array($my_file_extension, $allowed_extensions)) {

                    do {
                        $new_file_name = time() . rand();

                        $nameImg = $new_file_name . '.' . $my_file_extension;

                        $destination = '../assets/image/' . $new_file_name . '.' . $my_file_extension;

                    } while (file_exists($destination));

                } else {
                    $messages['error'] = "Fichiers non autorisé";
                }

            } else {
                $messages['error'] = "l'image est obligatoire";


            }


        }

        if (empty($messages)) {

            $query = $db->prepare('INSERT INTO events (title, description, content, image, event_date, publish_at, is_publish ,longitude, lattitude, streetNumber, street , zipcode, city) VALUES (?, ?, ?, ?, ?,?,?,?,?, ?,?,?,?)');
            $newEvent = $query->execute([
                $_POST['title'],
                $_POST['description'],
                $_POST['content'],
                $nameImg,
                $_POST['dateEvent'],
                $_POST['publish_at'],
                $_POST['is_published'],
                $_POST['longi'],
                $_POST['lati'],
                $newNum,
                $_POST['street'],
                $newZip,
                $_POST['city']
            ]);

            move_uploaded_file($_FILES['image']['tmp_name'], $destination);

            if ($newEvent) {
                //redirection après enregistrement
                $_SESSION['message'] = 'Événement ajouté !';
                header('location:events-list.php');
                exit;
            } else { //si pas $newArticle => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
                $message = "Impossible d'enregistrer le nouvel événement...";
            }
        }


    }

    elseif (isset($_POST['update'])){

        if ($_FILES['image']['error'] === 0) {

            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

            $my_file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);


            if (in_array($my_file_extension, $allowed_extensions)) {

                do {
                    $new_file_name = time() . rand();

                    $nameImg = $new_file_name . '.' . $my_file_extension;

                    $destination = '../assets/image/' . $new_file_name . '.' . $my_file_extension;

                } while (file_exists($destination));

            } else {
                $messages['error'] = "Fichiers non autorisé";
            }

        }

        else{
            $nameImg = $_POST['imageActual'];
        }



        if (empty($messages)){
            $query = $db->prepare('UPDATE events SET
		title = :title,
		description = :description,
		content = :content,
		image = :image,
		event_date = :event_date,
		publish_at = :publish_at,
		is_publish = :is_publish,
		longitude = :longitude,
		lattitude = :lattitude,
		streetNumber = :streetNumber,
		street = :street,
		zipcode = :zipcode,
		city = :city
		WHERE id = :id'
            );


            //mise à jour avec les données du formulaire
            $updateEvent = $query->execute([
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'description' => $_POST['description'],
                'image' => $nameImg,
                'event_date'=> $_POST['dateEvent'],
                'publish_at' => $_POST['publish_at'],
                'is_publish' => $_POST['is_published'],
                'longitude' => $_POST['longi'],
                'lattitude' => $_POST['lati'],
                'streetNumber' => $newNum,
                'street' => $_POST['street'],
                'zipcode' => $newZip,
                'city' => $_POST['city'],
                'id' => $_POST['id']
            ]);

            if ($nameImg != $_POST['imageActual']){

                $pathForImg = '../assets/image/';

                unlink($pathForImg. $_POST['imageActual']);

                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            }

                if ($updateEvent) {
                    //redirection après enregistrement
                    $_SESSION['message'] = 'Événement Modifié';
                    header('location:events-list.php');
                    exit;
                } else { //si pas $newArticle => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
                    $message = "Impossible d'enregistrer le nouvel événement...";
                }
        }

    }

}

if(isset($_POST['add_image'])) {

    $messagesImages = [];

    if (isset($_FILES['image'])) {

        if ($_FILES['image']['error'] === 0) {

            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

            $my_file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);


            if (in_array($my_file_extension, $allowed_extensions)) {

                do {
                    $new_file_name = time() . rand();

                    $nameImg = $new_file_name . '.' . $my_file_extension;

                    $destination = '../assets/image/' . $new_file_name . '.' . $my_file_extension;

                } while (file_exists($destination));

            } else {
                $messagesImages['error'] = "Fichiers non autorisé";
            }

        }

    }

    if (empty($messagesImages)) {

        if (!empty($_POST['video'])){
            $nameImg = $_POST['video'];
        }


        $query = $db->prepare('INSERT INTO medias (image, type, events_id) VALUES (?, ?, ?)');
        $newEvent = $query->execute([
            $nameImg,
            $_POST['type'],
            $_POST['event_id']
        ]);


        if (empty($_POST['video'])){
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }

        if ($newEvent) {
            //redirection après enregistrement
            $_SESSION['message'] = 'Photo ajouté !';
            header('location:events-list.php');
            exit;
        } else { //si pas $newArticle => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
            $message = "Impossible d'enregistrer le nouvel événement...";
        }
    }


}




;?>




<!DOCTYPE html>
<html>
<head>
    <title>Administration des événements !</title>
    <?php require 'partials/head_assets.php'; ?>
</head>
<body class="index-body">
<div class="container-fluid">
    <?php require 'partials/header.php'; ?>
    <div class="row my-3 index-content">
        <?php require 'partials/nav.php'; ?>
        <section class="col-9">
            <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
            <script>tinymce.init({selector:'textarea'});</script>
            <header class="pb-3">
                <!-- Si $article existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
                <h4><?php if(isset($_GET['event_id'])): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un événement</h4>
            </header>

            <ul class="nav nav-tabs justify-content-center nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($_POST['save']) || isset($_POST['update']) || (!isset($_POST['add_image']) && !isset($_POST['delete_image']))): ?>active<?php endif; ?>" data-toggle="tab" href="#infos" role="tab">Infos</a>
                </li>
                <?php if(isset($event)): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if(isset($_POST['add_image']) || isset($_POST['delete_image'])): ?>active<?php endif; ?>" data-toggle="tab" href="#images" role="tab">Images</a>
                    </li>
                <?php endif; ?>
            </ul>


            <?php if (!empty($messages)) :?>
                <?php foreach ($messages as $msg) :?>
                    <?php echo $msg;?></br>
                <?php endforeach;?>
            <?php endif ;?>



            <div class="tab-content">
                <div class="tab-pane container-fluid <?php if(isset($_POST['save']) || isset($_POST['update']) || (!isset($_POST['add_image']) && !isset($_POST['delete_image']))): ?>active<?php endif; ?>" id="infos" role="tabpanel">

                    <h5 class="mt-4">Informations :</h5>

            <!-- Si $article existe, chaque champ du formulaire sera pré-remplit avec les informations de l'article -->
            <form <?php if(isset($_GET['event_id'])): ?>
                  action="event-form.php?event_id=<?=$_GET['event_id'];?>&action=edit"
                    <?php else: ?>
                action="event-form.php"
                    <?php endif;?>
                  method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Nom de l'évenements :</label>
                    <input class="form-control" value="<?php echo $name;?>" type="text" placeholder="Nom" name="title" id="title" />
                </div>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <input class="form-control" value="<?php echo $description;?>" type="text" placeholder="Description de l'événement" name="description" id="description" />
                </div>


                <div class="form-group">
                    <label for="content">Contenu:</label>
                    <textarea class="form-control"  type="text" placeholder="Contenu de l'événement" name="content" id="content">
                    <?php echo htmlentities($content);?></textarea>
                </div>

<!---->
<!--                <div class="form-group">-->
<!--                    <label for="adress">Adresse :</label>-->
<!--                    <input class="form-control" value="--><?php //echo $adress;?><!--" type="text" placeholder="ex : 15 rue de paris, 95320 Saint leu la forêt" name="adress" id="adress" />-->
<!--                </div>-->


                <div class="form-group">
                    <label for="numberStreet"> Numéro de voie :</label>
                    <input width="50px" type="number" placeholder="0" value="<?php echo $streetNumber;?>" name="numberStreet" id="numberStreet">
                    <label for="street">Voie :</label>
                    <input type="text" name="street" value="<?php echo $street;?>" id="street" placeholder="voie">
                    <label for="zipCode">Code postal :</label>
                    <input id="zipCode" name="zipcode" type="number" value="<?php echo $zipcode;?>" maxlength="5"  placeholder="95320">
                    <label for="city">Ville</label>
                    <input id="city" name="city" type="text" value="<?php echo $city;?>" placeholder="Ville">

                </div>


                <div class="form-group">
                    <label for="dateEvent">Date de l'événement :</label>
                    <input class="form-control" value="<?php echo $dateEvent;?>"  min=" <?php echo date('Y-m-d'); ?>" type="date"  name="dateEvent" id="dateEvent" />
                </div>


                <div class="form-group">
                    <label for="publish_at">Publié le  :</label>
                    <input class="form-control" value="<?php echo $publish_at;?>" type="date" min=" <?php echo date('Y-m-d'); ?>"  name="publish_at" id="publish_at" />
                </div>

                <div class="form-group">
                    <label for="image">Image :</label>
                    <input class="form-control" type="file" name="image" id="image"/>
                </div>

                <?php if (isset($_GET['event_id'])):?>
                <?php if (isset($event['image'])):?>
                <input type="hidden" name="imageActual" value="<?= htmlentities($event['image']);?>">
                    <img src="../assets/image/<?= htmlentities($event['image']);?>">
                <?php endif;?>
                <?php endif;?>



                <div class="form-group">
                    <label for="longi">Longitude :</label>
                    <input class="form-control" value="<?php echo $longi;?>" type="text" placeholder="Longitude" name="longi" id="longi" />
                </div>

                <div class="form-group">
                    <label for="lati">Latitude :</label>
                    <input class="form-control" value="<?php echo $lati;?>" type="text" placeholder="Latitude" name="lati" id="lati" />
                </div>



                <div class="form-group">
                    <label for="is_published">Publié ?</label>
                    <select class="form-control" name="is_published" id="is_published">
                        <option value="0" <?= isset($event) && $event['is_publish'] == 0 ? 'selected' : '';?>>Non</option>
                        <option value="1" <?= isset($event) && $event['is_publish'] == 1 ? 'selected' : '';?>>Oui</option>
                    </select>
                </div>

                <!-- Si $article existe, on ajoute un champ caché contenant l'id de l'article à modifier pour la requête UPDATE -->
                <?php if(isset($event)): ?>
                    <input type="hidden" name="id" value="<?= $event['id']; ?>" />
                <?php endif; ?>

                <div class="text-right">
                    <!-- Si $article existe, on affiche un lien de mise à jour -->
                    <?php if(isset($_GET['event_id'])): ?>
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                        <!-- Sinon on afficher un lien d'enregistrement d'un nouvel article -->
                    <?php else: ?>
                        <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                    <?php endif; ?>
                </div>

            </form>
                </div>

                <?php if(isset($event)): ?>
                    <div class="tab-pane container-fluid <?php if(isset($_POST['add_image']) || isset($_POST['delete_image'])): ?>active<?php endif; ?>" id="images" role="tabpanel">


                        <?php if(isset($imgMessage)): //si un message a été généré plus haut, l'afficher ?>
                            <div class="bg-success text-white p-2 my-4">
                                <?= $imgMessage; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($messagesImages)) :?>
                            <?php foreach ($messagesImages as $mess) :?>
                                <?php echo $mess;?></br>
                            <?php endforeach;?>
                        <?php endif ;?>


                        <h5 class="mt-4"><?php if(isset($image)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> une image ou une vidéo:</h5>

                        <form action="event-form.php?event_id=<?= $event['id']; ?>&action=edit" method="post" enctype="multipart/form-data">
<!--                            <div class="form-group">-->
<!--                                <label for="caption">Légende :</label>-->
<!--                                <input class="form-control" type="text" placeholder="Légende" name="caption" id="caption" />-->
<!--                            </div>-->
                            <div class="form-group">
                                <label for="image">Fichier :</label>
                                <input class="form-control" type="file" name="image" id="image" />
                            </div>

                            <div class="form-group">
                                <label for="video">Iframe Youtube :</label>
                                <input class="form-control" type="text" placeholder="copier l'iframe youtube" name="video" id="video"/>
                            </div>

                            <div class="form-group">
                                <label for="type">Type de document </label>
                                <select  name="type" id="type">
                                        <option value="image">Image</option>
                                    <option value="video">Vidéo</option>
                                </select>
                            </div>

                            <input type="hidden" name="event_id" value="<?= $event['id']; ?>" />

                            <div class="text-right">
                                <input class="btn btn-success" type="submit" name="add_image" value="Enregistrer" />
                            </div>
                        </form>

                        <div class="row">
                            <h5 class="col-12 pb-4">Liste des images :</h5>
                            <?php foreach($eventImages as $image): ?>
                                <form action="event-form.php?event_id=<?= $event['id']; ?>&action=edit" method="post" class="col-4 my-3">
                                    <?php if ($image['type'] === "video") :?>

                                        <?= $image['image'];?>


                                    <?php else :?>
                                        <img src="../assets/image/<?= $image['image']; ?>" alt="" class="img-fluid" />
                                    <?php endif;?>
<!--                                    <p class="my-2">--><?//= $image['caption']; ?><!--</p>-->
                                    <input type="hidden" name="img_id" value="<?= $image['id']; ?>" />
                                    <div class="text-right"><input class="btn btn-danger" type="submit" name="delete_image" value="Supprimer" /></div>
                                </form>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


        </section>
    </div>
</div>


</body>
</html>
