<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       AnimationsPrepareInsert.php
        function:   
                    
        Last revision: 10-08-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Animations\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionsInsert;

class AnimationsPrepareInsert extends BaseClass {

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
        
        // validate name
        $this->validateName( $data );
        
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
    private function validateName( $data ) {

        // get animaiton name and group exists
        $nameExists = SiteOptionsInsert::optionsWithParentIdAndTypeAndNameExists( $this->database, 
                                                                                  $data['parentId'], 
                                                                                  'animaiton', 
                                                                                  $data['name'] );
        // get animaiton name and group exists

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
