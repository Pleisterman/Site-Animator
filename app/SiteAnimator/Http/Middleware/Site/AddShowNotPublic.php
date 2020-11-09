<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddShowNotPublic.php
        function:   
                    
        Last revision: 26-07-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;

class AddShowNotPublic extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator site AddShowNotPublic' );

        // set show not public
        $request->attributes->set( 'showNotPublic', true );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
