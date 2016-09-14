# Synroute
###### A simple php router.
 
Usage :
````php
    require 'synroute.php';
    $route = new Synroute();
    
    $route->get('/', function(){
	    // your code here
    });
    
    // Can use regular expression
    $route->get('/page/([0-9]++)', function($p){
	    // your code here
    });
    
    $route->post('/superlink', function(){
	    // your code here
    });
    $route->run();
````
If your hoster is not compatible with url rewriting, you still can make beautiful(-ish) URLs by adding :
````php
    $route->norewrite();
````    
Example : 
````html
    <a href="http://web.com/?/forum">Forum</a>
    <a href="http://web.com/?/about">About</a>
    <a href="http://web.com/?/page/6">Page 6</a>
````
This would be the equivalent to  *web.com/index.php?/link*
And the routes will be functionnal.