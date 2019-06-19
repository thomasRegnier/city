<!DOCTYPE html>
<html>
<head>
    <title>Administration des services</title>
    <?php require 'partials/head_assets.php'; ?>
</head>
<body class="index-body">
<div class="container-fluid">
    <?php require 'partials/header.php'; ?>
    <div class="row my-3 index-content">
        <?php require 'partials/nav.php'; ?>
        <section class="col-9">
            <header class="pb-4 d-flex justify-content-between">
                <h4>Liste des services</h4>
                <a class="btn btn-primary" href="index.php?page=service-form">Ajouter un service</a>
            </header>
            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-success text-white p-2 mb-4">
                    <?= $message; ?>
                </div>
            <?php endif; ?>
            <?php if($services): ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Adress</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($services as $service): ?>
                        <tr>
                            <th><?= htmlentities($service['id']); ?></th>
                            <td><?= htmlentities($service['title']); ?></td>
                            <td><?= htmlentities($service['adress']); ?></td>
                            <td>
                                <a href="index.php?page=service-form&article_id=<?= $service['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                                <a onclick="return confirm('Are you sure?')" href="user-list.php?user_id=<?= $service['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                Aucun utilisateur enregistré.
            <?php endif; ?>
        </section>
    </div>
</div>
</body>
</html>