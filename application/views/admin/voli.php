<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <table id="datatable" class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Codice Tratta</th>
                            <th>Data e ora</th>
                            <th>Gate</th>
                            <th>Ritardo</th>
                            <th>Cancellato</th>
                            <th>Pr. Business</th>
                            <th>Pr. Economy</th>
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
                        <label for="gate" class="col-sm-2 control-label">GATE:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="1" class="form-control" id="gate"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tratta" class="col-sm-2 control-label">TRATTA:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="tratta" style="width: 100%" required></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data" class="col-sm-2 control-label"> DATA </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="data" id="data" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ritardo" class="col-sm-2 control-label"> RITARDO </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" min="0" step="1" id="ritardo" value="0" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cancellato" class="col-sm-2 control-label"> CANCELLATO </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="checkbox" id="cancellato"/>
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