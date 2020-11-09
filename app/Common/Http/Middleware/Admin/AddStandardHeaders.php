<?php

/*
        @package    Pleisterman/Common
  
        file:       AddStandardHeaders.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin;

use Closure;
use App\Common\Base\BaseClass;

    class AddStandardHeaders extends BaseClass {
    
    protected $debugOn = true;
    private $headers = array( 
        'Cache-Control' => 'max-age=172800‬'
    );
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin add standard headers' );

        // add headers to request
        $request->attributes->set( 'headers', $this->headers );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
