<?php

    require 'synroute.php';

    $route = new SynRoute();

    $route->get('/', function(){
        echo "Home !";
    });

    $route->post('/hello', function(){
        echo "Hello !";
    });

    $route->get('/page/([0-9]++)', function($a){
        echo "Showing page number + " . $a;
    });

    $route->run();

?>