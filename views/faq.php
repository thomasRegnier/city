<?php $title = "F.A.Q";?>

<?php require './assets/header.php'; ?>
<section class="imgUp">
    <div class="forTitleUp">
        <span class="pageHomeFaq forPageSpan">F.A.Q</span>
    </div>
    <div class="responstitleUp pageHomeFaq" >
        F.A.Q
    </div>
</section>

<h1 class="indexFaq">F.A.Q</h1>



<!--    <div id="testFaq">-->
<!--        --><?php //foreach ($allFaq as $key => $category) :?>
<!--        <div>-->
<!--        <div class="question">-->
<!--            --><?php //echo $category['qestion'];?>
<!--        </div>-->
<!--            <span class="forSeeResp">Voir réponse</span>-->
<!--            <div class="hideResp response">-->
<!--                --><?php //echo $category['response'];?>
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //endforeach ;?>
<!--    </div>-->


<main class="try">
    <?php foreach ($faqCategory as $key => $category) :?>
        <div class="insideTry">
            <article>
                <?php echo $category['name'];?><span><i id="arrow" class="fas fa-caret-down"></i></span></article>
            <div id="testFaq">
                <?php foreach ($quest as $key => $cat):?>
                    <?php if ($category['id'] === $cat['id_faq_category']):?>
                        <div>
                            <div class="question">
                                <?php echo $cat['qestion'];?>
                            </div>
                            <span class="forSeeResp">Voir réponse</span>
                            <div class="hideResp response">
                                <?php echo $cat['response'];?>
                            </div>
                        </div>
                    <?php endif;?>

                <?php endforeach ;?>
            </div>
        </div>
    <?php endforeach ;?>
</main>




<!--<main class="containerFaq">-->
<!--<section class="navCategory">-->
<!--    --><?php //foreach ($faqCategory as $key => $category) :?>
<!---->
<!--      <div id="--><?php //echo $category['id'];?><!--" class="insideCategory">-->
<!--          --><?php //echo $category['name'];?>
<!--      </div>-->
<!---->
<!--    --><?php //endforeach ;?>
<!--</section>-->
<!--    <div class="loader"></div>-->
<!---->
<!--    <section id="forQuest">-->
<!--</section>-->
<!---->
<!--</main>-->
<script src="./js/faq.js"></script>

<?php require './assets/footer.php'; ?>
