<?php require ('tools/tools.php');

if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
    header('location:../index.php');
    exit;
}

if(isset($_GET['bill_id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {


    $query = $db->prepare('SELECT file FROM bills WHERE id = ?');
    $result = $query->execute([
        $_GET['bill_id']
    ]);


    $imgSelect = $query->fetch();


        $pathForImg = '../assets/image/';


        unlink($pathForImg . $imgSelect['file']);


    $query = $db->prepare('DELETE FROM bills WHERE id = ?');
    $result = $query->execute([
        $_GET['bill_id']
    ]);

    if($result){
        $message = "Suppression efféctuée.";
    }
    else{
        $message = "Impossible de supprimer la séléction.";
    }

}





$query = $db->query('SELECT bills.id, bills.title, bills.date, bills.status ,user.name , user.firstname ,bills.user_id
                                FROM bills
                                 JOIN user
                                 ON bills.user_id = user.id
                                ');
                                $bills = $query->fetchall();


;?>


<!DOCTYPE html>
<html>
<head>
    <title>Administration des facturess - Mon premier blog !</title>
    <?php require 'partials/head_assets.php'; ?>
</head>
<body class="index-body">
<div class="container-fluid">
    <?php require 'partials/header.php'; ?>
    <div class="row my-3 index-content">
        <?php require 'partials/nav.php'; ?>
        <section class="col-9">
            <header class="pb-4 d-flex justify-content-between">
                <h4>Liste des factures</h4>
                <a class="btn btn-primary" href="bill-form.php">Ajouter une facture</a>
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

            <?php if($bills): ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>#User</th>
                        <th>Name</th>
                        <th>Firstame</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($bills as $bill): ?>
                        <tr>
                            <th><?= htmlentities($bill['id']); ?></th>
                            <td><?= htmlentities($bill['user_id']); ?></td>
                            <td><?= htmlentities($bill['name']); ?></td>
                            <td><?= htmlentities($bill['firstname']); ?></td>
                            <td><?= htmlentities($bill['title']); ?></td>
                            <td><?= $bill['status'] == 1 ? 'Oui' : 'Non' ?></td>
                            <td>
                                <a href="bill-form.php?bill_id=<?= $bill['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                                <a onclick="return confirm('Are you sure?')" href="bills-list.php?bill_id=<?= $bill['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                Aucune facture enregistré.
            <?php endif; ?>
        </section>
    </div>
</div>
</body>
</html>