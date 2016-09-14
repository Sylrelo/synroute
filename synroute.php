<?php
class SynRoute {

    private $_uri = '';
    private $_callback = '';
    private $_type = '';
    private $url = '';

    public function __construct(){
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $url = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        $this->url = '/' . trim($url, '/');
    }

    public function norewrite(){
        $this->url = $_SERVER['QUERY_STRING'];
    }

    public function add($type, $uri, $callback){
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

    public function run(){
        foreach($this->_uri as $k => $v){
            if(preg_match("#^$v$#", $this->url, $params) && $_SERVER['REQUEST_METHOD'] == $this->_type[$k]){
                array_shift($params);
                call_user_func_array($this->_callback[$k], $params);
            }
        }
    }
}

?>
