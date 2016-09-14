<?php
class SynRoute {

    private $_uri = '';
    private $_callback = '';
    private $_type = '';
    private $_basepath = '';
    private $_xhr = '';

    public function debug(){
        //return [$this->_basepath, $this->_uri, $this->_type, $this->_xhr];
        $arr = [];
        foreach($this->_uri as $k => $v){
            $arr[] = array('route' => $v, 'method' => $this->_type[$k], 'ajax' => $this->_xhr[$k]);
        }
        return $arr;
    }

    public function __construct(){
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $_basepath = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        $this->_basepath = '/' . trim($_basepath, '/');
    }

    public function norewrite(){
        $this->_basepath = $_SERVER['QUERY_STRING'];
    }

    public function add($type, $uri, $callback){
        $checkXHR = explode(':', $uri);
        $xhr = 0;

        if($checkXHR[0] == "x" OR $checkXHR[0] == "xhr") {
            $uri = $checkXHR[1];
            $xhr = 1;
        }

        $this->_xhr[] = $xhr;
        $this->_uri[] = $uri;
        $this->_callback[] = $callback;
        $this->_type[] = $type;
    }

    public function get($uri, $callback){
        $this->add('GET', $uri, $callback);
    }

    public function post($uri, $callback){
        $this->add('POST', $uri, $callback);
    }

    public function put($uri, $callback){
        $this->add('PUT', $uri, $callback);
    }
    public function delete($uri, $callback){
        $this->add('DELETE', $uri, $callback);
    }

    public function checkXHR($k){
        //return ($this->_xhr[$k] == 1 ? (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ? true : false) : true );
        if($this->_xhr[$k] == 1){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 1;
        }
    }

    public function rMethod($k){
            return ($_SERVER['REQUEST_METHOD'] == $this->_type[$k] ? true : false);
    }

    public function run(){
        foreach($this->_uri as $k => $v){
            if(preg_match("#^$v$#", $this->_basepath, $params) && $this->rMethod($k) && $this->checkXHR($k)){
                array_shift($params);
                call_user_func_array($this->_callback[$k], $params);
            }
        }
    }
}

?>
