<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatePartsPrepareUpdate.php
        function:   
                    
        Last revision: 22-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsUpdate;

class TemplatePartsPrepareUpdate extends BaseClass {

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
        
        // get part row
        $partRow = SiteOptions::getOption( $this->database, $selection['id'] );

        // row ! found
        if( !$partRow ){
            
            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'alreadyDeleted';
            
            // dobe
            return;
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $partRow->updated_at ); 

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

        // get part name and group with other id exists
        $nameExists = SiteOptionsUpdate::optionsWithoutIdWithParentIdAndNameExists( $this->database, 
                                                                                    $selection['id'], 
                                                                                    $data['parentId'], 
                                                                                    $data['name'] );
        // get part name and group with other id exists

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
