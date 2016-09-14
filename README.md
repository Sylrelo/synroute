# Synroute
 A simple php router.
 
Usage :

    require 'synroute.php';

    $route = new Synroute();
    
    $route->get('/', function(){
	    // your code here
    });
    
    $route->post('/superlink', function(){
	    // your code here
    });
    
    $route->run();

If your hoster is not compatible with url rewriting, you still can make beautiful(-ish) URLs by adding :

    $route->norewrite();
Example : 

    <a href="http://web.com/?/forum">Forum</a>
    <a href="http://web.com/?/about">About</a>
    
    <a href="http://web.com/?/page/6">Page 6</a>
    
    // This would be the equivalent to : 
    // web.com/index.php?/link

And the routes will be functionnal.