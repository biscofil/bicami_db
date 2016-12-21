<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistiche extends AdminController {

    public function index() {

        $this->jscsshandler->addJsFile(base_url('public/raphael-min.js'));
        $this->jscsshandler->addJsFile(base_url('public/morris/morris.js'));
        $this->jscsshandler->addCssFile(base_url('public/morris/morris.css'));

        $this->pageTitle("Statistiche");

        $stats = array();

        $stats['stat_passeggeriTrasportatiAeroporto'] = $this->mypghelper->stat_passeggeriTrasportatiAeroporto();
        $stats['stat_arrivi_partenze_aeroporti'] = $this->mypghelper->stat_arrivi_partenze_aeroporti();
        $stats['stat_tratte_prenotazioni'] = $this->mypghelper->stat_tratte_prenotazioni();
        $stats['stat_tratte_voli'] = $this->mypghelper->stat_tratte_voli();

        $this->jscsshandler->setJsProperty('stat_passeggeriTrasportatiAeroporto', $stats['stat_passeggeriTrasportatiAeroporto']);
        $this->jscsshandler->setJsProperty('stat_arrivi_partenze_aeroporti', $stats['stat_arrivi_partenze_aeroporti']);
        $this->jscsshandler->setJsProperty('stat_tratte_prenotazioni', $stats['stat_tratte_prenotazioni']);
        $this->jscsshandler->setJsProperty('stat_tratte_voli', $stats['stat_tratte_voli']);

        $this->data['stats'] = $stats;
        $this->loadView('statistiche/statistiche');
    }

}
