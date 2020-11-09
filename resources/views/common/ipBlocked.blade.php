<?php
/*
    @package    Pleisterman\Common

    file:       ipBlocked.blade.php
    function:   creates the error page for the site route

    Last revision: 12-12-2018
 
*/    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ip blocked</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <link href="{{ URL::to( '/public/common/css/common.css') }}" media="screen" rel="stylesheet" type="text/css">
        
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Your IP has been blocked</div>
                
                <h1>Please contact us at info@pleisterman.nl to resolve the issue...</h1>
                

                
            </div>
        </div>
    </body>
     
</html>
