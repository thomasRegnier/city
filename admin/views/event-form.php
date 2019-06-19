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
            <header class="pb-3">
                <!-- Si $article existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
                <h4><?php if(isset($service)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un événement</h4>
            </header>

            <?php if (!empty($messages)) :?>
                <?php foreach ($messages as $msg) :?>
                    <?php echo $msg;?></br>
                <?php endforeach;?>
            <?php endif ;?>


            <?php
            if (isset($_SESSION['errorMessages'])){
                foreach ($_SESSION['errorMessages'] as $message){
                    echo $message;
                }
                unset($_SESSION['errorMessages']);
            }
            ;?>

            <!-- Si $article existe, chaque champ du formulaire sera pré-remplit avec les informations de l'article -->
            <form action="index.php?page=event-form" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Nom de l'évenements :</label>
                    <input class="form-control" value="<?= isset($event) ? htmlentities($event['title']) : '';?>" type="text" placeholder="Nom" name="title" id="title" />
                </div>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <input class="form-control" value="<?= isset($event) ? htmlentities($event['description']) : '';?>" type="text" placeholder="Description de l'événement" name="description" id="description" />
                </div>


                <div class="form-group">
                    <label for="content">Contenu:</label>
                    <textarea class="form-control"  type="text" placeholder="Contenu de l'événement" name="content" id="content" /><?= isset($event) ? htmlentities($event['content']) : '';?></textarea>
                </div>


                <div class="form-group">
                    <label for="adress">Adresse :</label>
                    <input class="form-control" value="<?= isset($event) ? htmlentities($event['adress']) : '';?>" type="text" placeholder="ex : 15 rue de paris, 95320 Saint leu la forêt" name="adress" id="adress" />
                </div>


                <div class="form-group">
                    <label for="dateEvent">Date de l'événement :</label>
                    <input class="form-control" value="<?= isset($event) ? htmlentities($event['event_date']) : '';?>" type="date"  name="dateEvent" id="dateEvent" />
                </div>


                <div class="form-group">
                    <label for="publish_at">Publié le  :</label>
                    <input class="form-control" value="<?= isset($event) ? htmlentities($event['publish_at']) : '';?>" type="date"  name="publish_at" id="publish_at" />
                </div>

                <div class="form-group">
                    <label for="image">Image :</label>
                    <input class="form-control" type="file" name="image" id="image"/>
                </div>

                <?php if (isset($event['image'])):?>
                    <img src="../assets/image/<?= htmlentities($event['image']);?>">
                <?php endif;?>


                <div class="form-group">
                    <label for="longi">Longitude :</label>
                    <input class="form-control" value="<?= isset($event) ? htmlentities($event['longitude']) : '';?>" type="text" placeholder="Longitude" name="longi" id="longi" />
                </div>

                <div class="form-group">
                    <label for="lati">Latitude :</label>
                    <input class="form-control" value="<?= isset($event) ? htmlentities($event['lattitude']) : '';?>" type="text" placeholder="Latitude" name="lati" id="lati" />
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
                    <?php if(isset($event)): ?>
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
