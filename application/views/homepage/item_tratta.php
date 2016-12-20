<div class="col-lg-12 text-center">
    <h1>
        <img src="http://flagpedia.net/data/flags/small/<?= strtolower($code2_da) ?>.png"/> 
        <?= $aero_da ?><small> (<?= $citta_da ?>)</small> - <?= $aero_a ?><small> (<?= $citta_a ?>)</small> 
        <img src="http://flagpedia.net/data/flags/small/<?= strtolower($code2_a) ?>.png"/>
        <br><a href="#top" class="tratta-preferita" data-name_from="<?= $aero_da ?>" data-name_to="<?= $aero_a ?>" data-from="<?= $aeroporto_partenza ?>" data-to="<?= $aeroporto_arrivo ?>">
            <button class="btn btn-dark btn-lg">Cerca</button>
        </a>
    </h1>
</div>
