<?php if (ENVIRONMENT == 'development') : ?>
    <!-- DEBUG -->
    <h2 class="text-danger"><b>TOGLIERE DEBUG E ERRORS</b></h2>
    <button data-toggle="collapse" data-target="#demo">TOGGLE</button>
    <div id="demo" class="panel panel-primary collapse">
        <div class="panel-heading">
            DEBUG 
        </div>
        <div class="panel-body">
            <pre><?= print_r($_POST); ?></pre>
            <pre><?= print_r($_GET); ?></pre>
            <pre><?= print_r($this->data); ?></pre>
            <pre><?= var_dump($this->data); ?></pre>
        </div>
        <div class="panel-footer">
            <pre><?= print_r($_SESSION); ?></pre>
        </div>
    </div>
<?php endif; ?>
<?php $this->jscsshandler->out_js_files(); ?>
</body>
</html>
