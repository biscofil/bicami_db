<?php

class SessionController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start() or die("ERRORE SERVER, IMPOSSIBILE AVVIARE LA SESSIONE!");
        date_default_timezone_set("Europe/Rome");
    }

}

class MyController extends SessionController {

    public $data = array();

    const CLASSE_BUSINESS = 2;
    const CLASSE_ECONOMY = 1;
    const CLASSE_ALL = 0;
    const USER_ADMIN = 1;
    const USER_BASIC = 0;

    public function __construct() {
        parent::__construct();
        $this->data['_page_title'] = 'Default Page Title';
        $this->js_css_begin();
    }

    public function js_css_begin() {
        $this->jscsshandler->addCssFile(base_url('public/select2/css/select2.css'));
        $this->jscsshandler->addCssFile(base_url('public/select2/css/select2-bootstrap.css'));
        $this->jscsshandler->setJsProperty('site_url', site_url());
        $this->jscsshandler->setJsProperty('base_url', base_url());
        $this->jscsshandler->setJsProperty('xhr_controller', 'xhr');
        $this->jscsshandler->addJsFile(base_url('public/jquery-3.1.1.min.js'));
        $this->jscsshandler->addJsFile(base_url('public/bootstrap/js/bootstrap.min.js'));
        $this->jscsshandler->addJsFile(base_url('public/select2/js/select2.js'));
        //$this->jscsshandler->addJsFile(base_url('public/select2/js/i18n/it.js'));
        $this->jscsshandler->addJsFile(base_url('public/bootbox.min.js'));
        $this->jscsshandler->addJsFile(base_url('public/theme.js'));
        $this->jscsshandler->addJsFile(base_url('public/moment.js'));
        $this->jscsshandler->addJsFile(base_url('public/notify.min.js'));
    }

    public function js_css_end() {
        $this->jscsshandler->addJsFile(base_url('public/js/' . $this->router->fetch_class() . '/_' . $this->router->fetch_class() . '.js'));
        $this->jscsshandler->addJsFile(base_url('public/js/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '.js'));
        $this->jscsshandler->addJsFile(base_url('public/js/common.js'));
    }

    public function loadView($file) {
        $this->js_css_end();
        $this->load->view('common/header', $this->data);
        $this->load->view($file, $this->data);
        $this->load->view('common/footer', $this->data);
    }

    public function pageTitle($title) {
        $this->data['_page_title'] = $title;
    }

    public function pageSubTitle($subTitle) {
        $this->data['_page_sub_title'] = $subTitle;
    }

}

class LoggedController extends MyController {

    public function __construct() {
        parent::__construct();

        if (!isLogged()) {
            redirect('login', 'refresh');
        }
    }

}

class AdminController extends LoggedController {

    public function __construct() {
        parent::__construct();

        if (!isAdmin()) {
            redirect('home', 'refresh');
        }
    }

}

class AdminCrudController extends AdminController {

    public function loadView($file) {
        $this->js_css_end();
        $this->load->view('common/header', $this->data);
        $this->load->view('admin/body_header', $this->data);
        $this->load->view($file, $this->data);
        $this->load->view('common/footer', $this->data);
    }

}

class XhrController extends SessionController {

    public function __construct() {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public static function xhr_require_login() {
        if (!isLogged()) {
            self::_error("Devi essere loggato");
        }
    }

    public static function xhr_require_admin() {
        if (!isAdmin()) {
            self::_error("Devi essere admin");
        }
    }

    public static function _success($data_label = null, $data = null) {
        $v = array('result' => 1);
        if (!is_null($data_label)) {
            $v[$data_label] = $data;
        }
        die(json_encode($v));
    }

    public static function _error($err = "Errore non specificato", $data = null) {
        $v = array('result' => 0, 'error' => $err);
        if (!is_null($data)) {
            $v['data'] = $data;
        }
        die(json_encode($v));
    }

    public function _remap($method, $params = array()) {
        $out = null;
        if (method_exists($this, $method)) {
            try {
                $out = call_user_func_array(array($this, $method), $params);
            } catch (PDOException $Exception) {
                $parsed = get_string_between($Exception->getMessage(), 'ERROR:', 'CONTEXT:');
                self::_error($parsed, $Exception->getMessage());
            } catch (Exception $ex) {
                self::_error($ex->getMessage(), $ex->getTraceAsString());
            }
        } else {
            //header("HTTP/1.1 404 Not Found");
            $this->output->set_status_header('404');
        }
        return $out;
    }

    public function index() {
        die("NOT ALLOWED");
    }

    public static function post_fields_required($fields) {
        $out = true;
        $missing = array();
        if (is_array($fields)) {
            foreach ($fields as $field) {
                if (!isset($_POST[$field])) {
                    $out = false;
                    $missing[] = $field;
                }
            }
        } else {
            if (!isset($_POST[$fields])) {
                $out = false;
                $missing[] = $fields;
            }
        }
        if (!$out) {
            self::_error("Mancano i parametri " . implode(",", $missing));
        }
    }

    public static function def_end($res, $data_label = null, $data = null, $err = null) {
        if ($res) {
            self::_success($data_label, $data);
        } else {
            self::_error(is_null($err) ? serialize($res) : $err);
        }
    }

}
