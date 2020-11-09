<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Service/Common/ApiError.php
        function:   create singleton service ApiError
 
        Last revision: 27-09-2019
 
*/

namespace App\Service\Common;

use App\Http\Base\BaseClass;

class ApiError extends BaseClass  {

    protected $debugOn = true;
    private $authentificationError = 'somethingWentWrong';
    private $dataOutOfDateError = 'dataOutOfDate';
    public function apiError( $request, $error ){
        
        // debug info 
        $this->debug( 'ApiError ApiError: ' . $error  );
        
        // create result
        $result = array( 
            'error' => $error
        );
        // create result        
        
        // return result
        return $result;
        
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

        // get ip
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
    public function dataOutOfDate( ){
        
        // debug info 
        $this->debug( 'ApiError dataOutOfDate'  );
        
        // return result
        return $this->dataOutOfDateError;
        
    }
}