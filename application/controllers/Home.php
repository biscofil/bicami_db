<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MyController {

    public function index() {
        $this->jscsshandler->addJsFile(base_url('public/jquery-ui.js'));
        $this->jscsshandler->addCssFile(base_url('public/jquery-ui.css'));
        
        $this->data['popolari'] = $this->mypghelper->stat_tratte_popolari();
        
        $this->pageTitle('Homepage');
        $this->loadView('homepage/homepage');
    }

}
