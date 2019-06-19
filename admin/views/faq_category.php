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
                <h4>Liste des Categories FAQ</h4>
                <a class="btn btn-primary" href="index.php?page=user-form.php">Ajouter une catégorie</a>
            </header>
            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-success text-white p-2 mb-4">
                    <?= $message; ?>
                </div>
            <?php endif; ?>
            <?php if($faqCategory): ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Catégories</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($faqCategory as $category): ?>
                        <tr>
                            <th><?= htmlentities($category['id']); ?></th>
                            <td><?= htmlentities($category['name']); ?></td>
                            <td>
                                <a href="user-form.php?user_id=<?= $category['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                                <a onclick="return confirm('Are you sure?')" href="user-list.php?user_id=<?= $event['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
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