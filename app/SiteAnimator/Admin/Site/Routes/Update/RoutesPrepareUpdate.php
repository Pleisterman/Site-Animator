<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesPrepareUpdate.php
        function:   
                    
        Last revision: 04-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Routes;

class RoutesPrepareUpdate extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $hasError = null;
    private $error = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function prepareUpdate( $selection, $data ){
        
        // reset has error
        $this->hasError = false;
        
        // validate updated at
        $this->validateUpdatedAt( $selection, $data );
        
        // ! has error
        if( !$this->hasError ){
            
            // validate name
            $this->validateName( $selection, $data );

        }
        // ! has error
        
        // has error
        if( $this->hasError ){
            
            // create error
            $error = array(
                'error'         =>   $this->error
            );
            // create error
            
            // return error
            return $error;
            
        }
        // has error      
        
    }
    private function validateUpdatedAt( $selection, $data ) {
        
        // get route row
        $routeRow = Routes::getRouteById( $this->database, $selection['id'] );

        // row ! found
        if( !$routeRow ){
            
            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'alreadyDeleted';
            
            // dobe
            return;
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $routeRow->updated_at ); 

        // get data date
        $dataDate = \DateTime::createFromFormat( 'Y-m-d H:i:s', $data['updatedAt'] ); 

        // updated at ! updated at
        if( $date != $dataDate ){

            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'dataOutOfDate';

            // done
            return;

        }
        // updated at ! updated at
        
        
        
    }
    private function validateName( $selection, $data ) {

        // get route name and group with other id exists
        $nameExists = Routes::routeWithoutIdWithGroupIdAndNameExists( $this->database, 
                                                                      $selection['id'], 
                                                                      $data['groupId'], 
                                                                      $data['name'] );
        // get route name and group with other id exists

        // name exists    
        if( $nameExists ){
            
            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'nameExists';
                
            // set error object
            $this->errorObject = 'name';
            
        }
        // name exists    

    }
    
}
