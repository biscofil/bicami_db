<aside class="call-to-action bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <!--<h1>Voli da <i><?= $from['nome'] ?></i> a <i><?= $to['nome'] ?></i></h1>-->
                <h1>
                    <img src="http://flagpedia.net/data/flags/small/<?= strtolower($from['code2']) ?>.png"/>
                    <?= $from['nome'] ?><small> ( <?= $from['nome_citta'] ?>)</small> - <?= $to['nome'] ?><small> ( <?= $to['nome_citta'] ?>)</small>
                    <img src="http://flagpedia.net/data/flags/small/<?= strtolower($to['code2']) ?>.png"/>
                </h1>
                <h3><?= $passeggeri . " passegger" . ($passeggeri > 1 ? "i" : "o") ?> - <?= $data->format('d/m/Y') ?> - <?= nomeClasse($classe) ?></h3>
            </div>
        </div>
    </div>
</aside>

<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <?php
                if (is_array($voli) && count($voli)):
                    foreach ($voli as $volo):
                        $this->load->view('voli/item_lista_volo', array('volo' => $volo, 'passeggeri' => $passeggeri));
                    endforeach;
                else:
                    ?>
                    <h1 class='text-danger'>Nessun volo trovato :(</h1>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="map">
    <div id="map" width="100%" height="100%"></div>
</section>

<style>
    #map {
        height: 100%;
    }
</style>

<script>
    var __from = "<?= $from['nome_citta'] . ", " . $from['nome_paese'] ?>";
    var __to = "<?= $to['nome_citta'] . ", " . $to['nome_paese'] ?>";
    var iconBase = "<?= base_url('public/img') ?>/";
</script>
