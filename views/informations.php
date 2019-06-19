<?php $title = "Informations";?>

<?php require './assets/header.php'; ?>

<section class="imgUp">
    <div class="forTitleUp">
        <span class="pageInfosTitle forPageSpan">Informations</span>
    </div>
    <div class="responstitleUp pageInfosTitle" >
        Informations
    </div>
</section>


<h1 class="infosPages">Notre histoire</h1>
<?php foreach ($history as $key => $story) :?>
    <?php if ($story['id'] % 2 == 1) :?>
    <section id="forStories">
<div class="forStory">
    <img class="imgInfos" src="./assets/image/<?php echo $story['image'];?>">
<article><?php echo $story['content'];?></article>
</div>
<?php elseif ($story['id']% 2 == 0) :?>
<div id="grey" class="forStory">
    <article><?php echo $story['content'];?></article>
    <img class="imgInfos" src="./assets/image/<?php echo $story['image'];?>">
</div>
    <?php endif ;?>
<?php endforeach ;?>
    </section>
<div class="forSeeMore">
    <span id="moreHistory">Voir plus ></span>
</div>

<h1 class="infosPages">Nos services</h1>

<div class="onMap">
</div>

<div class="modal">

    <div class="forCloser">
        <button class="closerOnMap">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="insideOnMap">
        <div class="insideLeft">
             <img class="imgOnMap">
            <div class="titleOnMap">Mairie</div>
            <div class="adrressOnMap">12 rie fvzs ko,</div>
            </div>
    <div class="insideRight">
        <div id="map" style="width: 100%; height: 100%"></div>
    </div>
    </div>
        <div class="forMedias"></div>
    </div>


<section class="forInfos">
    <?php foreach ($services as $key => $serv) :?>
    <div class="insideInfos">
    <img class="imgInfos" src="./assets/image/<?php echo $serv['image'];?>">
    <div class="titleInfos"><?php echo $serv['title'];?></div>
    <div class="adressInfos"><?php echo $serv['adress'];?></div>
    <div class="phoneInfos"><?php echo $serv['phone'];?></div>
    <div class="daysInfos"><?php echo $serv['days_opened'];?></div>
        <div><?php echo $serv['open_at'];?>
        <?php echo $serv['close_at'];?></div>
        <div class="forSeeMap"><span class="seeOnMap" id="<?php echo $serv['id'];?>">Voir sur la carte ></span></div>

    </div>
    <?php endforeach ;?>
</section>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA35yi0pZC7eRhjk7P2fibGi-8YXSrzkts&callback=initMap">
</script>
<?php require './assets/footer.php'; ?>
