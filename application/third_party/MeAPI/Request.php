<?php

class MeAPI_Request implements MeAPI_RequestInterface {

    protected $_controller;
    protected $_function;
    protected $_app;
    protected $_lang;
    private $_get;
    private $_post;
    private $_request;
    protected $controller_map = array();
    protected $function_map = array();

    public function __construct($get = array(), $post = array()) {
        $this->_get = $get;
        $this->_post = $post;
        $this->_request = array_merge($get, $post);
        $this->controller_map = MeAPI_Config_Map::getController();
        $this->function_map = MeAPI_Config_Map::getFunction();
    }

    public function createFromGlobals($data = NULL) {
        $CI = & get_instance();
        $class = __CLASS__;
        if (empty($data) === TRUE) {
            $tmp_get = $CI->input->get(NULL, TRUE);
            $tmp_post = $CI->input->post(NULL, TRUE);
        } else {
            $tmp_get = $data;
        }
        if (is_array($tmp_get) == FALSE)
            $tmp_get = array();
        if (is_array($tmp_post) == FALSE)
            $tmp_post = array();
        $get = array_change_key_case($tmp_get, CASE_LOWER);
        $post = array_change_key_case($tmp_post, CASE_LOWER);
        unset($tmp_get);
        unset($tmp_post);
        $request = new $class($get, $post);
        return $request;
    }

    public function get_controller() {
        if ($this->_controller)
            return $this->_controller;

        $controller = $this->input_request('control');
        if (isset($controller)) {
            $this->_controller = strtolower($controller);
            if ($this->controller_map[$this->_controller])
                $this->_controller = $this->controller_map[$this->_controller];
            return $this->_controller;
        } else {
            return NULL;
        }
    }

    public function get_function() {
        if ($this->_function)
            return $this->_function;

        $function = $this->input_request('func');
        if (isset($function)) {
            $this->_function = strtolower($function);
            if ($this->function_map[$this->_function])
                $this->_function = $this->function_map[$this->_function];
            return $this->_function;
        } else {
            return NULL;
        }
    }

    public function get_app() {
        if ($this->_app)
            return $this->_app;

        $app = $this->input_request('app');
        if (!empty($app)) {
            $this->_app = strtolower($app);
            return $this->_app;
        } else {
            return NULL;
        }
    }

    public function get_lang() {
        if ($this->_lang)
            return $this->_lang;

        $lang = $this->input_request('lang');
        if (!empty($lang)) {
            $this->_lang = strtolower($lang);
            return $this->_lang;
        } else {
            return 'default';
        }
    }

    public function input_get($name = NULLs, $default = FALSE) {
        if ($name == NULL) {
            return $this->_get;
        } else {
            $name = strtolower($name);
            $data = $this->_get[$name];
            if (isset($data) == TRUE) {
                return $data;
            } else {
                return $default;
            }
        }
    }

    public function input_post($name = NULL, $default = FALSE) {
        if ($name == NULL) {
            return $this->_post;
        } else {
            $name = strtolower($name);
            $data = $this->_post[$name];
            if (isset($data) == TRUE) {
                return $data;
            } else {
                return $default;
            }
        }
    }

    public function input_request($name = NULL, $default = FALSE) {
        if ($name == NULL) {
            return $this->_request;
        } else {
            $name = strtolower($name);
            $data = $this->_request[$name];
            if (isset($data) == TRUE) {
                return $data;
            } else {
                return $default;
            }
        }
    }

}

?>
