<?php $title = "Accueil";?>
<?php require './assets/header.php'; ?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.3"></script>

<section class="imgUp">
    <div class="forTitleUp">
        <span class="pageHomeTitle forPageSpan">Accueil</span>
    </div>
    <div class="responstitleUp pageHomeTitle " >
        Accueil
    </div>
</section>

<h1 class="indexPages">Nos dernières actualités</h1>

<!-- Slideshow container -->
<div class="slideshow-container">
    <?php foreach ($events as $key => $event) :?>
    <div class="mySlides fade">
      <!--  <div class="numbertext"><?php// echo $event['title'] ;?></div>-->
        <img alt="" src="./assets/image/<?php echo $event['image'];?>"style="width:100%">
        <div class="text">
           <h3> <?php echo $event['title'] ;?></h3>
            <?php echo $event['description'] ;?>
            <div class="seeIndex"><span class="seeEventIndex" eventId="<?php echo $event['id'];?>">Voir article</span></div>
        </div>
    </div>
    <?php endforeach ;?>
    <!-- Next and previous buttons -->
    <a class="prev">&#10094;</a>
    <a class="next">&#10095;</a>
</div>

<div style="text-align:center; margin-bottom: 50px">
<?php for ($i = 0; $i<sizeof($events); $i++):?>
<?php echo '<span class="dot"></span>';?>
<?php endfor ;?>
</div>


<section class="onMap">
</section>

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
            <div class="adrressOnMap">12 rue fvzs ko,</div>
        </div>
        <div class="insideRight">
            <div id="map" style="width: 100%; height: 100%"></div>
        </div>
    </div>
    <div class="forMedias">

    </div>

</div>


<h1 class="indexPages" style="text-decoration: underline #3B5998;">Nous suivre aussi sur Facbook :</h1>

<div class="forFb" style="text-align:center; margin-bottom: 50px">
<div class="fb-page" data-href="https://www.facebook.com/villesaintleulaforet95320" data-tabs="timeline" data-width="500" data-height="750" data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/villesaintleulaforet95320" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/villesaintleulaforet95320">Ville de Saint-Leu-la Forêt</a></blockquote></div>
</div>

<!--<div class="parentTwitter">
<a class="twitter-timeline" data-width="500" data-tweet-limit="5"  href="https://twitter.com/Saint_Leu_Foret?ref_src=twsrc%5Etfw">Tweets by Saint_Leu_Foret</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>-->
<script src="./js/slider.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA35yi0pZC7eRhjk7P2fibGi-8YXSrzkts&callback=initMap">
</script>

<?php require './assets/footer.php'; ?>
