<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsPrepareUpdate.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;

class SiteItemsPrepareUpdate extends BaseClass {

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
            $this->validateType( $selection, $data );

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
        
        // get row
        $row = SiteItems::getRow( $this->database, $selection['id'] );

        // row ! found
        if( !$row ){
            
            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'alreadyDeleted';
            
            // dobe
            return;
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $row->updated_at ); 

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
    private function validateType( $selection, $data ) {

        // get type and group with other id exists
        $typeExists = SiteItems::itemsWithoutIdWithGroupIdAndTypeExists( $this->database, 
                                                                         $selection['id'], 
                                                                         $data['groupId'], 
                                                                         $data['type'] );
        // get type and group with other id exists

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
