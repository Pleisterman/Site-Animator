<?php

/*
        @package    Pleisterman/Common
  
        file:       AddUserAgent.php
        function:   adds user agent information to the request attributes 
  
 
        Last revision: 24-12-2019
 
*/


namespace App\Common\Http\Middleware;

use Closure;
use App\Http\Base\BaseClass;

class AddUserAgent extends BaseClass {

    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {
        
        // get debugger
        $this->debugger = \App::make('Debugger');

        // debug info
        $this->debug( 'MIDDLEWARE  User agent ' );

        // get mobile detect
        $mobileDetect = \App::make('MobileDetect');
        
        // debug info
        $this->debug( 'mobile: ' . json_encode( $mobileDetect->isMobile(), true ) );
        
        // debug info
        $this->debug( 'user agent: ' . $mobileDetect->getUserAgent() );
        
        // get request is secure
        $secure = $request->secure() ? true : false;
        
        // get request action
        $action = $request->route()->getAction();
       
        // create prefix
        $prefix = isset( $action['appCode'] ) ? $action['appCode'] . '_' : 'COMMON_';
        
        // add admin / site
        $prefix .= isset( $action['isAdmin'] ) && $action['isAdmin'] ? 'ADMIN_' : 'SITE_';
                
        // ! admin connection secure
        if( !env( $prefix . 'AUTHORISATION_SECURE_PROTOCOL' ) ){
            
            // debug info
            $this->debug( '-- OVERRIDE PROTOCOL SECURE --' );
            
            // override secure
            $secure = true;
            
        }
        // ! admin connection secure
        
        // get is mobile
        $isMobile = $mobileDetect->isMobile() ? true : false;
        
        // admin mobile
        if( env( $prefix . 'MOBILE' ) ){
            
            // override is mobile
            $isMobile = true;
            
        }
        // admin mobile

        // get user agent
        $userAgent = request()->header('User-Agent');
        
        // debug info
        $this->debug( 'userAgent: ' . $userAgent );
        
        // create user agent array
        $userAgentArray = array(
            'userAgent'     =>  $userAgent,
            'isMobile'      =>  $isMobile,
            'isTablet'      =>  $mobileDetect->isTablet(),
            'protocol'      =>  $request->getScheme(),
            'secure'        =>  $secure,
        );
        // create user agent array
        
        // set admin user agent
        $request->attributes->set( 'userAgent', $userAgentArray );
        
        // follow the flow
        return $next( $request );
        
    }
}
