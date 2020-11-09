<?php

/*
        @package    Pleisterman/Common
  
        file:       AddStandardHeaders.php
        function:   
                    
        Last revision: 03-01-2020
 
*/

namespace App\Common\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;

    class AddStandardHeaders extends BaseClass {
    
    protected $debugOn = true;
    private $headers = array( 
        'cache-control' => 'max-age=172800‬'
    );
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common site add standard headers' );

        // add headers to request
        $request->attributes->set( 'headers', $this->headers );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
