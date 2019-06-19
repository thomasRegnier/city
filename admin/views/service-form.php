<!DOCTYPE html>
<html>
<head>
    <title>Administration des articles - Mon premier blog !</title>
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
                <h4><?php if(isset($service)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un service</h4>
            </header>
            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-danger text-white">
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <?php// if (!empty($messages)) :?>
                <?php// foreach ($messages as $msg) :?>
                    <?php// echo $msg;?></br>
                <?php// endforeach;?>
            <?php// endif ;?>

            <?php if (!empty($messages['success'])):?>
                <?php echo $messages['succes']; ?>
            <?php endif;?>

            <!-- Si $article existe, chaque champ du formulaire sera pré-remplit avec les informations de l'article -->
            <form action="index.php?page=service-form" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Nom du service :</label>
                    <input class="form-control" value="<?= isset($service) ? htmlentities($service['title']) : '';?>" type="text" placeholder="Nom" name="title" id="title" />
                </div>
                <?php if (!empty($messages['title'])):?>
               <article class="warning"> <?php echo $messages['title']; ?></article>
                <?php endif;?>
                <div class="form-group">
                    <label for="adress">Adresse :</label>
                    <input class="form-control" value="<?= isset($service) ? htmlentities($service['adress']) : '';?>" type="text" placeholder="ex : 15 rue de paris, 95320 Saint leu la forêt" name="adress" id="adress" />
                </div>
                <?php if (!empty($messages['adress'])):?>
                    <?php echo $messages['adress']; ?>
                <?php endif;?>

                <div class="form-group">
                    <label for="dayOpen">Jours d'ouverture :</label>
                    <input class="form-control" value="<?= isset($service) ? htmlentities($service['days_opened']) : '';?>" type="text" placeholder="Lundi, Mardi et Jeudi" name="dayOpen" id="dayOpen" />
                </div>
                <?php if (!empty($messages['days'])):?>
                    <?php echo $messages['days']; ?>
                <?php endif;?>

                <div class="form-group">
                    <label for="morning">Horaires de matinée :</label>
                    <input class="form-control" value="<?= isset($service) ? htmlentities($service['open_at']) : '';?>" type="text" placeholder="8h 12h" name="morning" id="morning" />
                </div>
                <?php if (!empty($messages['morning'])):?>
                    <?php echo $messages['morning']; ?>
                <?php endif;?>

                <div class="form-group">
                    <label for="afternoon">Horaires d'aprés-midi :</label>
                    <input class="form-control" value="<?= isset($service) ? htmlentities($service['close_at']) : '';?>" type="text" placeholder="14h 17h" name="afternoon" id="afternoon" />
                </div>
                <?php if (!empty($messages['afternoon'])):?>
                    <?php echo $messages['afternoon']; ?>
                <?php endif;?>

                <div class="form-group">
                    <label for="phone">Numéro de téléphone :</label>
                    <input class="form-control" value="<?= isset($service) ? htmlentities($service['phone']) : '';?>" type="text" placeholder="Numéro" name="phone" id="phone" />
                </div>
                <?php if (!empty($messages['phone'])):?>
                    <?php echo $messages['phone']; ?>
                <?php endif;?>

                <div class="form-group">
                    <label for="image">Image :</label>
                    <input class="form-control" type="file" name="image" id="image"/>
                </div>
                <?php if (isset($service['image'])):?>
                <img src="../assets/image/<?= htmlentities($service['image']);?>">
                <?php endif;?>


                <?php if (!empty($messages['image'])):?>
                    <?php echo $messages['image']; ?>
                <?php endif;?>

                <div class="form-group">
                    <label for="longi">Longitude :</label>
                    <input class="form-control" value="<?= isset($service) ? htmlentities($service['lattitude']) : '';?>" type="text" placeholder="Longitude" name="longi" id="longi" />
                </div>
                <?php if (!empty($messages['long'])):?>
                    <?php echo $messages['long']; ?>
                <?php endif;?>

                <div class="form-group">
                    <label for="lati">Latitude :</label>
                    <input class="form-control" value="<?= isset($service) ? htmlentities($service['longitude']) : '';?>" type="text" placeholder="Latitude" name="lati" id="lati" />
                </div>
                <?php if (!empty($messages['lat'])):?>
                    <?php echo $messages['lat']; ?>
                <?php endif;?>

                <div class="text-right">
                    <!-- Si $article existe, on affiche un lien de mise à jour -->
                    <?php if(isset($service)): ?>
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                        <!-- Sinon on afficher un lien d'enregistrement d'un nouvel article -->
                    <?php else: ?>
                        <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                    <?php endif; ?>
                </div>

                <!-- Si $article existe, on ajoute un champ caché contenant l'id de l'article à modifier pour la requête UPDATE -->
                <?php if(isset($service)): ?>
                    <input type="hidden" name="id" value="<?= $service['id']; ?>" />
                <?php endif; ?>

            </form>

        </section>
    </div>
</div>


</body>
</html>
