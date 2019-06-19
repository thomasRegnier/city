<?php
//nombre d'enregistrements de la table user
$nbUsers = $db->query("SELECT COUNT(*) FROM user")->fetchColumn();
//nombre d'enregistrements de la table category
$nbCategories = $db->query("SELECT COUNT(*) FROM services")->fetchColumn();
//nombre d'enregistrements de la table article
$nbArticles = $db->query("SELECT COUNT(*) FROM events")->fetchColumn();

$nbFaqCategory = $db->query("SELECT COUNT(*) FROM faq_category")->fetchColumn();

?>
<nav class="col-3 py-2 categories-nav">
    <a class="d-block btn btn-warning mb-4 mt-2" href="../index.php">Site</a>
    <ul>
        <li><a href="user-list.php">Gestion des utilisateurs (<?php echo $nbUsers; ?>)</a></li>
<!--        <li><a href="">Gestion des services (--><?php //echo $nbCategories; ?><!--)</a></li>-->
        <li><a href="events-list.php">Gestion des événements (<?php echo $nbArticles; ?>)</a></li>
        <li><a href="faq-list.php">Gestion des catégories FAQ (<?php echo $nbFaqCategory; ?>)</a></li>
        <li><a href="bills-list.php">Gestion des factures</a></li>
    </ul>
</nav>