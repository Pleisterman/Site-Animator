<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesPrepareInsert.php
        function:   
                    
        Last revision: 22-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\PageParts;

class PagePartsPrepareInsert extends BaseClass {

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

        // get page part name and parent exists
        $nameExists = PageParts::nameExists( $this->database, 
                                             $data['routeId'], 
                                             $data['name'],
                                             $data['parentId'] );
        // get page part name and parent exists

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
