<aside class="callout" style="background: url(http://wwwstud.dsi.unive.it/fbisconc/progettodb/public/img/biglietti.jpg) no-repeat center center scroll;">
    <div class="text-vertical-center">
        <h1>Profilo</h1>
    </div>
</aside>

<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="nome" class="col-sm-3 control-label">Nome</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nome" placeholder="Nome" required value="<?= sessionInfo('nome') ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cognome" class="col-sm-3 control-label">Cognome</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="cognome" placeholder="Cognome" required value="<?= sessionInfo('cognome') ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label">USERNAME:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" placeholder="Username" required value="<?= sessionInfo('username') ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="telefono" class="col-sm-3 control-label">Telefono</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" id="telefono" placeholder="Telefono" required value="<?= sessionInfo('telefono') ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="indirizzo" class="col-sm-3 control-label">Indirizzo</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="indirizzo" placeholder="Indirizzo" required value="<?= sessionInfo('indirizzo') ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="carta_credito" class="col-sm-3 control-label">Carta di credito</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="carta_credito" placeholder="Numero carta di credito" required value="<?= sessionInfo('carta_credito') ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" placeholder="Lasciare vuoto per lasciare la password invariata">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirm" class="col-sm-3 control-label">Conferma:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password_confirm" placeholder="Lasciare vuoto per lasciare la password invariata">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="button" class="form-control btn-success" id="btn-save">Salva</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="form-control btn-danger" id="btn-cancel">Annulla</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>