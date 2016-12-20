<!-- Callout -->
<aside class="callout" style="background: url(http://wwwstud.dsi.unive.it/fbisconc/progettodb/public/img/biglietti.jpg) no-repeat center center scroll;">
    <div class="text-vertical-center">
        <h1>LE TUE PRENOTAZIONI</h1>
    </div>
</aside>

<!-- Portfolio -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <div class="row">
                    <?php
                    if (is_array($prenotazioni) && count($prenotazioni)):
                        foreach ($prenotazioni as $prenotazione):
                            $this->load->view('prenotazioni/item_lista_prenotazioni', $prenotazione);
                        endforeach;
                    else:
                        ?>
                        <h1 class='text-danger'>Nessuna prenotazione trovata</h1>            
                    <?php
                    endif;
                    ?>
                </div>
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>