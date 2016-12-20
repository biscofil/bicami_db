<!-- Callout -->
<aside class="callout" style="background: url(http://wwwstud.dsi.unive.it/fbisconc/progettodb/public/img/aereo.jpg) no-repeat center center scroll;">
    <div class="text-vertical-center">
        <h1><?= $volo['codice_volo'] ?> - <?= $volo['id'] ?>  </h1>
    </div>
</aside>

<!-- Portfolio -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h2>Dettagli volo</h2>
                <hr>
                <dl class="dl-horizontal">
                    <dt>Data</dt>
                    <dd><?= $volo['data_ora'] ?></dd>
                </dl>
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Call to Action -->
<aside class="call-to-action bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <?php if (isLogged()): //controllo se già prenotato? ?>
                    <h3>Prenota subito</h3>
                    Passeggeri : <?= $passeggeri ?><br>
                    <?php if ($volo['liberi_business'] > 0): ?>
                        <a href="javascript:void(0);" class="btn btn-lg btn-light btn-prenotazione" data-classe="business">Business<br><?= $volo['prezzo_business'] ?> €</a>
                    <?php endif; ?>
                    <?php if ($volo['liberi_economy'] > 0): ?>
                        <a href="javascript:void(0);" class="btn btn-lg btn-dark btn-prenotazione" data-classe="economy">Economy<br><?= $volo['prezzo_economy'] ?> €</a>
                        <?php endif; ?>
                    <?php else: ?>
                    <h3>Effettua il login per prenotare</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</aside>
