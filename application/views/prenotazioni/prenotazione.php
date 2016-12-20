<!-- Callout -->
<aside class="callout" style="background: url(http://wwwstud.dsi.unive.it/fbisconc/progettodb/public/img/biglietto.jpg) no-repeat center center scroll;">
    <div class="text-vertical-center">
        <h1>
            <img src="http://flagpedia.net/data/flags/small/<?= strtolower($prenotazione['code2_da']) ?>.png"/> <?= $prenotazione['nome_aeroporto_partenza'] ?> - <?= $prenotazione['nome_aeroporto_arrivo'] ?> <img src="http://flagpedia.net/data/flags/small/<?= strtolower($prenotazione['code2_a']) ?>.png"/>
        </h1>
    </div>
</aside>

<!-- Portfolio -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">

                <div class="row">
                    <div class="col-sm-12 col-md-8">

                        <h2>Dettagli</h2>
                        <hr class="small">
                        <dl class="dl-horizontal">
                            <dt>Titolare</dt>
                            <dd><?= sessionInfo('nome') . " " . sessionInfo('cognome') ?></dd>
                            <dt>Prezzo</dt>
                            <dd><?= $prenotazione['prezzo_' . $prenotazione['classe']] * $prenotazione['num_posti_prenotati'] ?> €</dd>
                            <dt># Prenotazione</dt>
                            <dd><?= $prenotazione['id'] ?></dd>
                            <dt>Data di prenotazione</dt>
                            <dd><?= $prenotazione['data_prenotazione'] ?></dd>
                            <dt>Numero di passeggeri</dt>
                            <dd><?= $prenotazione['num_posti_prenotati'] ?></dd>
                            <dt>Classe</dt>
                            <dd><?= $prenotazione['classe'] ?></dd>
                            <dt>Aeroporto di partenza</dt>
                            <dd><?= $prenotazione['nome_aeroporto_partenza'] ?> (<?= $prenotazione['city_name_da'] . ', ' . $prenotazione['name_da'] ?>)</dd>
                            <dt>Aeroporti di arrivo</dt>
                            <dd><?= $prenotazione['nome_aeroporto_arrivo'] ?> (<?= $prenotazione['city_name_a'] . ', ' . $prenotazione['name_a'] ?>)</dd>
                        </dl>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?= $prenotazione['id'] ?>"><br>

                    </div>
                </div>
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
                <button class="btn btn-danger" id="delete_prenotazione">Elimina prenotazione</button>
                <button class="btn btn-warning" id="edit_prenotazione">Modifica prenotazione</button>
            </div>
        </div>
    </div>
</aside>


<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Modifica prenotazione</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <!-- MY_TODO : fare -->
                    <div class="form-group">
                        <label for="posti" class="col-sm-2 control-label">POSTI:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="posti" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_volo" class="col-sm-2 control-label">VOLO:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="id_volo" name="id_volo" style="width: 100%" required></select>
                        </div>
                    </div>     
                    <div class="form-group">
                        <label for="classe" class="col-sm-2 control-label">CLASSE:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="classe" name="classe" style="width: 100%" required>
                                <option value="business"><?= nomeClasse(MyController::CLASSE_BUSINESS) ?></option>
                                <option value="economy"><?= nomeClasse(MyController::CLASSE_ECONOMY) ?></option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary" id="btn_update">Aggiorna</button>
            </div>
        </div>
    </div>
</div>
