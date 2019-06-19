<?php $title = "Nous contacter";?>

<?php require './assets/header.php'; ?>
<section class="imgUp">
    <div class="forTitleUp">
        <span class="pageHomeContact forPageSpan">Contact</span>
    </div>
    <div class="responstitleUp pageHomeContact" >
        Contact
    </div>
</section>

<h1 class="indexContact">Nous contacter</h1>
<?php if(isset($_GET['modif'])):?>
    <?= "ca marche";?>
<?php endif;?>
       <article class="forMessage"></article>
<section class="tabs-content">
    <div class="tabs">
        <?php if(isset($_GET['modif'])):?>

            <article id="forProb">Signaler un problème</article>
            <article class="inBack" id="forDmdInfo">Demande d'information</article>
        <?php else:?>
        <article class="inFront" id="forProb">Signaler un problème</article>
        <article id="forDmdInfo">Demande d'information</article>
        <?php endif;?>

    </div>
    <?php if(isset($_GET['modif'])):?>

    <section class="firstForm disNone">
        <?php else:?>
        <section class="firstForm">
        <?php endif;?>

        <div class="divSector">
            <label>Secteurs</label></br>
            <select id="sectors">
                <option value="0">Choisir secteurs</option>
                <?php foreach ($sectors as $key => $sector) : ?>
                    <option value="<?= $sector['id']; ?>"><?= $sector['name_sector']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="forChoices">
            <label>Choix</label></br>
            <select id="choices"></select>

        </div>
        <div class="finalSignal">
            <div>
            <label>Votre adresse mail</label><span></span>
            <article></article>
            <input id="mailMess" type="email" name="email" placeholder="Adresse mail" value="<?= isset($_SESSION['user']) ? $_SESSION['user']['mail'] : '' ?>">
                </div>
            <div>
            <label>Votre message</label><span></span>
            <article></article>
            <textarea name="message" id="messageSignal" placeholder="Votre message"></textarea>
            </div>
            <div class="forButt">
                <button id="forSignalValid">Valider</button>
            </div>
        </div>
    </section>


        <?php if(isset($_GET['modif'])):?>
        <section id="ancre" class="secondForm">

        <?php else:?>

        <section class="secondForm disNone">

            <?php endif;?>

            <div class="secondFormInside">
            <div class="topSecondForm">
             <div class="forName">
                 <label>Votre nom</label><span></span>
                 <article></article>
                 <input id="nameInfo" name="name" placeholder="Nom"
                        value="<?= isset($_SESSION['user']) ? $_SESSION['user']['name'] : '' ?>">
             </div>
            <div class="forSurname">
                <label>Votre prénom</label><span></span>
                <article></article>
                <input id="surnameInfo" name="firstname" placeholder="Prénom"
               value="<?= isset($_SESSION['user']) ? $_SESSION['user']['firstname'] : '' ?>">
            </div>
            </div>
<div>
        <label>Votre mail</label><span></span>
            <article></article>
        <input id="msgMail" name="email" type="email"  placeholder="email"value="<?= isset($_SESSION['user']) ? $_SESSION['user']['mail'] : '' ?>">
</div>
            <div>
            <label>Votre message</label><span></span>
            <article></article>
            <textarea name="message" id="messageInfo" placeholder="Message"><?= isset($_GET['modif']) ? "Merci de modifier ces informations : " : ''; ?></textarea>
            </div>

                <div class="forButt">
            <button id="validInfoMsg">Valider</button>
        </div>
        </div>
    </section>

</section>
<div class="loader"></div>




<?php require './assets/footer.php'; ?>
        <script src="./js/input_tools.js"></script>

<script src="./js/contact.js"></script>
