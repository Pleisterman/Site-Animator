<?php

/*
        @package    Pleisterman/Common
  
        file:       DataError.php
        function:   create singleton service DataError
 
        Last revision: 03-03-2020
 
*/

namespace App\Common\Service;

use App\Common\Base\BaseClass;

class DataError extends BaseClass  {

    protected $debugOn = true;
    private $defaultError = 'dataError';
    private $outOfDateError = 'dataOutOfDate';
    private $dataNotFoundError = 'dataNotFound';
    public function error( ){
        
        // debug info 
        $this->debug( 'DataError error'  );

        // return error
        return $this->handleError( $this->defaultError );
        
    }
    public function dataOutOfDate( ){
        
        // debug info 
        $this->debug( 'DataError DataOutOfDate '  );
        
        // return error
        return $this->handleError( $this->outOfDateError );
        
    }
    public function dataNotFound( $message ){

        // return error
        return $this->handleError( $this->dataNotFoundError, $message );
        
    }
    private function handleError( $error, $message = null ){
    
        // get message
        $message = $message != null ? ' message: ' . $message : '';
        
        // log error
        $this->debug( 'dataError ' . $error . $message );


        // get request
        $request = request();
        
        // is ajax
        if( $request->ajax() ){
            
            // return api error
            return $this->returnApiError( $request, $error );
            
        }
        // is ajax

        // return web error
        return $this->returnWebError( $request );
        
    }
    private function returnApiError( $request, $error ){
        
        // debug info 
        $this->debug( 'api error' );

        // create result
        $result = array( 
            'error' => $error
        );
        // create result        

        // return error
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
            
    }
    private function returnWebError( ){
        
        // debug info 
        $this->debug( 'web error: ' );
        
        // get request
        $request = request();
        
        // get request action
        $action = $request->route()->getAction();
       
        // get redirect to site
        $redirectToSite = isset( $action['redirectToSite'] ) ? $action['redirectToSite'] : 'error';
        
        // return result
        return redirect()->route( $redirectToSite );
        
    }
}