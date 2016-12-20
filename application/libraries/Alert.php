<?php

/* FILIPPO BISCONCIN */

class Alert {

    private $dismissible = true;
    private $class = 'info';
    private $text = 'Alert';

    public function __construct() {

    }

    public function __contstruct($text, $class = 'info', $dismissible = true) {
        $this->text = $text;
        $this->class = $class;
        $this->dismissible = $dismissible;
    }

    public static function atLeastOne() {
        $CI = & get_instance();
        $ateleastone = (isset($CI->data['alert_list']) && is_array($CI->data['alert_list']));
        //$ateleastone = $ateleastone && ($CI->session->flashdata('alert_list') != "") ;
        return $ateleastone;
    }

    public static function printAll() {
        $CI = & get_instance();
        if (isset($CI->data['alert_list']) && is_array($CI->data['alert_list'])):
            foreach ($CI->data['alert_list'] as $alert):
                echo $alert->to_html();
            endforeach;
        endif;
    }

    public function create($text = "Alert", $class = "info", $dismissible = false) {
        $this->text = $text;
        $this->class = $class;
        $this->dismissible = $dismissible;
    }

    public function to_html() {
        $out = "<div class='alert alert-$this->class " . ($this->dismissible ? "alert-dismissible" : "") . "' role='alert'>";
        if ($this->dismissible) {
            $out .= '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
        }
        $out .= $this->text;
        $out .= "</div>";
        return $out;
    }

    public function static_append() {
        $al = $this;
        $CI = & get_instance();
        if (!isset($CI->data['alert_list'])) {
            $CI->data['alert_list'] = array($al);
        } else {
            $CI->data['alert_list'][] = $al;
        }
    }

}
