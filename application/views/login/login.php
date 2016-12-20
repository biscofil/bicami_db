<!-- Callout -->
<aside class="callout" style="background: url(http://wwwstud.dsi.unive.it/fbisconc/progettodb/public/img/biglietti.jpg) no-repeat center center scroll;">
    <div class="text-vertical-center">
        <h1>Login</h1>
    </div>
</aside>

<!-- Portfolio -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <form class="form-horizontal" method="post" action="#">

                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Username" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input name="login" type="submit" class="btn btn-primary btn-lg btn-block login-button" value="Login"/>
                                </div>
                                <div class="col-sm-6">
                                    <a href="<?= site_url('login/registrazione') ?>"<button type="submit" class="col-sm-6 btn btn-danger btn-lg btn-block login-button">Non ho un account</button></a>
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