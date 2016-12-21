<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mypghelper {

    private $connection = null;

    function __construct() {
        $CI = &get_instance();
        $s = $CI->config->item('unive_db');
        try {
            $str = sprintf("pgsql:host=%s;port=%s;dbname=%s", $s['server'], $s['port'], $s['database']);
            $this->connection = new PDO($str, $s['username'], $s['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function fetch($data, $mode = PDO::FETCH_ASSOC) {
        $out = array();
        while ($r = $data->fetch($mode)) {
            $out[] = $r;
        }
        return $out;
    }

    function custom_query($q) {
        $stmt = $this->connection->prepare($q);
        $stmt->execute();
        return $this->fetch($stmt);
    }

    ///citta

    public function getPaese($id) {
        $stmt = $this->connection->prepare("SELECT * FROM country WHERE code = ? LIMIT 1");
        $stmt->execute(array($id));
        $data = $this->fetch($stmt);
        return count($data) > 0 ? $data[0] : false;
    }

    public function searchPaese($s) {
        $search = strtolower($s);
        $stmt = $this->connection->prepare(
                "SELECT * FROM country WHERE LOWER(name) LIKE ? LIMIT 10");
        $stmt->execute(array("%$search%"));
        return $this->fetch($stmt);
    }

    public function searchCitta($s) {
        $search = strtolower($s);
        $stmt = $this->connection->prepare(
                "SELECT * FROM cities_countries WHERE LOWER(nome_citta) LIKE ? OR LOWER(nome_paese) LIKE ? LIMIT 10");
        $stmt->execute(array("%$search%", "%$search%"));
        return $this->fetch($stmt);
    }

    ///

    public function searchCompagnia($s) {
        $search = strtolower($s);
        $stmt = $this->connection->prepare(
                "SELECT * FROM compagnie_countries WHERE LOWER(nome) LIKE ? OR LOWER(paese) LIKE ? LIMIT 10");
        $stmt->execute(array("%$search%", "%$search%"));
        return $this->fetch($stmt);
    }

    public function nuovaCompagnia($nome, $nazionalita) {
        $stmt = $this->connection->prepare("SELECT * FROM nuova_compagnia(?,?)");
        $stmt->execute(array($nome, $nazionalita));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    public function modificaCompagnia($id, $nome, $id_paese_nazionalita) {
        $stmt = $this->connection->prepare("SELECT * FROM modifica_compagnia(?,?,?)");
        $stmt->execute(array($id, $nome, $id_paese_nazionalita));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    public function eliminaCompagnie($ids) {
        $_ids = array_map("strtoupper", $ids);
        $stmt = $this->connection->prepare("SELECT * FROM elimina_compagnie(?)");
        $stmt->execute(array(pg_array($_ids)));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    public function getCompagnia($id) {
        $stmt = $this->connection->prepare("SELECT * FROM compagnie WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $data = $this->fetch($stmt);
        return count($data) > 0 ? $data[0] : false;
    }

    ///aeroporti

    public function searchAeroporto($s) {
        $search = strtolower($s);
        $stmt = $this->connection->prepare(
                "SELECT aeroporti.sigla, aeroporti.nome, cities_countries.* FROM aeroporti "
                . "LEFT JOIN cities_countries ON aeroporti.id_citta = cities_countries.id_citta "
                . "WHERE LOWER(sigla) LIKE ? OR LOWER(nome) LIKE ? OR LOWER(nome_citta) LIKE ? OR LOWER(nome_paese) LIKE ? LIMIT 10");
        $stmt->execute(array("%$search%", "%$search%", "%$search%", "%$search%"));
        return $this->fetch($stmt);
    }

    public function getDettagliAeroporti($from, $to) {
        $stmt = $this->connection->prepare(
                "SELECT aeroporti.sigla, aeroporti.nome,cities_countries.* FROM aeroporti "
                . "LEFT JOIN cities_countries ON aeroporti.id_citta = cities_countries.id_citta "
                . "WHERE aeroporti.sigla = ? OR aeroporti.sigla = ? LIMIT 2");
        $stmt->execute(array($from, $to));
        return $this->fetch($stmt);
    }

    public function nuovoAeroporto($sigla, $nome, $id_citta) {
        $stmt = $this->connection->prepare("SELECT * FROM nuovo_aeroporto(?,?,?)");
        $stmt->execute(array($sigla, $nome, $id_citta));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    public function modificaAeroporto($old_sigla, $sigla, $nome, $id_citta) {
        $stmt = $this->connection->prepare("SELECT * FROM modifica_aeroporto(?,?,?,?)");
        $stmt->execute(array($sigla, $nome, $id_citta, $old_sigla));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    public function eliminaAeroporti($ids) {
        $_ids = array_map("strtoupper", $ids);
        $stmt = $this->connection->prepare("SELECT * FROM elimina_aeroporti(?)");
        $stmt->execute(array(pg_array($_ids)));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function getAeroporto($sigla) {
        $stmt = $this->connection->prepare("SELECT * FROM aeroporti_citta WHERE sigla = ? LIMIT 1");
        $stmt->execute(array($sigla));
        $data = $this->fetch($stmt);
        return count($data) > 0 ? $data[0] : false;
    }

    //aeroplani

    function searchAeroplano($s) {
        $search = strtolower($s);
        $stmt = $this->connection->prepare("SELECT * FROM tipi_aeroplani WHERE LOWER(nome) LIKE ? LIMIT 10");
        $stmt->execute(array("%$search%"));
        return $this->fetch($stmt);
    }

    function nuovoAeroplano($nome, $posti_economy, $posti_business) {
        $stmt = $this->connection->prepare("SELECT * FROM nuovo_aeroplano(?,?,?)");
        $stmt->execute(array($nome, $posti_economy, $posti_business));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function modificaAeroplano($id, $nome, $posti_economy, $posti_business) {
        $stmt = $this->connection->prepare("SELECT * FROM modifica_aeroplano(?,?,?,?)");
        $stmt->execute(array($id, $nome, $posti_economy, $posti_business));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function eliminaAeroplani($_ids) {
        $stmt = $this->connection->prepare("SELECT * FROM elimina_aeroplani(?)");
        $stmt->execute(array(pg_array($_ids)));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function getAeroplano($id) {
        $stmt = $this->connection->prepare("SELECT * FROM tipi_aeroplani WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $data = $this->fetch($stmt);
        return count($data) > 0 ? $data[0] : false;
    }

    /// voli

    function searchTratta($s) {
        $search = strtolower($s);
        $stmt = $this->connection->prepare("SELECT * FROM voli WHERE LOWER(codice) LIKE ? LIMIT 10");
        $stmt->execute(array("%$search%"));
        return $this->fetch($stmt);
    }

    function nuovaTratta($codice, $compagnia, $a_partenza, $a_arrivo, $durata, $p_economy, $p_business, $aeroplano) {
        $stmt = $this->connection->prepare("SELECT * FROM nuova_tratta(?,?,?,?,?,?,?,?)");
        $stmt->execute(array($codice, $compagnia, $a_partenza, $a_arrivo, $durata, $p_economy, $p_business, $aeroplano));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function getTratta($id) {
        $stmt = $this->connection->prepare("SELECT * FROM voli_compagnie_aeroplani WHERE codice = ? LIMIT 1");
        $stmt->execute(array($id));
        $data = $this->fetch($stmt);
        return count($data) > 0 ? $data[0] : false;
    }

    function getTratte() {
        $stmt = $this->connection->prepare("SELECT * FROM voli_compagnie_aeroplani");
        $stmt->execute();
        $data = $this->fetch($stmt);
        return count($data) > 0 ? $data : false;
    }

    function eliminaTratte($_ids) {
        $stmt = $this->connection->prepare("SELECT * FROM elimina_tratte(?)");
        $stmt->execute(array(pg_array($_ids)));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function modificaTratta($old_codice, $codice, $compagnia, $a_partenza, $a_arrivo, $durata, $p_economy, $p_business, $aeroplano) {
        $stmt = $this->connection->prepare("SELECT * FROM modifica_volo(?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($old_codice, $codice, $compagnia, $a_partenza, $a_arrivo, $durata, $p_economy, $p_business, $aeroplano));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    ///

    function searchVolo($s) {
        $search = strtolower($s);
        $stmt = $this->connection->prepare(
                "SELECT voli_pianificati.id, voli_pianificati.data_ora, voli_compagnie_aeroplani.* "
                . "FROM voli_pianificati INNER JOIN voli_compagnie_aeroplani "
                . "ON voli_compagnie_aeroplani.codice = codice_volo "
                . "WHERE LOWER(codice_volo) LIKE ? OR LOWER(nome_compagnia) LIKE ? OR LOWER(nome_aeroplano) LIKE ? LIMIT 10");
        $stmt->execute(array("%$search%", "%$search%", "%$search%"));
        return $this->fetch($stmt);
    }

    function searchVoli($from, $to, $passeggeri, DateTime $data, $classe, $page = 0) {
        $per_page = 30;
        $q = "SELECT * FROM pian_voli_tipi_posti_comp WHERE aeroporto_partenza = ? AND aeroporto_arrivo = ? AND data_ora > ? AND ";

        if ($classe == MyController::CLASSE_ALL) {
            //tutte le classi
            $q .= "(liberi_economy >= ? OR liberi_business >= ?)";
        } elseif ($classe == MyController::CLASSE_ECONOMY) {
            //economy
            $q .= "liberi_economy >= ?";
        } else {
            //business
            $q .= "liberi_business >= ?";
        }

        $q .= " ORDER BY data_ora ASC LIMIT $per_page OFFSET " . ($per_page * $page);

        $stmt = $this->connection->prepare($q); // AND data >= ?");
        $stmt->bindValue(1, $from, PDO::PARAM_STR);
        $stmt->bindValue(2, $to, PDO::PARAM_STR);
        $stmt->bindValue(3, DateTime_ts_no_tz($data), PDO::PARAM_STR);

        if ($classe == MyController::CLASSE_ALL) {
            //tutte le classi
            $stmt->bindValue(4, $passeggeri, PDO::PARAM_STR);
            $stmt->bindValue(5, $passeggeri, PDO::PARAM_STR);
        } elseif ($classe == MyController::CLASSE_ECONOMY) {
            //economy
            $stmt->bindValue(4, $passeggeri, PDO::PARAM_STR);
        } else {
            //business
            $stmt->bindValue(4, $passeggeri, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $this->fetch($stmt);
    }

    function getVolo($id) {
        $stmt = $this->connection->prepare("SELECT * FROM pian_voli_tipi_posti WHERE id = ? LIMIT 1");
        $stmt->execute(array("$id"));
        $data = $this->fetch($stmt);
        return $data[0];
    }

    function nuovoVolo($gate, $tratta, DateTime $data, $ritardo, $cancellato) {
        $stmt = $this->connection->prepare("SELECT * FROM nuovo_volo(?,?,?,?,?)");
        $stmt->execute(array($gate, $ritardo, $tratta, DateTime_ts_no_tz($data), $cancellato));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function eliminaVoli($_ids) {
        $stmt = $this->connection->prepare("SELECT * FROM elimina_voli(?)");
        $stmt->execute(array(pg_array($_ids)));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function modificaVolo($id, $gate, $tratta, DateTime $data, $ritardo, $cancellato) {
        $stmt = $this->connection->prepare("SELECT * FROM modifica_volo_pianificato(?,?,?,?,?,?)");
        $stmt->execute(array($id, $gate, $ritardo, $tratta, DateTime_ts_no_tz($data), $cancellato));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    ///

    function getTabellone() {
        $stmt = $this->connection->prepare("SELECT * FROM tabellone");
        $stmt->execute();
        return $this->fetch($stmt);
    }

    function getRealTime() {
        $stmt = $this->connection->prepare("SELECT * FROM realtime");
        $stmt->execute();
        return $this->fetch($stmt);
    }

    /// utenti

    function searchUtente($s) {
        $search = strtolower($s);
        $stmt = $this->connection->prepare(
                "SELECT id,nome,cognome,username,telefono,indirizzo FROM utenti WHERE LOWER(nome) LIKE ? OR LOWER(cognome) LIKE ? LIMIT 10");
        $stmt->execute(array("%$search%", "%$search%"));
        return $this->fetch($stmt);
    }

    function getUtenti() {
        $stmt = $this->connection->prepare("SELECT * FROM utenti");
        $stmt->execute();
        return $this->fetch($stmt, PDO::FETCH_ASSOC);
    }

    function getUtente($id) {
        $stmt = $this->connection->prepare("SELECT * FROM utenti WHERE id=? LIMIT 1");
        $stmt->execute(array("$id"));
        $data = $this->fetch($stmt, PDO::FETCH_ASSOC);
        return $data[0];
    }

    function login($username, $password) {
        $stmt = $this->connection->prepare("SELECT * FROM utenti WHERE LOWER(username) = ? AND passwd = ? LIMIT 1");
        $stmt->execute(array(strtolower($username), psw_hash($password)));
        $data = $this->fetch($stmt);
        return count($data) > 0 ? $data[0] : false;
    }

    function registraUtente($u) {
        $stmt = $this->connection->prepare("SELECT * FROM nuovo_utente(?,?,?,?,?,?,?,?)");
        $stmt->execute(array($u['nome'], $u['cognome'], $u['indirizzo'], $u['telefono'], $u['carta_credito'], $u['username'], psw_hash($u['password']), $u['user_level']));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function eliminaUtenti($_ids) {
        $stmt = $this->connection->prepare("SELECT * FROM elimina_utenti(?)");
        $stmt->execute(array(pg_array($_ids)));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function modificaUtente($u) {
        $stmt = $this->connection->prepare("SELECT * FROM modifica_utente(?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($u['nome'], $u['cognome'], $u['indirizzo'], $u['telefono'], $u['carta_credito'], $u['username'], psw_hash($u['password']), $u['user_level'], $u['id']));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    /// prenotazioni

    function getPrenotazione($id_prenotazione) {
        $stmt = $this->connection->prepare("SELECT * FROM prenotazioni_voli_aeroporti WHERE id = ? LIMIT 1");
        $stmt->execute(array($id_prenotazione));
        $data = $this->fetch($stmt);
        return count($data) > 0 ? $data[0] : false;
    }

    function eliminaPrenotazioni($_ids) {
        $stmt = $this->connection->prepare("SELECT * FROM elimina_prenotazioni(?)");
        $stmt->execute(array(pg_array($_ids)));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function modificaPrenotazione($p) {
        $stmt = $this->connection->prepare("SELECT * FROM modifica_prenotazione(?,?,?,?,?)");
        $stmt->execute(array($p['id'], $p['id_volo'], $p['id_utente'], $p['classe'], $p['passeggeri']));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function effettuaPrenotazione($id_volo, $id_utente, $classe, $passeggeri) {
        $stmt = $this->connection->prepare("SELECT * FROM nuova_prenotazione(localtimestamp,?,?,?,?)");
        $stmt->execute(array($id_volo, $id_utente, $classe, $passeggeri));
        return $stmt->rowCount() > 0 ? $this->connection->lastInsertId('prenotazioni_id_seq') : false;
    }

    function getPrenotazioniUtente($id_utente) {
        $stmt = $this->connection->prepare("SELECT * FROM prenotazioni WHERE id_utente = ?");
        $stmt->execute(array($id_utente));
        return $this->fetch($stmt);
    }

    /// statistiche

    function stat_passeggeriTrasportatiAeroporto() {
        $stmt = $this->connection->prepare("SELECT * FROM stat_passeggeri_trasportati_aeroporto");
        $stmt->execute();
        return $this->fetch($stmt);
    }

    function stat_maggioreCompagniaAeroporto() {
        $stmt = $this->connection->prepare("SELECT * FROM stat_maggiore_compagnia_aeroporto");
        $stmt->execute();
        return $this->fetch($stmt);
    }

    function stat_aeroplaniUtilizzati() {
        $stmt = $this->connection->prepare("SELECT * FROM stat_aeroplani");
        $stmt->execute();
        return $this->fetch($stmt);
    }

    function stat_tratte_popolari() {
        $stmt = $this->connection->prepare("SELECT * FROM tratte_preferite");
        $stmt->execute();
        return $this->fetch($stmt);
    }

    function stat_arrivi_partenze_aeroporti() {
        $stmt = $this->connection->prepare("SELECT *,(partiti + arrivati) as totale FROM arrivi_partenze_aeroporti WHERE partiti > 0 OR arrivati > 0");
        $stmt->execute();
        return $this->fetch($stmt);
    }

    function stat_tratte_prenotazioni() {
        $stmt = $this->connection->prepare("SELECT * FROM tratte_prenotazioni");
        $stmt->execute();
        return $this->fetch($stmt);
    }

    function stat_tratte_voli() {
        $stmt = $this->connection->prepare("SELECT * FROM tratte_voli WHERE voli > 0");
        $stmt->execute();
        return $this->fetch($stmt);
    }

}
