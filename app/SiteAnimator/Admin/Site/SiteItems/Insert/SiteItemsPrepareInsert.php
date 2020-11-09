<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsPrepareInsert.php
        function:   
                    
        Last revision: 09-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;

class SiteItemsPrepareInsert extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $hasError = null;
    private $error = null;
    private $errorObject = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function prepareInsert( $data ){
        
        // reset has error
        $this->hasError = false;
        
        // validate type
        $this->validateType( $data );
        
        // has error
        if( $this->hasError ){
            
            // create error
            $error = array(
                'error'         =>   $this->error,
                'errorObject'   =>   $this->errorObject
            );
            // create error
            
            // return error
            return $error;
            
        }
        // has error      
        
    }
    private function validateType( $data ) {

        // get site item type and group exists
        $typeExists = SiteItems::siteItemWithGroupIdAndTypeExists( $this->database, 
                                                                   $data['groupId'], 
                                                                   $data['type'] );
        // get site item type and group exists

        // type exists    
        if( $typeExists ){
            
            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'typeExists';
                
            // set error object
            $this->errorObject = 'type';
            
        }
        // type exists    

    }
    
}
