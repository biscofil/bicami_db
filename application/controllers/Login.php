<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MyController {

    public function index() {
        if (isLogged()) {
            redirect('profilo', 'refresh');
        }
        $this->pageTitle('Login');
        if (isset($_POST['login'])) {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $data = $this->mypghelper->login($_POST['username'], $_POST['password']);
                if ($data) {
                    doLogin($data);
                    redirect('profilo', 'refresh');
                } else {
                    $a = new Alert();
                    $a->create("Credenziali errate", 'danger');
                    $a->static_append();
                }
            } else {
                $a = new Alert();
                $a->create("Dati mancanti", 'danger');
                $a->static_append();
            }
        }
        $this->loadView('login/login');
    }

    public function registrazione() {
        if (isLogged()) {
            redirect('profilo', 'refresh');
        }
        $utente = array();
        $this->pageTitle('Registrazione');
        if (isset($_POST['registrazione'])) {
            if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['indirizzo']) &&
                    isset($_POST['telefono']) && isset($_POST['carta_credito']) && isset($_POST['username']) &&
                    isset($_POST['password']) && isset($_POST['confirm'])) {

                $utente = array(
                    'nome' => $_POST['nome'],
                    'cognome' => $_POST['cognome'],
                    'indirizzo' => $_POST['indirizzo'],
                    'telefono' => $_POST['telefono'],
                    'carta_credito' => $_POST['carta_credito'],
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'confirm' => $_POST['confirm'],
                    'user_level' => MyController::USER_BASIC
                );


                if ($utente['password'] == $utente['confirm']) {

                    $data = $this->mypghelper->registraUtente($utente);
                    if ($data) {
                        redirect('login', 'refresh');
                    } else {
                        $a = new Alert();
                        $a->create("Impossibile registrare l'utente", 'danger');
                        $a->static_append();
                    }
                } else {
                    $a = new Alert();
                    $a->create("Le password non corrispondono", 'danger');
                    $a->static_append();
                }
            } else {
                $a = new Alert();
                $a->create("Dati mancanti", 'danger');
                $a->static_append();
            }
        }
        $this->data['utente'] = $utente;
        $this->loadView('login/registrazione');
    }

    public function logout() {
        if (isLogged()) {
            doLogout();
        }
        redirect('login/index', 'refresh');
    }

}
