<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <table id="datatable" class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Data prenotazione</th>
                            <th>Posti</th>
                            <th>Utente</th>
                            <th>Tratta</th>
                            <th>Volo</th>
                            <th>Classe</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel"></h4>
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
                        <label for="id_utente" class="col-sm-2 control-label">UTENTE:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="id_utente" name="id_utente" style="width: 100%" required></select>
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
                <button type="button" class="btn btn-primary" id="btn_save">Salva</button>
                <button type="button" class="btn btn-primary hidden" id="btn_update">Aggiorna</button>
            </div>
        </div>
    </div>
</div>
