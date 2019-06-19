<?php $title = "Mon compte";?>
<?php require './assets/header.php'; ?>

<section class="imgUp">
    <div class="forTitleUp">
        <span class="pageHomeConnect forPageSpan">Mon compte</span>
    </div>
    <div class="responstitleUp pageHomeConnect" >
        Mon compte
    </div>
</section>
<div class="topConnect">
    <div>Gérez vote compte</div>
    <div>Payez et gérez directement vos factures ici.</div>
</div>

<h1 class="connectPage">Mon compte</h1>

<article class="forMessage"></article>


<!--<section id="loader">
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    <div>Chargement en cour</div>
</section>-->


<?php if (isset($_SESSION['user'])): ?>

    <section class="nextConnectPhp">

        <article style="font-size: 150%; text-transform: capitalize"><?php echo $_SESSION['user']['name'];?><?php echo " ". $_SESSION['user']['firstname'];?></article>

        <?php if ($_SESSION['user']['is_update'] == 0):?>
        <article class="firstMsg">Première connexion, confirmez ou faire une demande de correction.</article>
    <?php endif;?>
    <div class="userInfo">
            <div><?php echo $_SESSION['user']['name'];?></div>
            <div><?php echo $_SESSION['user']['firstname'];?></div>
            <div><?php echo $_SESSION['user']['numberStreet'] ." ".  $_SESSION['user']['street']
            ." ".  $_SESSION['user']['street']  ." ".  $_SESSION['user']['zipcode']  ." ".  $_SESSION['user']['city']?></div>
            <div><?php echo $_SESSION['user']['mail'];?></div>
            <div><?php echo $_SESSION['user']['phone'];?></div>
        </div>

        <?php if ($_SESSION['user']['is_update'] == 0):?>
            <div class="forMyButt">
                <a href="index.php?page=contact&modif"><button class="modif">Modifications</button></a>
                <button id="validInfo">Valider</button>
            </div>
        <?php endif;?>
        <section class="respBills">
            <?php if (!empty($bills)): ?>
                <?php foreach ($bills as $key => $bill):?>
                    <div class="respInside">
                        <div class="respTitle"><?php echo $bill['title'];?></div>
                        <div class="respIn"><article>Date</article><article><?php echo $bill['date'];?></article></div>
                        <div class="respIn"><article>Montant</article><article><?php echo $bill['amount'];?> €</article></div>
                        <div class="respIn"><article>Payée</article>
                            <article>
                                <?php if ($bill['status'] == 0) :?>
                                    ❌
                                <?php else :?>
                                    ✅
                                <?php endif;?>
                            </article>
                        </div>
                        <div class="respIn"><article>Consulter</article><i class="fas fa-file-pdf"></i></article></div>

                    </div>
                <?php endforeach;?>
            <?php endif; ?>

        </section>

            <div class="forBills">
        <?php if (!empty($bills)): ?>
            <div class="titleBills">
                <div style="text-align: center">Intitulé</div>
                <div style="text-align: center">Montant</div>
                <div style="text-align: center">Date</div>
                <div style="text-align: center">Status</div>
                <div>Télécharger</div>
                <div>Consulter</div>
            </div>
        <?php foreach ($bills as $key => $bill):?>
        <div class="lineBills">
            <div><?php echo $bill['title'];?></div>
            <div><?php echo $bill['amount'];?></div>
            <div><?php echo $bill['date'];?></div>
            <?php if ($bill['status'] == 0) :?>
                <div><button class="payBills">Payer facture</button></div>
            <?php else: ?>
                <div class="payed">Payée</button></div>
            <?php endif;?>
            <div><a  href="./assets/image/<?php echo $bill['file'];?>" download="<?php echo $bill['file'];?>"><i class="fas fa-download"></i></a></div>
            <div><a target="_blank" href="./assets/image/<?php echo $bill['file'];?>"><i class="fas fa-file-pdf"></i></a></div>
        </div>
            <?php endforeach;?>

        <?php else : ?>
            <div>Il n'y a aucune facture</div>

        <?php endif; ?>
            </div>
        <div class="forButtConnectPhp">
            <a class="forDisco" href="index.php?logout">
                <button id="disconnect">Déconnexion</button>
            </a>
        </div>
    </section>
<?php else : ?>
    <section class="connectForm">

        <p>Se connecter</p>
        <div>
            <label class="infoTool" aria-label="Votre adresse mail de référence">Votre identifiant <i class="fas fa-info-circle"></i></label><span></span>
            <article></article>
            <input id="idConnect" name="email" type="email" placeholder="Identifiant">
        </div>

        <div>

            <label class="infoTool" aria-label="Votre mot de passe vous a été envoyé par mail">Votre mot de passe  <i class="fas fa-info-circle"></i></label><span></span>
            <article></article>
            <input id="passwordConnect" name="passsword" type="password" placeholder="Mot de passe">
        </div>

        <div class="forButtConnect">
            <button  id="validConnect">Connexion</button>
        </div>
    </section>
<?php endif; ?>
<section class="nextConnect">
    <article class="nameSession" style="font-size: 150%">Votre Compte</article>
    <article class="firstMsg">Première connexion, confirmez ou faire une demande de correction.</article>
    <div class="containUser">
<div class="userInfo">
    <div class="inInfo" style="background-color: white"></div>

</div>
    <div class="forMyButt">
        <a href="index.php?page=contact&modif"><button class="modif">Modifications</button></a>
        <button id="validInfo">Valider</button>
    </div>
    </div>
    <div class="forBills">
        <div class="titleBills">
            <div style="text-align: center">Intitulé</div>
            <div style="text-align: center">Montant</div>
            <div style="text-align: center">Date</div>
            <div style="text-align: center">Status</div>
            <div>Télécharger</div>
            <div>Consulter</div>
        </div>
    </div>

    <div class="forMyButtFacture">
        <a class="forDiscoAjax" href="index.php?logout">
            <button id="disconnect">Déconnexion</button>
        </a>
    </div>
</section>

<!--<button class="testObject">TEST TEST</button>-->




<div class="loader"></div>

<span class="pulse"></span>




<script src="./js/connect.js"></script>


<?php require './assets/footer.php'; ?>

