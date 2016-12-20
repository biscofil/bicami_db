<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <table id="datatable" class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Codice</th>
                            <th>Compagnia</th>
                            <th>Da</th>
                            <th>A</th>
                            <th>Durata (min)</th>
                            <th>Aeroplano</th>
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
                    <div class="form-group">
                        <label for="codice" class="col-sm-2 control-label">CODICE:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="codice"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="compagnia" class="col-sm-2 control-label">COMPAGNIA:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="compagnia" style="width: 100%" required></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="a_partenza" class="col-sm-2 control-label">AEROPORTO PARTENZA:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="a_partenza" style="width: 100%" required></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="a_arrivo" class="col-sm-2 control-label">AEROPORTO ARRIVO:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="a_arrivo" style="width: 100%" required></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="durata" class="col-sm-2 control-label">DURATA: </label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input class="form-control" type="number" min="1" max="99" step="1" id="durata" value="1" required/>
                                <span class="input-group-addon">minuti</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="p_economy" class="col-sm-2 control-label">PREZZO ECONOMY: </label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">€</span>
                                <input class="form-control" type="number" min="0" step="0.01" id="p_economy" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="p_business" class="col-sm-2 control-label">PREZZO BUSINESS: </label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">€</span>
                                <input class="form-control" type="number" min="0" step="0.01" id="p_business" required/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="aeroplano" class="col-sm-2 control-label">TIPO AEROPLANO:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="aeroplano" style="width: 100%" required></select>
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