<?php
/*
    @package    Pleisterman\Website

    file:       site\error.blade.php
    function:   creates the error page for the site route

    Last revision: 12-12-2018
 
*/    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Not found</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <link href="{{ URL::to( '/public/common/css/common.css') }}" media="screen" rel="stylesheet" type="text/css">
        
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Route not found</div>
                
                <h1>Page not found...</h1>
                

                
            </div>
        </div>
    </body>
     
</html>
