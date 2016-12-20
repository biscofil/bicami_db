<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <table id="datatable" class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Indirizzo</th>
                            <th>Telefono</th>
                            <th>Carta di credito</th>
                            <th>Admin</th>
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
                        <label for="nome" class="col-sm-2 control-label">NOME:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nome"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cognome" class="col-sm-2 control-label">COGNOME:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="cognome"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">USERNAME:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">PASSWORD:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirm" class="col-sm-2 control-label">CONFERMA PASSWORD:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password_confirm" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="col-sm-2 control-label">TELEFONO:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="telefono" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="indirizzo" class="col-sm-2 control-label">INDIRIZZO:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="indirizzo" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="carta_credito" class="col-sm-2 control-label">CARTA DI CREDITO:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="carta_credito" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin" class="col-sm-2 control-label">ADMIN:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="checkbox" id="admin"/>
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