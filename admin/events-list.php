<?php require ('tools/tools.php');

if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
    header('location:../index.php');
    exit;
}

if(isset($_GET['event_id']) && isset($_GET['action']) && $_GET['action'] == 'delete'){


    $query = $db->prepare('SELECT * FROM medias WHERE events_id = ?');
    $result = $query->execute([
        $_GET['event_id']
    ]);

    $mediasSelect=$query->fetchAll();

    if ($mediasSelect){
        foreach ($mediasSelect as $key => $media){

            if ($media['type'] == 'image'){
                $pathForImg = '../assets/image/';

                unlink($pathForImg. $media['image']);
            }

        }


    }

    $query = $db->prepare('DELETE FROM medias WHERE events_id = ?');
    $result = $query->execute([
        $_GET['event_id']
    ]);



    $query = $db->prepare('SELECT image FROM events WHERE id = ?');
    $imgSelect = $query->execute([
        $_GET['event_id']
    ]);


    $imgSelect=$query->fetch();

    $pathForImg = '../assets/image/';



    $query = $db->prepare('DELETE FROM events WHERE id = ?');
    $result = $query->execute([
        $_GET['event_id']
    ]);

    unlink($pathForImg. $imgSelect['image']);



    //générer un message à afficher pour l'administrateur
    if($result){
        $message = "Suppression efféctuée.";
    }
    else{
        $message = "Impossible de supprimer la séléction.";
    }
}


$query = $db->query('SELECT * FROM events ORDER BY id DESC');
$events = $query->fetchall();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Administration des événements</title>
    <?php require 'partials/head_assets.php'; ?>
</head>
<body class="index-body">
<div class="container-fluid">
    <?php require 'partials/header.php'; ?>
    <div class="row my-3 index-content">
        <?php require 'partials/nav.php'; ?>
        <section class="col-9">
            <header class="pb-4 d-flex justify-content-between">
                <h4>Liste des événements</h4>
                <a class="btn btn-primary" href="event-form.php">Ajouter un événement</a>
            </header>
            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-success text-white p-2 mb-4">
                    <?= $message; ?>
                </div>
            <?php endif; ?>


            <?php if(isset($_SESSION['message'])): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-success text-white p-2 mb-4">
                    <?= $_SESSION['message']; ?>
                    <?php unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <?php if($events): ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Publié le</th>
                        <th>Date</th>
                        <th>Publié</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($events as $event): ?>
                        <tr>
                            <th><?= htmlentities($event['id']); ?></th>
                            <td><?= htmlentities($event['title']); ?></td>
                            <td><?= htmlentities($event['publish_at']); ?></td>
                            <td><?= htmlentities($event['event_date']); ?></td>
                            <td><?= $event['is_publish'] == 1 ? 'Oui' : 'Non' ?></td>
                            <td>
                                <a href="event-form.php?event_id=<?= $event['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                                <a onclick="return confirm('Are you sure?')" href="events-list.php?event_id=<?= $event['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                Aucun événement enregistré.
            <?php endif; ?>
        </section>
    </div>
</div>
</body>
</html>