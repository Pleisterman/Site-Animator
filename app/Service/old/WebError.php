<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Service/Common/ApiError.php
        function:   create singleton service ApiError
 
        Last revision: 27-09-2019
 
*/

namespace App\Service\Common;

use App\Http\Base\BaseClass;

class WebError extends BaseClass  {

    protected $debugOn = true;
    private $authentificationError = 'somethingWentWrong';
    public function webError( $request, $error ){
        
        // debug info 
        $this->debug( 'WebError webError: ' . $error  );
        
        // get request action
        $action = $request->route()->getAction();
       
        // get redirect to site
        $redirectToSite = isset( $action['redirectToSite'] ) ? $action['redirectToSite'] : 'error';
        
        // return result
        return redirect()->route( $redirectToSite );
        
    }
    public function criticalError( $request, $error ){
        
        // debug info 
        $this->debug( 'ApiError CriticalError: ' . $error  );
        
        // create result
        $result = array( 
            'criticalError' => $error
        );
        // create result        
        
        // return result
        return $result;
        
    }
    public function authentificationError( $request ){
        
        // debug info 
        $this->debug( 'ApiError authentification error' );

        $ip = $request->attributes->get( 'ip' );
        
        // debug info 
        $this->debug( 'ip: ' . $ip->ip );

        // create delay
        $delay = rand( 100, 1000 );
        
        // delay
        usleep( $delay );        
        
        // return error
        return array( 'error' => $this->authentificationError );
        
    }
}