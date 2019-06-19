<?php $title = "Événéments"; ?>

<?php require './assets/header.php'; ?>
<link rel="stylesheet" href="./css/datepicker.css">
<main>

<section class="imgUp">
    <div class="forTitleUp">
        <span class="pageHomeEvent forPageSpan">Événements</span>
    </div>
    <div class="responstitleUp pageHomeEvent ">
        Événements
    </div>
</section>

<h1 class="eventPages">Nos événements</h1>












<span class="seeAllEvent" style="text-decoration: underline; cursor: pointer">Voir tous les événements</span>

<div class="eventByDate">

    <div class="dateSelected"></div>

    <section class="eventContainer">
        <div class="container">
            <div id="calendar2">
                <div id="calendar1-wrapper2"></div>
                <span class="calendar2-msg"></span>
            </div>
        </div>
        <div class="forInput2"><input class="input2" type="date"></div>


        <section class="parent">
            <section class="forEvents"></section>
</div>
        </section>
</section>



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

<span class="byDate" style="text-decoration: underline; cursor: pointer">Voir les événements par date</span>

<section class="allEvents">
    <div class="forEvents">
        <?php foreach ($events as $key => $event) : ?>
            <div class="insideEvents">
                <img src="./assets/image/<?php echo $event['image']; ?>">
                <h4><?php echo $event['title']; ?></h4>
                <div class="insideEventContent"><?php echo $event['description']; ?></div>
                <div class="forSeeEvents">
                    <span class="seeEvents" eventid="<?php echo $event['id']; ?>">Voir plus</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
</main>
<section class="forSearch">
    <input id="search" placeholder=" 🔍 Rechercher événement">
    <span class="qty"></span>
</section>

<script src="./js/datepicker.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA35yi0pZC7eRhjk7P2fibGi-8YXSrzkts&callback=initMap">
</script>


<?php require './assets/footer.php'; ?>
