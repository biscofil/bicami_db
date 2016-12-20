<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prenotazioni extends LoggedController {

    public function index() {
        $this->data['prenotazioni'] = $this->mypghelper->getPrenotazioniUtente(sessionInfo('id'));
        $this->pageTitle('Prenotazioni');
        $this->loadView('prenotazioni/prenotazioni');
    }

    public function prenotazione($id = null) {
        $id = intval($id);
        $prenotazione = $this->mypghelper->getPrenotazione($id);
        if (!$prenotazione) {
            redirect("prenotazioni");
        }

        if ($prenotazione['id_utente'] != sessionInfo('id')) {
            redirect('prenotazioni');
        }

        $this->data['prenotazione'] = $prenotazione;

        $this->jscsshandler->setJsProperty('id_prenotazione', $id);
        $this->jscsshandler->setJsProperty('prenotazioni_controller', "prenotazioni");


        $this->pageTitle('Prenotazione');
        $this->loadView('prenotazioni/prenotazione');
    }

}
