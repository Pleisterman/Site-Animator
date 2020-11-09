<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesPrepareInsert.php
        function:   
                    
        Last revision: 14-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsInsert;

class TemplatesPrepareInsert extends BaseClass {

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
        
        // validate pert updated at
        $this->validatePartUpdatedAt( $data );
        
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
    private function validatePartUpdatedAt( $data ) {
        
        // get template row
        $partRow = SiteOptions::getOption( $this->database, $data['partId'] );

        // row ! found
        if( !$partRow ){
            
            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'alreadyDeleted';
            
            // done
            return;
            
        }
        // row ! found
        
    }
    private function validateName( $data ) {

        // get template name and group exists
        $nameExists = SiteOptionsInsert::optionsWithParentIdAndTypeAndNameExists( $this->database, 
                                                                                  $data['parentId'], 
                                                                                  'template', 
                                                                                  $data['name'] );
        // get template name and group exists

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
