<div class="row">
    <img class="col-sm-2" src="<?= base_url('public/img/Plane.png') ?>">
    <div class="col-sm-9">
        <h2><a href="<?= site_url('voli/volo/' . $volo['id'] . "/" . $passeggeri) ?>"><?= $volo['codice'] . " - " . $volo['nome_compagnia'] ?></a></h2>
        <br><?= $volo['durata_volo'] ?> minuti
        <br><?= $volo['data_ora'] ?>
        <br>
        <?= ($volo['liberi_economy'] == 0 && $volo['liberi_business'] == 0) ? "POSTI ESAURITI" : "" ?>
    </div>
    <div class="col-sm-1">
        <a href="<?= site_url('voli/volo/' . $volo['id'] . "/" . $passeggeri) ?>">

            <?php if ($volo['liberi_economy'] > 0) : ?>
                <div class="btn btn-success">
                    <i class="fa fa-euro fa-5x"></i><br>
                    Da <b><?= $volo['prezzo_economy'] ?> €</b>
                </div>
            <?php elseif ($volo['liberi_business'] > 0) : ?>
                <div class="btn btn-warning">
                    <i class="fa fa-euro fa-5x"></i><br>
                    Da <b><?= $volo['prezzo_business'] ?> €</b>
                </div>
            <?php else: ?>
                <div class="btn btn-danger">
                    <i class="fa fa-euro fa-5x"></i><br>
                    POSTI ESAURITI</b>
                </div>
            <?php endif; ?>
        </a>
    </div>
</div>
<hr>