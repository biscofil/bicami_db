<!-- Callout -->
<aside class="callout" style="background: url(http://wwwstud.dsi.unive.it/fbisconc/progettodb/public/img/biglietti.jpg) no-repeat center center scroll;">
    <div class="text-vertical-center">
        <h1>Registrazione</h1>
    </div>
</aside>

<!-- Portfolio -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <form class="form-horizontal" method="post" action="">
                            <div class="form-group">
                                <label for="nome" class="col-sm-3 control-label">Nome</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Inserisci il tuo nome" value="<?= setValue($utente, 'nome') ?>" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cognome" class="col-sm-3 control-label">Cognome</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="cognome" id="cognome"  placeholder="Inserisci il tuo cognome" value="<?= setValue($utente, 'cognome') ?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="indirizzo" class="col-sm-3 control-label">Indirizzo</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="indirizzo" id="indirizzo"  placeholder="Inserisci il tuo indirizzo" value="<?= setValue($utente, 'indirizzo') ?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="col-sm-3 control-label">Telefono</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="telefono" id="telefono"  placeholder="Inserisci il tuo numero di telefono" value="<?= setValue($utente, 'telefono') ?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="carta_credito" class="col-sm-3 control-label">Carta di credito</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-credit-card fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="carta_credito" id="carta_credito"  placeholder="Inserisci il tuo numero della carta di credito" value="<?= setValue($utente, 'carta_credito') ?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label">Username</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="username" id="username"  placeholder="Inserisci il tuo username" value="<?= setValue($utente, 'username') ?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" name="password" id="password"  placeholder="Inserisci la tua password" value="" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm" class="col-sm-3 control-label">Ripeti password</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Ripeti la tua password" value="" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="submit" name="registrazione" class="col-sm-6 btn btn-primary btn-lg btn-block login-button" value="Registrati">
                                </div>
                                <div class="col-sm-6">
                                    <a href="<?= site_url('login') ?>"<button type="submit" class="col-sm-6 btn btn-success btn-lg btn-block login-button">Sono già registrato</button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>