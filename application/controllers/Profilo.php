<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profilo extends LoggedController {

    public function index() {
        $this->pageTitle('Profilo');
        $this->loadView('profilo');
    }

}
