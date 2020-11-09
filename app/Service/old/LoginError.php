<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Service/Common/LoginError.php
        function:   handles login errors
                    webrouteError
                        redirect to error route
                    handleLoginError
                        return with error
                    handleLoginDelayedError
                        create a delay
                        minimum delay: env var: ADMIN_LOGIN_ERROR_MINIMUM_DELAY_US
                        maximum delay: env var: ADMIN_LOGIN_ERROR_MAXIMUM_DELAY_US
                        return with error
                    handleLoginStrikeError
                        create a delay
                        minimum delay: env var: ADMIN_LOGIN_ERROR_MINIMUM_DELAY_US
                        maximum delay: env var: ADMIN_LOGIN_ERROR_MAXIMUM_DELAY_US
                        return with error
 
        Last revision: 01-02-2019
 
*/

namespace App\Service\Common;

use App\Http\Base\BaseClass;

class LoginError extends BaseClass  {

    protected $debugOn = true;
    private $errorRoute = '/error';
    public function handleWebRouteError( $error ){
        
        // debug info 
        $this->debug( 'LoginError web Route Error: ' . $error  );
        
        // redirect to admin error
        return redirect( $this->errorRoute );
        
    }
    public function handleLoginError( $request, $error ){
        
        // debug info 
        $this->debug( 'LoginError handleLoginError Error: ' . $error  );
        
        // create result
        $result = array(
            'error' =>  $error
        );
        // create result
        
        // return error
        return array( 'procesId' => $request->input('procesId'), 'result' => $result );
        
    }
    public function handleLoginDelayedError( $request, $error ){
        
        // debug info 
        $this->debug( 'LoginError handleLoginDelayedError Error: ' . $error  );
        
        // create delay
        $delay = rand( env( 'ADMIN_LOGIN_ERROR_MINIMUM_DELAY_US' ), env( 'ADMIN_LOGIN_ERROR_MAXIMUM_DELAY_US' ) );
        // delay
        usleep( $delay );
        
        // create result
        $result = array(
            'error' =>  $error
        );
        // create result
        
        // return error
        return array( 'procesId' => $request->input( 'procesId' ), 'result' => $result );
        
    }
    public function handleLoginStrikeError( $request, $error ){
        
        // debug info 
        $this->debug( 'LoginError handleLoginDelayedError Error: ' . $error  );
        
        // create delay
        $delay = rand( env( 'ADMIN_LOGIN_ERROR_MINIMUM_DELAY_US' ), env( 'ADMIN_LOGIN_ERROR_MAXIMUM_DELAY_US' ) );
        // delay
        usleep( $delay );
        
        // create result
        $result = array(
            'error' =>  $error
        );
        // create result
        
        // return error
        return array( 'procesId' => $request->input( 'procesId' ), 'result' => $result );
        
    }
}