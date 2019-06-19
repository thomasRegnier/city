<?php
require_once('models/faq.php');


$faqCategory = getCategory();

$allFaq = getAllCat();

$quest = getQuest();

require_once('views/faq.php');
