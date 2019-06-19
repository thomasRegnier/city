<?php

function getCategory(){


    $db = dbConnect();

    $query = $db->query('SELECT * FROM faq_category');

    return  $query->fetchAll();

}

function getAllCat(){


    $db = dbConnect();


    $query = $db->query('SELECT faq_category.name , faq_questions.qestion, faq_questions.response
    FROM faq_category JOIN faq_questions
    ON faq_category.id = faq_questions.id_faq_category
     ');
    return  $query->fetchAll();

}


function getQuest(){


    $db = dbConnect();


    $query = $db->query('SELECT *
    FROM faq_questions
     ');
    return  $query->fetchAll();

}