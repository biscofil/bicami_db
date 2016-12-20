<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <table id="datatable" class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sigla</th>
                            <th>Nome</th>
                            <th>Città</th>
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
                        <label for="sigla" class="col-sm-2 control-label">SIGLA:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sigla" maxlength="3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nome" class="col-sm-2 control-label">NOME:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nome" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_citta" class="col-sm-2 control-label">CITTA:</label>
                        <div class="col-sm-10">
                            <select class="form-control select2-input" id="citta" name="id_citta" style="width: 100%" required></select>
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