<?php

/**
 * Description of JsCssHandler
 *
 * @author filippo bisconcin
 */
class Jscsshandler {

    public $properties = array();
    public $js_files = array();
    public $css_files = array();

    public function setJsProperty($name, $value) {
        $this->properties[$name] = $value;
    }

    public function myformat($data) {
        if (is_array($data)) {
            $out = "[";
            foreach ($data as $key => $val) {
                $out .= $this->myformat($val) . ",";
            }
            return $out . "]";
        } elseif (is_object($data)) {
            $out = "{";
            foreach ($data as $key => $val) {
                $out .="'$key':" . $this->myformat($val) . ",";
            }
            return $out . "}";
        } elseif (is_numeric($data)) {
            return $data;
        //} elseif (is_string($data)) {
        //    return "'$data'";
        } else {
            return "'$data'"; //boh
        }
    }

    public function addJsFile($path, $params = null) {
        $this->js_files[] = array('url' => $path, 'params' => $params);
    }

    public function addCssFile($path, $params = array('rel' => 'stylesheet')) {
        $this->css_files[] = array('url' => $path, 'params' => $params);
    }

    public function out_js_properties() {
        echo '<script>' . PHP_EOL;
        foreach ($this->properties as $key => $value) {
            echo 'var __' . $key . ' = ' . $this->myformat($value) . ';' . PHP_EOL;
        }
        echo '</script>' . PHP_EOL;
    }

    public function out_js_files() {
        foreach ($this->js_files as $file) {
            echo '<script src="' . $file['url'] . '"';
            if (!is_null($file['params'])) {
                foreach ($file['params'] as $key => $value) {
                    echo ' ' . $key . (!is_null($value) ? '="' . $value . '"' : '');
                }
            }
            echo '></script>' . PHP_EOL;
        }
    }

    public function out_css_files() {
        foreach ($this->css_files as $file) {
            echo '<link href="' . $file['url'] . '"';
            if (!is_null($file['params'])) {
                foreach ($file['params'] as $key => $value) {
                    echo ' ' . $key . (!is_null($value) ? '="' . $value . '"' : '');
                }
            }
            echo '>' . PHP_EOL;
        }
    }

}
