<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       GetUserLanguage.php
        function:   
                    
        Last revision: 22-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Admin;

use Closure;
use App\Common\Base\BaseClass;

class GetUserLanguage extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator admin GetUserLanguage' );

        
        // set colors
        $request->attributes->set( 'adminUserLanguage', $userLanguage );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
