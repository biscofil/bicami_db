<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tabellone extends MyController {

    public function index() {
        $this->jscsshandler->addJsFile(base_url('public/splitflap/js/jquery/jquery.splitflap.js'));
        $this->pageTitle('Tabellone');
        $this->loadView('tabellone/tabellone');
    }

}
