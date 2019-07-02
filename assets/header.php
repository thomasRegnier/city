<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/css.css">
    <link rel="stylesheet" href="./css/buger-menu.css">
    <link rel="stylesheet" href="./css/responsive.css">


    <title><?php echo $title;?></title>

</head>


<style>


</style>
<body>
<div class="progress-container">
    <div class="progress-bar" id="myBar"></div>
</div>

<header>
    <a href="index.php?page=index"><img src="./assets/image/logo.jpg"></a>
    <nav>
        <a href="index.php?page=index" id="home">Accueil</a>
        <a href="index.php?page=informations" id="infos">Informations</a>
        <a href="index.php?page=events" id="event">Événements</a>
        <a  href="index.php?page=contact" id="contact">Contact</a>
        <a href="index.php?page=connect" id="count">Compte</a>
        <?php if(isset($_SESSION['user'])) :?>
            <a href="index.php?logout" class="forDisco">Deconnexion</a>
        <?php endif;?>

            <?php if(isset($_SESSION['user'])) :?>
                <?php if($_SESSION['user']['is_admin'] == 1) :?>
                    <a class="admin" href="./admin/">Admin</a>
                <?php endif;?>
        <?php endif;?>



    </nav>
</header>

<section class="shadow masq">

</section>

<div class="lanceur">

<!--    <i id="open" class="fas fa-bars btnOpen"></i>-->
<!--    <i id="close" class="fas fa-times masq" style="color: white"></i>-->

    <div class="myIcon">
        <svg class="ham hamRotate ham4" viewBox="0 0 100 100" width="80" onclick="this.classList.toggle('active')">
            <path
                    class="line top"
                    d="m 70,33 h -40 c 0,0 -8.5,-0.149796 -8.5,8.5 0,8.649796 8.5,8.5 8.5,8.5 h 20 v -20" />
            <path
                    class="line middle"
                    d="m 70,50 h -40" />
            <path
                    class="line bottom"
                    d="m 30,67 h 40 c 0,0 8.5,0.149796 8.5,-8.5 0,-8.649796 -8.5,-8.5 -8.5,-8.5 h -20 v 20" />
        </svg>
    </div>
</div>

<div class="newMenu">
    <div class="homeR menuDiv"><a class="menuLinks" href="index.php?page=index"><i class="fas fa-home"></i> Accueil</a></div>
    <div class="infoR menuDiv"><a class="menuLinks" href="index.php?page=informations"><i class="fas fa-city"></i>  Informations</a></div>
    <div class="eventR menuDiv">  <a class="menuLinks" href="index.php?page=events"><i class="fas fa-calendar-alt"></i> Événements</a></div>
    <div class="contactR menuDiv"><a class="menuLinks" href="index.php?page=contact"> <i class="fas fa-comments"></i> Contact</a></div>
    <div class="countR menuDiv"> <a class="menuLinks" href="index.php?page=connect"><i class="fas fa-user"></i> Compte</a></div>
    <?php if(isset($_SESSION['user'])) :?>
        <div  style="background-color: red; color: white" class="menuDiv"> <a class="menuLinks" href="index.php?logout">Deconnexion</a></div>
    <?php endif;?>
</div>

<div class="newShadow">

</div>

<div class="menu">
    <div class="homeR menuDiv"><a class="menuLinks" href="index.php?page=index"><i class="fas fa-home"></i> Accueil</a></div>
    <div class="infoR menuDiv"><a class="menuLinks" href="index.php?page=informations"><i class="fas fa-city"></i>  Informations</a></div>
    <div class="eventR menuDiv">  <a class="menuLinks" href="index.php?page=events"><i class="fas fa-calendar-alt"></i> Événements</a></div>
    <div class="contactR menuDiv"><a class="menuLinks" href="index.php?page=contact"> <i class="fas fa-comments"></i> Contact</a></div>
    <div class="countR menuDiv"> <a class="menuLinks" href="index.php?page=connect"><i class="fas fa-user"></i> Compte</a></div>
    <?php if(isset($_SESSION['user'])) :?>
        <div  style="background-color: red; color: white" class="menuDiv"> <a class="menuLinks" href="index.php?logout">Deconnexion</a></div>
    <?php endif;?>
</div>

<!--<div class="weather">-->
<!--    <script charset='UTF-8' src='http://www.meteofrance.com/mf3-rpc-portlet/rest/vignettepartenaire/955630/type/VILLE_FRANCE/size/PAYSAGE_VIGNETTE' type='text/javascript'></script>-->
<!---->
<!--</div>-->

<div class="weather">

    <a class="weatherwidget-io" href="https://forecast7.com/fr/49d022d25/saint-leu-la-foret/" data-label_1="Saint-leu la forêt" data-icons="Climacons Animated" data-mode="Current" data-days="3" data-theme="weather_one" >Saint-leu la forêt</a>
    <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
    </script>
</div>

