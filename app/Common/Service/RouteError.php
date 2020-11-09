<?php

/*
        @package    Pleisterman/Common
  
        file:       RouteError.php
        function:   create singleton service RouteError
 
        Last revision: 22-12-2019
 
*/

namespace App\Common\Service;

use App\Common\Base\BaseClass;

class RouteError extends BaseClass  {

    protected $debugOn = true;
    private $AuthenticationError = 'somethingWentWrong';
    private $dataOutOfDateError = 'dataOutOfDate';
    public function routeError( $request, $error ){
        
        // debug info 
        $this->debug( 'RouteError routeError: ' . $error  );

        // is ajax
        if( $request->ajax() ){
            
            // debug info 
            $this->debug( 'api error'  );
        
            // create result
            $result = array( 
                'error' => $error
            );
            // create result        

            // return result
            return $result;
            
        }
        // is ajax

        // debug info 
        $this->debug( 'web error: ' );
        
        // get request action
        $action = $request->route()->getAction();
       
        // get redirect to site
        $redirectToSite = isset( $action['redirectToSite'] ) ? $action['redirectToSite'] : 'error';
        
        // return result
        return redirect()->route( $redirectToSite );
        
    }
    public function cookiesDisabledError( $request ){
        
        // debug info 
        $this->debug( 'RouteError: CookiesDisabled'  );

        // is ajax
        if( $request->ajax() ){
            
            // debug info 
            $this->debug( 'api error'  );
        
            // create errpr
            $error = array( 
                'criticalError'     =>  'cookiesDisabled'
            );
            // create errpr
            
            // return error
            return array( 'result' => $error, 'procesId' => $request->input('procesId') );
            
        }
        // is ajax

        // debug info 
        $this->debug( 'web error: ' );
        
        // get request action
        $action = $request->route()->getAction();
       
        // get redirect to error
        $redirectToError = isset( $action['redirectOnError'] ) ? $action['redirectOnError'] : 'error';
        
        // return result
        return redirect()->route( $redirectToError );
        
    }
    public function criticalError( $request, $error ){
        
        // debug info 
        $this->debug( 'RouteError CriticalError: ' . $error  );
        
        // is ajax
        if( $request->ajax() ){
            
            // debug info 
            $this->debug( 'api error'  );
        
            // create result
            $result = array( 
                'criticalError' => $error
            );
            // create result        
            
            // return error
            return array( 'result' => $error, 'procesId' => $request->input('procesId') );
            
        }
        // is ajax

        // debug info 
        $this->debug( 'web error: ' );
        
        // return result
        return redirect()->route( 'error' );
        
    }
    public function ipBlockedError( $request ){
        
        // create delay
        $delay = rand( env( 'AUTHORISATION_ADMIN_IP_BLOCKED_MINIMUM_DELAY' ), 
                       env( 'AUTHORISATION_ADMIN_IP_BLOCKED_MAXIMUM_DELAY' ) );
        // create delay
        
        // delay
        usleep( $delay );        
        
        // is ajax
        if( $request->ajax() ){
            
            // debug info 
            $this->debug( 'ipBlockedError error'  );
        
            // return result
            return [];
            
        }
        // is ajax

        // debug info 
        $this->debug( 'web error: ' );
        
        // get request action
        $action = $request->route()->getAction();
       
        // get redirect to site
        $redirectToSite = isset( $action['redirectToIpBlocked'] ) ? $action['redirectToIpBlocked'] : 'ipBlocked';
        
        // return result
        return redirect()->route( $redirectToSite );
        
    }
    public function AuthenticationError( $request ){
        
        // create delay
        $delay = rand( env( 'AUTHORISATION_ADMIN_ERROR_MINIMUM_DELAY' ), 
                       env( 'AUTHORISATION_ADMIN_ERROR_MAXIMUM_DELAY' ) );
        // create delay
        
        // delay
        usleep( $delay );        
        
        // is ajax
        if( $request->ajax() ){
            
            // debug info 
            $this->debug( 'api error'  );
        
            // return result
            return [];
            
        }
        // is ajax

        // debug info 
        $this->debug( 'Authentication error' );

        // debug info 
        $this->debug( 'web error: ' );
        
        // get request action
        $action = $request->route()->getAction();
       
        // get redirect to site
        $redirectToSite = isset( $action['redirectToSite'] ) ? $action['redirectToSite'] : 'error';
        
        // return result
        return redirect()->route( $redirectToSite );
        
    }
    public function dataOutOfDate( ){
        
        // debug info 
        $this->debug( 'ApiError dataOutOfDate'  );
        
        // return result
        return $this->dataOutOfDateError;
        
    }
    public function delay( ){
        
        // create delay
        $delay = rand( 100, 1000 );
        
        // delay
        usleep( $delay );        
        
    }
}