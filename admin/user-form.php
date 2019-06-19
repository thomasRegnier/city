<?php require ('tools/tools.php');


if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
    header('location:../index.php');
    exit;
}


$name = isset($_POST['name']) ? $_POST['name'] : NULL ;
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : NULL ;
//$adress = isset($_POST['adress']) ? $_POST['adress'] : NULL ;
$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL ;
$phone = isset($_POST['phone']) ? $_POST['phone'] : NULL ;
$adressG = isset($_POST['searchTextField']) ? $_POST['searchTextField'] : NULL ;


$streetNumber = isset($_POST['numberStreet']) ? $_POST['numberStreet'] : NULL ;
$street = isset($_POST['street']) ? $_POST['street'] : NULL ;
$zipcode =  isset($_POST['zipcode']) ? $_POST['zipcode'] : NULL ;
$city = isset($_POST['city']) ? $_POST['city'] : NULL ;


if(isset($_GET['user_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){

    $query = $db->prepare('SELECT * FROM user WHERE id = ?');
    $query->execute(array($_GET['user_id']));
    //$article contiendra les informations de l'article dont l'id a été envoyé en paramètre d'URL
    $user = $query->fetch();

    $id = $user['id'];
    $name = $user['name'];
    $firstname = $user['firstname'];
    $adressG = $user['adress'];
    $mail = $user['mail'];
    $phone = $user['phone'];
   // $password = $user['password'];

    $streetNumber = intval($user['streetNumber']);
    $street = $user['street'];
    $zipcode = intval($user['zipcode']);
    $city = $user['city'];
}


if (isset($_POST['save']) OR isset($_POST['update'])) {

    $messages = [];

    $newNum = intval($_POST['numberStreet']);
    $newZip = intval($_POST['zipcode']);

    if (empty($_POST['name'])) {
        $messages['title'] = 'Nom est obligatoire';
    }

    if (empty($_POST['firstname'])) {
        $messages['firstname'] = 'Prénom est obligatoire';
    }


  //  if (empty($_POST['adress'])) {
//        if (empty($_POST['searchTextField'])){
//        $messages['adress'] = 'l\'adresse est obligatoire';
//    }

    if (empty($_POST['mail'])) {
        $messages['mail'] = 'email obligatoire';
    }


    if (empty($_POST['phone'])) {
        $messages['phone'] = 'Téléphone obligatoire';
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

    if (isset($_POST['save'])){


        if (!empty($_POST['mail'])){

            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $messages['mailerror'] = 'email invalide';
            }
            else{
                $query = $db->prepare('SELECT * FROM user WHERE mail = ?');
                $query->execute(array($_POST['mail']));
                //$article contiendra les informations de l'article dont l'id a été envoyé en paramètre d'URL
                $user = $query->fetch();

                if ($user){
                    $messages['mailExist'] = 'L email existe déja';

                }
            }


        }
        if (empty($messages)) {

            $password = rand();

            $query = $db->prepare('INSERT INTO user (name, firstname, mail, password, is_admin, is_update, phone, streetNumber, street , zipcode, city) VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?)');
            $newUser = $query->execute([
                $_POST['name'],
                $_POST['firstname'],
               // $_POST['adress'],
                $_POST['mail'],
                hash('md5', $password),
                $_POST['is_admin'],
                $_POST['is_update'],
                $_POST['phone'],
                $newNum,
                $_POST['street'],
                $newZip,
                $_POST['city']
            ]);


            if ($newUser) {
                $to      = $_POST['mail'];
                $subject = 'Envoyé depuis Mairie saint leu';
                $message = "Votre mot de passe est : " . $password;
                $headers = array(
                    'From' => "thomas.regnier3001@gmail.com",
                    'Reply-To' => "thomas.regnier3001@gmail.com",
                    'X-Mailer' => 'PHP/' . phpversion()
                );

                mail($to, $subject, $message, $headers);

                //redirection après enregistrement
                $_SESSION['message'] = 'Utilisateur ajouté !';
                header('location:user-list.php');
                exit;
            } else { //si pas $newArticle => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
                $message = "Impossible d'enregistrer le nouvel utlisateur...";
            }
        }
    }

    else {
        if (empty($messages)) {

            $query = $db->prepare('UPDATE user SET
		name = :name,
		firstname = :firstname,
		mail = :mail,
		is_admin = :is_admin,
		is_update = :is_update,
		phone = :phone,
		streetNumber = :streetNumber,
		street = :street,
		zipcode = :zipcode,
		city = :city
		WHERE id = :id'
            );


            //mise à jour avec les données du formulaire
            $updateUser = $query->execute([
                'name' => $_POST['name'],
                'firstname' => $_POST['firstname'],
              //  'adress' => $_POST['searchTextField'],
                'mail'=> $_POST['mail'],
              //  'password' => $user['password'],
                'is_admin'=> $_POST['is_admin'],
                'is_update' => $_POST['is_update'],
                'phone' => $_POST['phone'],
                'streetNumber' => $newNum,
                'street' => $_POST['street'],
                'zipcode' => $newZip,
                'city' => $_POST['city'],
                'id' => $_POST['id']
            ]);


            if ($updateUser) {
                //redirection après enregistrement
                $_SESSION['message'] = 'Utilisateur Modifié';
                header('location:user-list.php');
                exit;
            } else { //si pas $newArticle => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
                $message = "Impossible d'enregistrer le nouvel événement...";
            }
        }
    }





}

;?>
<!DOCTYPE html>
<html>
<head>
    <title>Administration des utilisateurs !</title>
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
                <h4><?php if(isset($_GET['user_id'])): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un utilisateur</h4>
            </header>

            <?php if (!empty($messages)) :?>
                <?php foreach ($messages as $msg) :?>
                    <?php echo $msg;?></br>
                <?php endforeach;?>
            <?php endif ;?>

<!-- Si $article existe, chaque champ du formulaire sera pré-remplit avec les informations de l'article -->
            <form <?php if(isset($_GET['user_id'])): ?>
                action="user-form.php?user_id=<?=$_GET['user_id'];?>&action=edit"
            <?php else: ?>
                action="user-form.php"
            <?php endif;?>
                method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input class="form-control" value="<?php echo $name;?>" type="text"  placeholder="Nom" name="name" id="name" />
                </div>

                <div class="form-group">
                    <label for="firstname">Prénom :</label>
                    <input class="form-control" value="<?php echo $firstname;?>" type="text"  placeholder="Prénom" name="firstname" id="firstname" />
                </div>

<!--                <div class="form-group">-->
<!--                    <label for="adress">Adresse :</label>-->
<!--                    <input class="form-control" id="searchTextField"  value="--><?php //echo $adressG;?><!--" name="searchTextField" type="text" aria-placeholder="Test" size="50" placeholder="15 rue de paris, Saint leu la forêt">-->
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
                    <label for="mail">Adresse mail:</label>
                    <input class="form-control" value="<?php echo $mail;?>" type="email"  placeholder="user@mail.fr"  name="mail" id="mail" />
                </div>


                <div class="form-group">
                    <label for="phone">Téléphonne :</label>
                    <input class="form-control" value="<?php echo $phone;?>" maxlength="10"  placeholder="0129101910" type="tel"  name="phone" id="phone" />
                </div>



                <div class="form-group">
                    <label for="is_update">Confirmation des informations :</label>
                    <select class="form-control" name="is_update" id="is_update">
                        <option value="0" <?= isset($user) && $user['is_update'] == 0 ? 'selected' : '';?>>Non</option>
                        <option value="1" <?= isset($user) && $user['is_update'] == 1 ? 'selected' : '';?>>Oui</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="is_admin">Admin ?</label>
                    <select class="form-control" name="is_admin" id="is_admin">
                        <option value="0" <?= isset($user) && $user['is_admin'] == 0 ? 'selected' : '';?>>Non</option>
                        <option value="1" <?= isset($user) && $user['is_admin'] == 1 ? 'selected' : '';?>>Oui</option>
                    </select>
                </div>



                <!-- Si $article existe, on ajoute un champ caché contenant l'id de l'article à modifier pour la requête UPDATE -->
                <?php if(isset($user)): ?>
                    <input type="hidden" name="id" value="<?= $user['id']; ?>" />
                <?php endif; ?>

                <div class="text-right">
                    <!-- Si $article existe, on affiche un lien de mise à jour -->
                    <?php if(isset($_GET['user_id'])): ?>
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                        <!-- Sinon on afficher un lien d'enregistrement d'un nouvel article -->
                    <?php else: ?>
                        <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                    <?php endif; ?>
                </div>

            </form>

        </section>
    </div>
</div>





<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA35yi0pZC7eRhjk7P2fibGi-8YXSrzkts&libraries=places"></script>

<script>



    var input = document.getElementById('city');
    var options = {

        componentRestrictions: {country: 'fr'}
    };

    autocomplete = new google.maps.places.Autocomplete(input, options);
</script>

</body>
</html>
