<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       Test.php
        function:   
                    
        Last revision: 12-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;

class Test extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator site Test' );

        // follow the flow
        return $next( $request );
        
    }
    
}
