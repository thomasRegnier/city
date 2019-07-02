<?php require ('tools/tools.php');


if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
    header('location:../index.php');
    exit;
}



$title = isset($_POST['title']) ? $_POST['title'] : NULL ;
$amount = isset($_POST['amount']) ? $_POST['amount'] : NULL ;
$date = isset($_POST['date']) ? $_POST['date'] : NULL ;
$userFact = isset($_POST['userFact']) ? $_POST['user_id'] : NULL ;



if(isset($_GET['bill_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){

    $query = $db->prepare('SELECT bills.id, bills.title, bills.date ,bills.status, bills.file ,bills.amount, bills.user_id, user.name
                                  FROM bills
                                   JOIN user
                                   ON bills.user_id = user.id
                                   WHERE bills.id = ?');
                                    $query->execute(array($_GET['bill_id']));
    //$article contiendra les informations de l'article dont l'id a été envoyé en paramètre d'URL
    $bill = $query->fetch();

    $title = $bill['title'];
    $amount = $bill['amount'];
    $fileActual = $bill['file'];
    $id_user = $bill['user_id'];
    $date = $bill['date'];

}




if (isset($_POST['save']) OR isset($_POST['update'])) {
    $messages = [];

    if (empty($_POST['title'])) {
        $messages['title'] = 'titre est obligatoire';
    }

    if (empty($_POST['amount'])) {
        $messages['firstname'] = 'Montant est obligatoire';
    }


     if (empty($_POST['date'])) {
        $messages['date'] = 'la date est obligatoire';
    }

    if (empty($_POST['user_id'])) {
        $messages['id-user'] = 'l\' utiliateur est obligatoire';
    }


    if (isset($_POST['save'])) {
        if (isset($_FILES['file'])) {

            if ($_FILES['file']['error'] === 0) {

                $allowed_extensions = array('pdf');

                $my_file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);


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
                $messages['error'] = "le document est obligatoire";


            }

        }

        if (empty($messages)) {

            $query = $db->prepare('INSERT INTO bills (user_id, title, date, status, file, amount) VALUES (?, ?, ?, ?, ?,?)');
            $newBill = $query->execute([
                $_POST['user_id'],
                $_POST['title'],
                $_POST['date'],
                $_POST['status'],
                $nameImg,
                $_POST['amount']
            ]);

            move_uploaded_file($_FILES['file']['tmp_name'], $destination);

            if ($newBill) {
                //redirection après enregistrement
                $_SESSION['message'] = 'Facture ajouté !';
                header('location:bills-list.php');
                exit;
            } else { //si pas $newArticle => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
                $message = "Impossible d'enregistrer le nouvel événement...";
            }
        }


    }
    elseif (isset($_POST['update'])){

        if ($_FILES['file']['error'] === 0) {

            $allowed_extensions = array('pdf');

            $my_file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);


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
            $query = $db->prepare('UPDATE bills SET
		user_id = :user_id,
		title = :title,
		date = :date,
		status = :status,
		file = :file,
		amount = :amount
		WHERE id = :id'
            );


            //mise à jour avec les données du formulaire
            $updateEvent = $query->execute([
                'user_id' =>  $_POST['user_id'],
                'title' => $_POST['title'],
                'date' => $_POST['date'],
                'status'=> $_POST['status'],
                'file' => $nameImg,
                'amount'=> $_POST['amount'],
                'id' => $_POST['id']
            ]);

            if ($nameImg != $_POST['imageActual']){

                $pathForImg = '../assets/image/';

                unlink($pathForImg. $_POST['imageActual']);

                move_uploaded_file($_FILES['file']['tmp_name'], $destination);
            }

            if ($updateEvent) {
                //redirection après enregistrement
                $_SESSION['message'] = 'Facture Modifié';
                header('location:bills-list.php');
                exit;
            } else { //si pas $newArticle => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
                $message = "Impossible d'enregistrer la nouvelle facture...";
            }
        }

    }



}


;?>

<!DOCTYPE html>
<html>
<head>
    <title>Administration des factures !</title>
    <?php require 'partials/head_assets.php'; ?>
</head>
<body class="index-body">
<div class="container-fluid">
    <?php require 'partials/header.php'; ?>
    <div class="row my-3 index-content">
        <?php require 'partials/nav.php'; ?>
        <section class="col-9">
            <header class="pb-3">
                <!-- Si $article existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
                <h4><?php if(isset($_GET['bill_id'])): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> une facture</h4>
            </header>

            <?php if (!empty($messages)) :?>
                <?php foreach ($messages as $msg) :?>
                    <?php echo $msg;?></br>
                <?php endforeach;?>
            <?php endif ;?>


            <!-- Si $article existe, chaque champ du formulaire sera pré-remplit avec les informations de l'article -->
            <form <?php if(isset($_GET['bill_id'])): ?>
                action="bill-form.php?bill_id=<?=$_GET['bill_id'];?>&action=edit"
            <?php else: ?>
                action="bill-form.php"
            <?php endif;?>
                method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Facture:</label>
                    <input class="form-control" value="<?php echo $title;?>" type="text"  placeholder="Facture" name="title" id="title" />
                </div>

                <div class="form-group">
                    <label for="amount">Montant :</label>
                    <input class="form-control" value="<?php echo $amount;?>" type="number"  placeholder="Montant" name="amount" id="amount" />
                </div>

                <div class="form-group">
                    <label for="date">Date  :</label>
                    <input class="form-control" value="<?php echo $date;?>" type="date"   name="date" id="date" />
                </div>

                <div class="form-group">
                    <label for="file">Document :</label>
                    <input class="form-control" type="file" name="file" id="file"/>
                </div>


                <?php if (isset($_GET['bill_id'])):?>
                    <?php if (isset($bill['file'])):?>
                        <input type="hidden" name="imageActual" value="<?= htmlentities($bill['file']);?>">
                        <img src="../assets/image/<?= htmlentities($bill['file']);?>">
                    <?php endif;?>
                <?php endif;?>

                <div class="form-group">
                    <label for="user_id">Utilisateurs :</label>
                    <select multiple class="form-control" name="user_id" id="user_id">
                        <?php
                        $queryCategory= $db ->query('SELECT * FROM user');
                        $users = $queryCategory->fetchAll();
                        ?>
                        <?php foreach($users as $key => $user) : ?>
                            <?php
                            $selected = '';
                                if($user['id'] == $id_user){
                                    $selected = 'selected="selected"';
                            }
                            ?>
                            <option value="<?= $user['id']; ?>" <?= $selected; ?>> <?= $user['name']; ?> </option>
                        <?php endforeach; ?>




                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Payée ?</label>
                    <select class="form-control" name="status" id="status">
                        <option value="0" <?= isset($bill) && $bill['status'] == 0 ? 'selected' : '';?>>Non</option>
                        <option value="1" <?= isset($bill) && $bill['status'] == 1 ? 'selected' : '';?>>Oui</option>
                    </select>
                </div>



                <!-- Si $article existe, on ajoute un champ caché contenant l'id de l'article à modifier pour la requête UPDATE -->
                <?php if(isset($bill)): ?>
                    <input type="hidden" name="id" value="<?= $bill['id']; ?>" />
                <?php endif; ?>

                <div class="text-right">
                    <!-- Si $article existe, on affiche un lien de mise à jour -->
                    <?php if(isset($_GET['bill_id'])): ?>
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


</body>
</html>
