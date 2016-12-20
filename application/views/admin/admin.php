<!-- Callout -->
<aside class="callout" style="background: url(http://wwwstud.dsi.unive.it/fbisconc/progettodb/public/img/biglietti.jpg) no-repeat center center scroll;">
    <div class="text-vertical-center">
        <h1><?= $_page_title ?><?php if (isset($_page_sub_title)): ?> <small>&gt;&gt; <?= $_page_sub_title ?></small></h1><?php endif; ?>
    </div>
</aside>

<!-- Portfolio -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <a href="<?= site_url('admin/tratte') ?>"><button class="btn btn-success">Tratte</button></a>
                <a href="<?= site_url('admin/voli') ?>"><button class="btn btn-success">Voli</button></a>
                <a href="<?= site_url('admin/aeroporti') ?>"><button class="btn btn-success">Aeroporti</button></a>
                <a href="<?= site_url('admin/aeroplani') ?>"><button class="btn btn-success">Tipo aerei</button></a>
                <a href="<?= site_url('admin/prenotazioni') ?>"><button class="btn btn-success">Prenotazioni</button></a>
                <a href="<?= site_url('admin/compagnie') ?>"><button class="btn btn-success">Compagnie</button></a>
                <a href="<?= site_url('admin/utenti') ?>"><button class="btn btn-warning">Utenti</button></a>
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>