<?php require ('tools/tools.php');

if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
    header('location:../index.php');
    exit;
}


$title = isset($_POST['title']) ? $_POST['title'] : NULL ;


if(isset($_GET['faq_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){

    $query = $db->prepare('SELECT * FROM faq_category WHERE id = ?');
    $query->execute(array($_GET['faq_id']));
    //$article contiendra les informations de l'article dont l'id a été envoyé en paramètre d'URL
    $faq = $query->fetch();

    $id = $faq['id'];
    $title = $faq['name'];
}




if (isset($_POST['save']) OR isset($_POST['update'])) {
    $messages = [];

    if (empty($_POST['title'])) {
        $messages['title'] = 'Nom est obligatoire';
    }


    if (isset($_POST['save'])) {
        if (empty($messages)) {

            $query = $db->prepare('INSERT INTO faq_category (name) VALUES (?)');
            $newFaq = $query->execute([
                $_POST['title']
            ]);


            if ($newFaq) {
                //redirection après enregistrement
                $_SESSION['message'] = 'Catégorie ajoutée avec succées';
                header('location:faq-list.php');
                exit;
            } else { //si pas $newArticle => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
                $message = "Impossible d'enregistrer le nouvel événement...";
            }
        }

    }

    else{
        if (empty($messages)) {

            $query = $db->prepare('UPDATE faq_category SET
		name = :name
		WHERE id = :id'
            );


            //mise à jour avec les données du formulaire
            $updateUser = $query->execute([
                'name' => $_POST['title'],
                'id' => $_POST['id']
            ]);


            if ($updateUser) {
                //redirection après enregistrement
                $_SESSION['message'] = 'Catégorie FAQ Modifié';
                header('location:faq-list.php');
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
    <title>Administration des Catégories FAQ !</title>
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
                <h4><?php if(isset($_GET['faq_id'])): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> une catégorie FAQ</h4>
            </header>

            <?php if (!empty($messages)) :?>
                <?php foreach ($messages as $msg) :?>
                    <?php echo $msg;?></br>
                <?php endforeach;?>
            <?php endif ;?>


            <!-- Si $article existe, chaque champ du formulaire sera pré-remplit avec les informations de l'article -->
            <form <?php if(isset($_GET['faq_id'])): ?>
                action=faq-form.php?faq_id=<?=$_GET['faq_id'];?>&action=edit"
            <?php else: ?>
                action="faq-form.php"
            <?php endif;?>
                method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Nom de la catégorie:</label>
                    <input class="form-control" value="<?php echo $title;?>" type="text"  placeholder="Nom" name="title" id="title" />
                </div>



                <!-- Si $article existe, on ajoute un champ caché contenant l'id de l'article à modifier pour la requête UPDATE -->
                <?php if(isset($faq)): ?>
                    <input type="hidden" name="id" value="<?= $faq['id']; ?>" />
                <?php endif; ?>

                <div class="text-right">
                    <!-- Si $article existe, on affiche un lien de mise à jour -->
                    <?php if(isset($_GET['faq_id'])): ?>
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

