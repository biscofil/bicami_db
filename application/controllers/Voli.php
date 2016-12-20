<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voli extends MyController {

    public function index($p = 0) {
        $page = is_integer($p) ? intval($p) : 0;
        if (!(isset($_GET['from']) && isset($_GET['to']))) {
            redirect('home');
        }
        $da = $_GET['from'];
        $a = $_GET['to'];

        if ($da == $a) {
            redirect('home');
        }

        $passeggeri = (isset($_GET['passeggeri']) && intval($_GET['passeggeri']) > 0) ? intval($_GET['passeggeri']) : 1;
        $data = (isset($_GET['data'])) ? DateTime::createFromFormat('d/m/Y', $_GET['data']) : new DateTime();
        $classe = (isset($_GET['classe'])) ? $_GET['classe'] : MyController::CLASSE_ALL;

        $this->jscsshandler->addJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyD9doez-35-rof-nUnabn-4rWIOLu_T36E&callback=initMap', array('async' => null, 'defer' => null));

        $aeroporti = $this->mypghelper->getDettagliAeroporti($da, $a);

        $voli = $this->mypghelper->searchVoli($da, $a, $passeggeri, $data, $classe, $page);
        foreach ($voli as $key => $volo) {
            if (is_null($volo['prenotati_economy'])) {
                $voli[$key]['prenotati_economy'] = 0;
            }
            if (is_null($volo['prenotati_business'])) {
                $voli[$key]['prenotati_business'] = 0;
            }
            //
            if (is_null($volo['liberi_economy'])) {
                $voli[$key]['liberi_economy'] = $volo['posti_economy'];
            }
            if (is_null($volo['liberi_business'])) {
                $voli[$key]['liberi_business'] = $volo['posti_business'];
            }
        }
        $this->data['voli'] = $voli;

        $this->data['from'] = $aeroporti[0];
        $this->data['to'] = $aeroporti[1];
        $this->data['passeggeri'] = $passeggeri;
        $this->data['data'] = $data;
        $this->data['classe'] = $classe;

        $this->pageTitle("Voli da " . $this->data['from']['nome'] . " a " . $this->data['to']['nome']);
        $this->loadView('voli/voli');
    }

    public function volo($id = null, $psg = 1) {
        $passeggeri = (intval($psg) > 0) ? intval($psg) : 1;
        $this->data['id_volo'] = $id;
        $volo = $this->mypghelper->getVolo($id);
        if (is_null($volo['prenotati_economy'])) {
            $volo['prenotati_economy'] = 0;
        }
        if (is_null($volo['prenotati_business'])) {
            $volo['prenotati_business'] = 0;
        }
        //
        if (is_null($volo['liberi_economy'])) {
            $volo['liberi_economy'] = $volo['posti_economy'];
        }
        if (is_null($volo['liberi_business'])) {
            $volo['liberi_business'] = $volo['posti_business'];
        }
        $this->data['volo'] = $volo;
        $this->data['passeggeri'] = $passeggeri;
        $this->jscsshandler->setJsProperty('prenotazioni_controller', "prenotazioni");
        $this->jscsshandler->setJsProperty('prenotazioni_method', "prenotazione");
        $this->jscsshandler->setJsProperty('id_volo', $id);
        $this->jscsshandler->setJsProperty('id_utente', sessionInfo('id'));
        $this->jscsshandler->setJsProperty('passeggeri', $passeggeri);
        $this->pageTitle("Volo $id");
        $this->loadView('voli/volo');
    }

}
