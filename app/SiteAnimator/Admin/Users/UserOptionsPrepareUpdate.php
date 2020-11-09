<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       UserOptionsPrepareUpdate.php
        function:   
                    
        Last revision: 17-02-2020
 
*/

namespace App\SiteAnimator\Admin\Users;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Admin\UserOptions;

class UserOptionsPrepareUpdate extends BaseClass {

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
    public function prepareUpdate( $data ){
        
        // reset has error
        $this->hasError = false;
        
        // validate updated at
        !$this->validateUpdatedAt( $data );
        
        // has error
        if( $this->hasError ){
            
            // create error
            $error = array(
                'error'         =>   $this->error
            );

            // return error
            return $error;
            
        }
        // has error
        
    }
    private function validateUpdatedAt( $data ) {
        
        // loop over data
        for( $i = 0; $i < count( $data ); $i++ ){

            $this->debug( 'validate user options' .  $data[$i]['id'] );
                
            // get user option
            $userOption = UserOptions::getUserOptionById( $this->database, $data[$i]['id'] ); 
            
            // get date
            $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $userOption->updatedAt ); 
            
            // get data date
            $dataDate = \DateTime::createFromFormat( 'Y-m-d H:i:s', $data[$i]['updatedAt'] ); 
            
            // updated at ! updated at
            if( $date != $dataDate ){

                // set has error
                $this->hasError = true;
                
                // set error
                $this->error = 'dataOutOfDate';
                
                // set error option id
                $this->errorOptionId = $data[$i]['id'];
                
                // done
                return;
                
            }
            // updated at ! updated at
            
        }
        // loop over data
        
    }
    
}
