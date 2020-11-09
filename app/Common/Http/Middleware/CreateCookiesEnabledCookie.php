<?php

/*
        @package    Pleisterman/Common
  
        file:       CreateCookiesEnabledCookie.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware;

use Closure;
use Cookie;
use App\Common\Base\BaseClass;

    class CreateCookiesEnabledCookie extends BaseClass {
    
    protected $debugOn = true;
    private $ip = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin cookiesEnabledCookie' );

        // get request action
        $action = $request->route()->getAction();
        
        // get app code
        $appCode = isset( $action['appCode'] ) ? $action['appCode']: false;

        // get is admin 
        $isAdmin = isset( $action['isAdmin'] ) ? $action['isAdmin']: false;

        // create prefix
        $prefix = $appCode;
        
        // add admin / site
        $prefix .= $isAdmin ? '_ADMIN' : '_SITE';
        
        // add cookie to queue
        Cookie::queue( Cookie::make( env( $prefix . '_AUTHORISATION_COOKIES_ENABLED_NAME' ), 
                                    'true', 
                                    10, 
                                    env( $prefix . '_AUTHORISATION_COOKIE_PATH' ), 
                                    null, false, true ) );
        // add cookie to queue
        

        // follow the flow
        return $next( $request );
        
    }
    
}
