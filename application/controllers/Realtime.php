<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Realtime extends MyController {

    public function index() {
        $this->jscsshandler->addJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyD9doez-35-rof-nUnabn-4rWIOLu_T36E&callback=initMap', array('async' => null, 'defer' => null));
        $this->pageTitle('Realtime');
        $this->loadView('realtime');
    }

}
