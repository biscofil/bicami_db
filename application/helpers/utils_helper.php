<?php

const pg_timestamp_format = 'Y-m-d H:i:s';
const post_format = 'd/m/Y H:i'; //'Y-m-d H:i:s'

function isLogged() {
    return (isset($_SESSION['logged_id']) && $_SESSION['logged_id'] == 1);
}

function isAdmin() {
    return (isLogged() && $_SESSION['user_level'] == 1);
}

function psw_hash($psw) {
    return sha1(md5($psw));
}

function doLogin($utente) {
    $_SESSION['id'] = $utente['id'];
    $_SESSION['nome'] = $utente['nome'];
    $_SESSION['cognome'] = $utente['cognome'];
    $_SESSION['indirizzo'] = $utente['indirizzo'];
    $_SESSION['telefono'] = $utente['telefono'];
    $_SESSION['carta_credito'] = $utente['carta_credito'];
    $_SESSION['username'] = $utente['username'];
    //$_SESSION['password'] = $utente['password'];
    $_SESSION['user_level'] = $utente['user_level'];
    $_SESSION['logged_id'] = 1;
}

function doLogout() {
    session_unset();
    session_destroy();
}

function sessionInfo($field) {
    return array_key_exists($field, $_SESSION) ? $_SESSION[$field] : null;
}

function setValue($array, $key) {
    return array_key_exists($key, $array) ? $array[$key] : "";
}

function nomeClasse($id) {
    return $id == MyController::CLASSE_BUSINESS ? "Business" : ($id == MyController::CLASSE_ECONOMY ? "Economy" : "Tutte");
}

function timestamp_no_tz($data) {
    return date(pg_timestamp_format, strtotime($data));
}

function DateTime_ts_no_tz(DateTime $dt) {
    return $dt->format(pg_timestamp_format);
}

function pg_array(Array $arr) {
    return "{" . implode(',', $arr) . "}";
}

function getPostDateTime($str) {
    $out = DateTime::createFromFormat(post_format, $str);
    if (!$out) {
        $out = DateTime::createFromFormat(pg_timestamp_format, $str);
    }
    return $out;
}

function get_string_between($string, $start, $end) {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
