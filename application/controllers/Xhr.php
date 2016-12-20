<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Xhr extends XhrController {

    public function xhr_paese() {
        self::post_fields_required(array('id'));
        $id = filter_input(INPUT_POST, 'id');
        $res = $this->mypghelper->getPaese($id);
        self::def_end($res, 'paese', $res);
    }

    public function xhr_search_paese() {
        $search = filter_input(INPUT_GET, 'q');
        $data = $this->mypghelper->searchPaese($search);
        echo json_encode($data);
    }

    public function xhr_search_citta() {
        $search = filter_input(INPUT_GET, 'q');
        $data = $this->mypghelper->searchCitta($search);
        echo json_encode($data);
    }

    /// other

    public function xhr_realtime() {
        $data = $this->mypghelper->getRealTime();
        echo json_encode($data);
    }

    public function xhr_tabellone() {
        $data = $this->mypghelper->getTabellone();
        echo json_encode($data);
    }

    // prenotazioni

    public function xhr_mia_prenotazione() {
        self::xhr_require_login();
        self::post_fields_required(array('id'));
        $id = filter_input(INPUT_POST, 'id');
        $res = $this->mypghelper->getPrenotazione($id);
        if ($res['id_utente'] != sessionInfo('id')) {
            self::_error('Furbetto! Non puoi vedere una prenotazione non tua!');
        }
        self::def_end($res, 'prenotazione', $res);
    }

    public function xhr_prenotazione() {
        self::xhr_require_admin();
        self::post_fields_required(array('id'));
        $id = filter_input(INPUT_POST, 'id');
        $res = $this->mypghelper->getPrenotazione($id);
        self::def_end($res, 'prenotazione', $res);
    }

    public function xhr_prenota() {
        self::xhr_require_login();
        self::post_fields_required(array('id_volo', 'id_utente', 'classe', 'passeggeri'));
        if ((!isAdmin()) && ( filter_input(INPUT_POST, 'id_utente') != sessionInfo('id'))) {
            self::_error('Furbetto! Non puoi prenotare a nome di qualcun altro!');
        }
        $id_volo = filter_input(INPUT_POST, 'id_volo');
        $id_utente = filter_input(INPUT_POST, 'id_utente');
        $classe = filter_input(INPUT_POST, 'classe');
        $passeggeri = filter_input(INPUT_POST, 'passeggeri');
        $res = $this->mypghelper->effettuaPrenotazione($id_volo, $id_utente, $classe, $passeggeri);
        self::def_end($res, 'id_prenotazione', $res, 'impossibile eliminare');
    }

    public function xhr_elimina_prenotazione() {
        self::xhr_require_login();
        self::post_fields_required(array('id_prenotazione'));
        $id_prenotazione = filter_input(INPUT_POST, 'id_prenotazione');
        if (!isAdmin()) {
            $prenotazione = $this->mypghelper->getPrenotazione($id_prenotazione);
            if ($prenotazione['id_utente'] != sessionInfo('id')) {
                self::_error('Furbetto! Non è tua questa prenotazione!');
            }
        }
        $res = $this->mypghelper->eliminaPrenotazioni(array($id_prenotazione));
        self::def_end($res, null, null, 'impossibile eliminare');
    }

    public function xhr_elimina_prenotazioni() {
        self::xhr_require_admin();
        self::post_fields_required('ids');
        $ids = filter_input(INPUT_POST, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $res = $this->mypghelper->eliminaPrenotazioni($ids);
        self::def_end($res);
    }

    public function xhr_modifica_prenotazione() {
        self::xhr_require_admin();
        self::post_fields_required(array('id', 'id_volo', 'id_utente', 'classe', 'passeggeri'));
        $prenotazione = array(
            'id' => filter_input(INPUT_POST, 'id'),
            'id_volo' => filter_input(INPUT_POST, 'id_volo'),
            'id_utente' => filter_input(INPUT_POST, 'id_utente'),
            'classe' => filter_input(INPUT_POST, 'classe'),
            'passeggeri' => filter_input(INPUT_POST, 'passeggeri')
        );
        $res = $this->mypghelper->modificaPrenotazione($prenotazione);
        self::def_end($res, null, null, 'impossibile modificare');
    }

    public function xhr_modifica_mia_prenotazione() {
        self::xhr_require_login();
        self::post_fields_required(array('id', 'id_volo', 'classe', 'passeggeri'));
        $res = $this->mypghelper->getPrenotazione(filter_input(INPUT_POST, 'id'));
        if ($res['id_utente'] != sessionInfo('id')) {
            self::_error('Furbetto! Non è tua questa prenotazione!');
        }
        $prenotazione = array(
            'id' => filter_input(INPUT_POST, 'id'),
            'id_volo' => filter_input(INPUT_POST, 'id_volo'),
            'id_utente' => sessionInfo('id'),
            'classe' => filter_input(INPUT_POST, 'classe'),
            'passeggeri' => filter_input(INPUT_POST, 'passeggeri')
        );
        $res = $this->mypghelper->modificaPrenotazione($prenotazione);
        self::def_end($res, null, null, 'impossibile modificare');
    }

    /// tratte

    public function xhr_search_tratta() {
        $search = filter_input(INPUT_GET, 'q');
        $data = $this->mypghelper->searchTratta($search);
        echo json_encode($data);
    }

    public function xhr_tratta() {
        self::post_fields_required('codice');
        $codice = filter_input(INPUT_POST, 'codice');
        $res = $this->mypghelper->getTratta($codice);
        self::def_end($res, 'tratta', $res);
    }

    public function xhr_tratte() {
        $this->load->library('pgdatatables');
        $this->pgdatatables->run(array('codice', 'nome_compagnia', 'aeroporto_partenza', 'aeroporto_arrivo', 'durata_volo', 'nome_aeroplano',), 'voli_compagnie_aeroplani', 'codice');
    }

    public function xhr_nuova_tratta() {
        self::xhr_require_admin();
        self::post_fields_required(array('codice', 'compagnia', 'a_partenza', 'a_arrivo', 'durata', 'p_economy', 'p_business', 'aeroplano'));
        $codice = filter_input(INPUT_POST, 'codice');
        $compagnia = filter_input(INPUT_POST, 'compagnia');
        $a_partenza = filter_input(INPUT_POST, 'a_partenza');
        $a_arrivo = filter_input(INPUT_POST, 'a_arrivo');
        $durata = filter_input(INPUT_POST, 'durata');
        $p_economy = filter_input(INPUT_POST, 'p_economy');
        $p_business = filter_input(INPUT_POST, 'p_business');
        $aeroplano = filter_input(INPUT_POST, 'aeroplano');
        $res = $this->mypghelper->nuovaTratta($codice, $compagnia, $a_partenza, $a_arrivo, $durata, $p_economy, $p_business, $aeroplano);
        self::def_end($res);
    }

    public function xhr_elimina_tratte() {
        self::xhr_require_admin();
        self::post_fields_required('ids');
        $ids = filter_input(INPUT_POST, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $res = $this->mypghelper->eliminaTratte($ids);
        self::def_end($res);
    }

    public function xhr_modifica_tratta() {
        self::xhr_require_admin();
        self::post_fields_required(array('old_codice', 'codice', 'compagnia', 'a_partenza', 'a_arrivo', 'durata', 'p_economy', 'p_business', 'aeroplano'));
        $old_codice = filter_input(INPUT_POST, 'old_codice');
        $codice = filter_input(INPUT_POST, 'codice');
        $compagnia = filter_input(INPUT_POST, 'compagnia');
        $a_partenza = filter_input(INPUT_POST, 'a_partenza');
        $a_arrivo = filter_input(INPUT_POST, 'a_arrivo');
        $durata = filter_input(INPUT_POST, 'durata');
        $p_economy = filter_input(INPUT_POST, 'p_economy');
        $p_business = filter_input(INPUT_POST, 'p_business');
        $aeroplano = filter_input(INPUT_POST, 'aeroplano');
        $res = $this->mypghelper->modificaTratta($old_codice, $codice, $compagnia, $a_partenza, $a_arrivo, $durata, $p_economy, $p_business, $aeroplano);
        self::def_end($res);
    }

    /// voli

    public function xhr_search_volo() {
        $search = filter_input(INPUT_GET, 'q');
        $data = $this->mypghelper->searchVolo($search);
        echo json_encode($data);
    }

    public function xhr_volo() {
        self::post_fields_required('codice');
        $codice = filter_input(INPUT_POST, 'codice');
        $res = $this->mypghelper->getVolo($codice);
        self::def_end($res, 'volo', $res);
    }

    public function xhr_voli() {
        self::xhr_require_admin();
        $this->load->library('pgdatatables');
        $this->pgdatatables->run(array('id', 'codice_volo', 'data_ora', 'gate', 'ritardo', 'cancellato', 'prenotati_business', 'prenotati_economy'), 'datatable_voli', 'id');
    }

    public function xhr_nuovo_volo() {
        self::xhr_require_admin();
        self::post_fields_required(array('gate', 'data', 'ritardo', 'cancellato', 'tratta'));
        $gate = filter_input(INPUT_POST, 'gate');
        $data = getPostDateTime(filter_input(INPUT_POST, 'data'));
        $ritardo = filter_input(INPUT_POST, 'ritardo');
        $cancellato = filter_input(INPUT_POST, 'cancellato');
        $tratta = filter_input(INPUT_POST, 'tratta');
        $res = $this->mypghelper->nuovoVolo($gate, $tratta, $data, $ritardo, $cancellato);
        self::def_end($res);
    }

    public function xhr_elimina_voli() {
        self::xhr_require_admin();
        self::post_fields_required('ids');
        $ids = filter_input(INPUT_POST, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $res = $this->mypghelper->eliminaVoli($ids);
        self::def_end($res);
    }

    public function xhr_modifica_volo() {
        self::xhr_require_admin();
        self::post_fields_required(array('old_codice', 'tratta', 'data', 'gate', 'ritardo', 'cancellato'));
        $old_codice = filter_input(INPUT_POST, 'old_codice');
        $gate = filter_input(INPUT_POST, 'gate');
        $tratta = filter_input(INPUT_POST, 'tratta');
        $data = getPostDateTime(filter_input(INPUT_POST, 'data'));
        $ritardo = filter_input(INPUT_POST, 'ritardo');
        $cancellato = filter_input(INPUT_POST, 'cancellato');
        $res = $this->mypghelper->modificaVolo($old_codice, $gate, $tratta, $data, $ritardo, $cancellato);
        self::def_end($res);
    }

    /// aeroporti

    public function xhr_search_aeroporto() {
        $search = filter_input(INPUT_GET, 'q');
        $data = $this->mypghelper->searchAeroporto($search);
        echo json_encode($data);
    }

    public function xhr_aeroporto() {
        self::xhr_require_admin();
        self::post_fields_required('sigla');
        $sigla = filter_input(INPUT_POST, 'sigla');
        $res = $this->mypghelper->getAeroporto($sigla);
        self::def_end($res, 'aeroporto', $res);
    }

    public function xhr_aeroporti() {
        self::xhr_require_admin();
        $this->load->library('pgdatatables');
        $this->pgdatatables->run(array('sigla', 'nome', 'nome_citta'), 'aeroporti_citta', 'sigla');
    }

    public function xhr_nuovo_aeroporto() {
        self::xhr_require_admin();
        self::post_fields_required(array('sigla', 'nome', 'id_citta'));
        $sigla = filter_input(INPUT_POST, 'sigla');
        $nome = filter_input(INPUT_POST, 'nome');
        $id_citta = filter_input(INPUT_POST, 'id_citta');
        $res = $this->mypghelper->nuovoAeroporto($sigla, $nome, $id_citta);
        self::def_end($res, 'sigla', $sigla);
    }

    public function xhr_elimina_aeroporti() {
        self::xhr_require_admin();
        self::post_fields_required('ids');
        $ids = filter_input(INPUT_POST, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $res = $this->mypghelper->eliminaAeroporti($ids);
        self::def_end($res);
    }

    public function xhr_modifica_aeroporto() {
        self::xhr_require_admin();
        self::post_fields_required(array('old_sigla', 'sigla', 'nome', 'id_citta'));
        $old_sigla = filter_input(INPUT_POST, 'old_sigla');
        $sigla = filter_input(INPUT_POST, 'sigla');
        $nome = filter_input(INPUT_POST, 'nome');
        $id_citta = filter_input(INPUT_POST, 'id_citta');
        $res = $this->mypghelper->modificaAeroporto($old_sigla, $sigla, $nome, $id_citta);
        self::def_end($res, 'sigla', $sigla);
    }

    /// aeroplani

    public function xhr_search_aeroplano() {
        $search = filter_input(INPUT_GET, 'q');
        $data = $this->mypghelper->searchAeroplano($search);
        echo json_encode($data);
    }

    public function xhr_aeroplano() {
        self::post_fields_required('id');
        $id = filter_input(INPUT_POST, 'id');
        $res = $this->mypghelper->getAeroplano($id);
        self::def_end($res, 'aeroplano', $res);
    }

    public function xhr_aeroplani() {
        self::xhr_require_admin();
        $this->load->library('pgdatatables');
        $this->pgdatatables->run(array('id', 'nome', 'posti_economy', 'posti_business'), 'tipi_aeroplani', 'id');
    }

    public function xhr_nuovo_aeroplano() {
        self::xhr_require_admin();
        self::post_fields_required(array('nome', 'posti_economy', 'posti_business'));
        $nome = filter_input(INPUT_POST, 'nome');
        $posti_economy = filter_input(INPUT_POST, 'posti_economy');
        $posti_business = filter_input(INPUT_POST, 'posti_business');
        $res = $this->mypghelper->nuovoAeroplano($nome, $posti_economy, $posti_business);
        self::def_end($res);
    }

    public function xhr_elimina_aeroplani() {
        self::xhr_require_admin();
        self::post_fields_required('ids');
        $ids = filter_input(INPUT_POST, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $res = $this->mypghelper->eliminaAeroplani($ids);
        self::def_end($res);
    }

    public function xhr_modifica_aeroplano() {
        self::xhr_require_admin();
        self::post_fields_required(array('id', 'nome', 'posti_economy', 'posti_business'));
        $id = filter_input(INPUT_POST, 'id');
        $nome = filter_input(INPUT_POST, 'nome');
        $posti_economy = filter_input(INPUT_POST, 'posti_economy');
        $posti_business = filter_input(INPUT_POST, 'posti_business');
        $res = $this->mypghelper->modificaAeroplano($id, $nome, $posti_economy, $posti_business);
        self::def_end($res);
    }

    ///

    public function xhr_prenotazioni() {
        self::xhr_require_admin();
        $this->load->library('pgdatatables');
        $this->pgdatatables->run(array('id', 'data_prenotazione', 'num_posti_prenotati', 'nome', 'codice_volo', 'id_volo_pianificato', 'classe'), 'datatable_prenotazioni', 'id');
    }

    ///

    public function xhr_search_compagnia() {
        $search = filter_input(INPUT_GET, 'q');
        $data = $this->mypghelper->searchCompagnia($search);
        echo json_encode($data);
    }

    public function xhr_compagnia() {
        self::xhr_require_admin();
        self::post_fields_required('id');
        $id = filter_input(INPUT_POST, 'id');
        $res = $this->mypghelper->getCompagnia($id);
        self::def_end($res, 'compagnia', $res);
    }

    public function xhr_compagnie() {
        self::xhr_require_admin();
        $this->load->library('pgdatatables');
        $this->pgdatatables->run(array('id', 'nome', 'nazionalita'), 'compagnie', 'id');
    }

    public function xhr_nuova_compagnia() {
        self::xhr_require_admin();
        self::post_fields_required(array('nome', 'id_paese'));
        $nome = filter_input(INPUT_POST, 'nome');
        $id_paese = filter_input(INPUT_POST, 'id_paese');
        $res = $this->mypghelper->nuovaCompagnia($nome, $id_paese);
        self::def_end($res);
    }

    public function xhr_elimina_compagnie() {
        self::xhr_require_admin();
        self::post_fields_required('ids');
        $ids = filter_input(INPUT_POST, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $res = $this->mypghelper->eliminaCompagnie($ids);
        self::def_end($res);
    }

    public function xhr_modifica_compagnia() {
        self::xhr_require_admin();
        self::post_fields_required(array('id', 'nome', 'id_paese'));
        $id = filter_input(INPUT_POST, 'id');
        $nome = filter_input(INPUT_POST, 'nome');
        $id_paese = filter_input(INPUT_POST, 'id_paese');
        $res = $this->mypghelper->modificaCompagnia($id, $nome, $id_paese);
        self::def_end($res);
    }

    ///

    public function xhr_search_utente() {
        $search = filter_input(INPUT_GET, 'q');
        $data = $this->mypghelper->searchUtente($search);
        echo json_encode($data);
    }

    public function xhr_utente() {
        self::xhr_require_admin();
        self::post_fields_required('id');
        $id = filter_input(INPUT_POST, 'id');
        $res = $this->mypghelper->getUtente($id);
        self::def_end($res, 'utente', $res);
    }

    public function xhr_utenti() {
        self::xhr_require_admin();
        $this->load->library('pgdatatables');
        $this->pgdatatables->run(array('id', 'username', 'nome', 'cognome', 'indirizzo', 'telefono', 'carta_credito', 'user_level'), 'utenti', 'id');
    }

    public function xhr_nuovo_utente() {
        self::xhr_require_admin();
        self::post_fields_required(array('nome', 'cognome', 'indirizzo', 'telefono', 'carta_credito', 'username', 'password'));
        $utente = array(
            'nome' => filter_input(INPUT_POST, 'nome'),
            'cognome' => filter_input(INPUT_POST, 'cognome'),
            'indirizzo' => filter_input(INPUT_POST, 'indirizzo'),
            'telefono' => filter_input(INPUT_POST, 'telefono'),
            'carta_credito' => filter_input(INPUT_POST, 'carta_credito'),
            'username' => filter_input(INPUT_POST, 'username'),
            'password' => filter_input(INPUT_POST, 'password'),
            'user_level' => ( isset($_POST['user_level']) && filter_input(INPUT_POST, 'user_level') == MyController::USER_ADMIN ) ? MyController::USER_ADMIN : MyController::USER_BASIC
        );
        $res = $this->mypghelper->registraUtente($utente);
        self::def_end($res);
    }

    public function xhr_elimina_utenti() {
        self::xhr_require_admin();
        self::post_fields_required('ids');
        $ids = filter_input(INPUT_POST, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $res = $this->mypghelper->eliminaUtenti($ids);
        self::def_end($res);
    }

    public function xhr_modifica_utente() {
        self::xhr_require_admin();
        self::post_fields_required(array('id', 'nome', 'cognome', 'indirizzo', 'telefono', 'carta_credito', 'username', 'password'));
        $utente = array(
            'id' => filter_input(INPUT_POST, 'id'),
            'nome' => filter_input(INPUT_POST, 'nome'),
            'cognome' => filter_input(INPUT_POST, 'cognome'),
            'indirizzo' => filter_input(INPUT_POST, 'indirizzo'),
            'telefono' => filter_input(INPUT_POST, 'telefono'),
            'carta_credito' => filter_input(INPUT_POST, 'carta_credito'),
            'username' => filter_input(INPUT_POST, 'username'),
            'password' => filter_input(INPUT_POST, 'password') != "" ? filter_input(INPUT_POST, 'password') : null,
            'user_level' => (isset($_POST['user_level']) && filter_input(INPUT_POST, 'user_level') == MyController::USER_ADMIN ) ? MyController::USER_ADMIN : MyController::USER_BASIC
        );
        $res = $this->mypghelper->modificaUtente($utente);
        self::def_end($res);
    }

    public function xhr_modifica_profilo() {
        self::xhr_require_login();
        self::post_fields_required(array('nome', 'cognome', 'indirizzo', 'telefono', 'carta_credito', 'username', 'password'));
        $utente = array(
            'id' => sessionInfo('id'),
            'nome' => filter_input(INPUT_POST, 'nome'),
            'cognome' => filter_input(INPUT_POST, 'cognome'),
            'indirizzo' => filter_input(INPUT_POST, 'indirizzo'),
            'telefono' => filter_input(INPUT_POST, 'telefono'),
            'carta_credito' => filter_input(INPUT_POST, 'carta_credito'),
            'username' => filter_input(INPUT_POST, 'username'),
            'password' => filter_input(INPUT_POST, 'password') != "" ? filter_input(INPUT_POST, 'password') : null,
            'user_level' => sessionInfo('user_level')
        );
        $res = $this->mypghelper->modificaUtente($utente);
        doLogin($utente);
        self::def_end($res);
    }

    ///

    public function xhr_demo() {
        try {
            $this->load->helper('array');
            for ($a = 0; $a < rand(2, 4); $a++) {
                $tratte = $this->mypghelper->getTratte();
                $gate = rand(1, 10);
                $data = new DateTime();
                $hours = rand(5, 72);
                $data->add(new DateInterval('PT' . $hours . 'H'));
                $ritardo = rand(0, 60);
                $cancellato = rand(0, 10) > 8 ? 1 : 0;
                $tratta = random_element($tratte)['codice'];
                $this->mypghelper->nuovoVolo($gate, $tratta, $data, $ritardo, $cancellato);
            }
            self::_success();
        } catch (Exception $ex) {
            self::_error($ex->getMessage());
        }
    }

}
