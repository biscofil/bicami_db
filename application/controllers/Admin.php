<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends AdminCrudController {

    public function __construct() {
        parent::__construct();
        $this->pageTitle("Amministrazione");

        $this->jscsshandler->addJsFile(base_url('public/jquery-ui.js'));
        $this->jscsshandler->addCssFile(base_url('public/jquery-ui.css'));
        $this->jscsshandler->addCssFile(base_url('public/DataTables-1.10.12/media/css/dataTables.bootstrap.css'));
        $this->jscsshandler->addJsFile(base_url('public/DataTables-1.10.12/media/js/jquery.dataTables.js'));
    }

    public function index() {
        redirect('admin/voli');
    }

    public function utenti() {
        $this->pageSubTitle("Utenti");
        $this->loadView('admin/utenti');
    }

    public function compagnie() {
        $this->pageSubTitle("Compagnie");
        $this->loadView('admin/compagnie');
    }

    public function prenotazioni() {
        $this->pageSubTitle("Prenotazioni");
        $this->loadView('admin/prenotazioni');
    }

    public function tratte() {
        $this->pageSubTitle("Tratte");
        $this->loadView('admin/tratte');
    }

    public function voli() {
        $this->jscsshandler->addJsFile(base_url('public/jquery-ui-timepicker-addon.js'));
        $this->jscsshandler->addCssFile(base_url('public/jquery-ui-timepicker-addon.css'));
        $this->pageSubTitle("Voli");
        $this->loadView('admin/voli');
    }

    public function aeroporti() {
        $this->pageSubTitle("Aeroporti");
        $this->loadView('admin/aeroporti');
    }

    public function aeroplani() {
        $this->pageSubTitle("Aeroplani");
        $this->loadView('admin/aeroplani');
    }
}
