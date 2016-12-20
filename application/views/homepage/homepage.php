<!-- Header -->
<header id="top" class="header">
    <div class="text-vertical-center">
        <h1><span class="label label-success">Progetto Basi di Dati 2016</span></h1>
        <br>
        <div class="col-sm-offset-0 col-sm-12 col-md-offset-4 col-md-4" id="homepage_form">
            <form method="GET" action="<?= site_url('voli/index') ?>">
                <div class="form-group">
                    <label for="aeroporto_da">Partenza </label>
                    <select class="form-control" id="aeroporto_da" name="from" required>
                    </select>
                </div>
                <div class="form-group">
                    <label for="aeroporto_a"> Destinazione </label>
                    <select class="form-control" id="aeroporto_a" name="to" required>
                    </select>
                </div>
                <div class="form-group">
                    <label for="passeggeri"> Num. passeggeri </label>
                    <input class="form-control" type="number" min="1" max="99" step="1" id="passeggeri" name="passeggeri" value="1" required/>
                </div>
                <div class="form-group">
                    <label for="data"> Data </label>
                    <input class="form-control" type="data" id="data" name="data" required value="<?= date('d/m/Y') ?>"/>
                </div>
                <div class="form-group">
                    <label for="data"> Classe </label>
                    <select class="form-control" name="classe" id="classe" required>
                        <option value="<?= MyController::CLASSE_ALL ?>" selected><?= nomeClasse(MyController::CLASSE_ALL) ?></option>
                        <option value="<?= MyController::CLASSE_BUSINESS ?>"><?= nomeClasse(MyController::CLASSE_BUSINESS) ?></option>
                        <option value="<?= MyController::CLASSE_ECONOMY ?>"><?= nomeClasse(MyController::CLASSE_ECONOMY) ?></option>
                    </select>
                </div>

                <br>
                <button type="submit" class="btn btn-dark btn-lg">Cerca voli</button>
            </form>
        </div>
    </div>
</header>

<section id="services" class="services bg-primary">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-10 col-lg-offset-1">
                <h2>Cerchi qualcosa?</h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-3 col-md-offset-3 col-sm-6 col-sm-offset-0">
                        <div class="service-item">
                            <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-flask fa-stack-1x text-primary"></i>
                            </span>
                            <h4>
                                <strong>Spazio aereo in realtime</strong>
                            </h4>
                            <p>Gaurdala posizione istantanea dei vari voli.</p>
                            <a href="<?= site_url('realtime') ?>" class="btn btn-light">Apri radar</a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="service-item">
                            <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-shield fa-stack-1x text-primary"></i>
                            </span>
                            <h4>
                                <strong>Tabellone</strong>
                            </h4>
                            <p>Accedi al tabellone direttamente da casa tua</p>
                            <a href="<?= site_url('tabellone') ?>" class="btn btn-light">Vai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Tratte più popolari</h2>
                <hr>
                <div class="row">
                    <?php
                    if (is_array($popolari) && count($popolari)) {
                        foreach ($popolari as $tratta_popolare) {
                            $this->load->view('homepage/item_tratta', $tratta_popolare);
                        }
                    } else {
                        echo "Nessuna tratta popolare...";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<aside class="call-to-action bg-primary">
    <div class="container">
        <div class="row">
            <?php if (!isLogged()): ?>
                <div class="col-lg-12 text-center">
                    <h3>Iscriviti al portale per usufruire di tutti i servizi</h3>
                    <a href="<?= site_url('login') ?>" class="btn btn-lg btn-light">Login</a>
                    <a href="<?= site_url('login/registrazione') ?>" class="btn btn-lg btn-dark">Registrazione</a>
                </div>
            <?php else: ?>
                <div class="col-lg-12 text-center">
                    <h3>Salve <?= ucfirst(sessionInfo('nome')) ?></h3>
                    <a href="<?= site_url('profilo') ?>" class="btn btn-lg btn-light">Profilo</a>
                    <a href="<?= site_url('prenotazioni') ?>" class="btn btn-lg btn-dark">Prenotazioni</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</aside>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 text-center">
                <h4><strong>Filippo Bisconcin</strong>
                </h4>
                <p>852144</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:852144@stud.unive.it">852144@stud.unive.it</a>
                    </li>
                </ul>
                <br>
                <ul class="list-inline">
                    <li>
                        <a href="https://it.linkedin.com/in/filippobisconcin"><i class="fa fa-linkedin fa-fw fa-3x"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 text-center">
                <h4><strong>Marco Cabianca</strong>
                </h4>
                <p>851839</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:851839@stud.unive.it">851839@stud.unive.it</a>
                    </li>
                </ul>
                <br>
                <ul class="list-inline">
                    <li>
                        <a href="https://it.linkedin.com/in/marco-cabianca-21a45812a"><i class="fa fa-linkedin fa-fw fa-3x"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 text-center">
                <h4><strong>Francesco Milanese</strong>
                </h4>
                <p>854609</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:854609@stud.unive.it">854609@stud.unive.it</a>
                    </li>
                </ul>
                <br>
                <ul class="list-inline">
                    <li>
                        <a href="#"><i class="fa fa-linkedin fa-fw fa-3x"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <hr class="small">
                <p class="text-muted">Copyright &copy; BiCaMi</p>
            </div>
        </div>
    </div>
    <a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
</footer>