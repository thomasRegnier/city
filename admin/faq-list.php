<?php require ('tools/tools.php');

if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
    header('location:../index.php');
    exit;
}

if(isset($_GET['faq_id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {


    $query =$db ->prepare('DELETE FROM faq_questions WHERE id_faq_category = ?');
        $resultCat = $query->execute([
            $_GET['faq_id']
        ]);


    $query = $db->prepare('DELETE FROM faq_category WHERE id = ?');
    $resultCat = $query->execute([
        $_GET['faq_id']
    ]);

    //générer un message à afficher pour l'administrateur
    if($resultCat){
        $message = "Suppression efféctuée.";
    }
    else{
        $message = "Impossible de supprimer la séléction.";
    }

}

if(isset($_GET['quest_id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {

    $query = $db->prepare('DELETE FROM faq_questions WHERE id = ?');
    $result = $query->execute([
        $_GET['quest_id']
    ]);

    //générer un message à afficher pour l'administrateur
    if($result){
        $message = "Suppression efféctuée.";
    }
    else{
        $message = "Impossible de supprimer la séléction.";
    }

}

$query = $db->query('SELECT id , name FROM faq_category');
                                $faq = $query->fetchall();

$queryQuest = $db->query('SELECT * FROM faq_questions');
                    $quests = $queryQuest->fetchAll();
;?>


<!DOCTYPE html>
<html>
<head>
    <title>Administration de la FAQ</title>
    <?php require 'partials/head_assets.php'; ?>
</head>
<body class="index-body">
<div class="container-fluid">
    <?php require 'partials/header.php'; ?>
    <div class="row my-3 index-content">
        <?php require 'partials/nav.php'; ?>
        <section class="col-9">
            <header class="pb-4 d-flex justify-content-between">
                <h4>Liste de la FAQ</h4>
                <a class="btn btn-primary" href="faq-form.php">Ajouter une categorie FAQ</a>
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

            <?php if($faq): ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Questions</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($faq as $cat): ?>
                        <tr>
                            <td style="width: 60%"><h3><?= htmlentities($cat['name']); ?></h3></td>
                            <td>
                                <?php  $query = $db->prepare("SELECT COUNT(*) FROM faq_questions WHERE id_faq_category = ?");
                                            $query->execute(array($cat['id']));
                                                $nb = $query->fetchColumn();;?>

                            <td>
                                <a href="faq-form.php?faq_id=<?= $cat['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                                <a onclick="return confirm('Are you sure?')" href="faq-list.php?faq_id=<?= $cat['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
                            </td>
                        </tr>
                        <th>
                            Questions/Réponses <?php echo ("($nb)");?>
                            <a href="quest-form.php?faq_id=<?= $cat['id']; ?>" class="btn btn-info"><i class="fas fa-plus"></i></a>

                        </th>
                        <?php foreach ($quests as $key => $quest):?>

                            <?php if ($cat['id'] === $quest['id_faq_category']):?>
                            <tr>
                                <td style="background-color: white; border: none">
                                    <article style="color: #46a6ff"><b><?php echo $quest['qestion'];?></b></article>
                                    <article><?php echo $quest['response'];?></article>
                                </td>
                                <td class="forButtonFaq"><a href="quest-form.php?quest_id=<?= $quest['id']; ?>&action=edit" class="btn btn-warning"><i class="far fa-edit"></i></a>
                                    <a onclick="return confirm('Are you sure?')" href="faq-list.php?quest_id=<?= $quest['id']; ?>&action=delete" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                Aucune FAQ enregistré.
            <?php endif; ?>
        </section>
    </div>
</div>

<iframe width="300" height="200" src="https://www.youtube.com/embed/AO-0Ma2nbLA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</body>
</html>
