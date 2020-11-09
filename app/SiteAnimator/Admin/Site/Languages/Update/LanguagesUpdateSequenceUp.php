<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       LanguagesUpdateSequenceUp.php
        function:   
                    
        Last revision: 23-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Languages\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Languages;
use App\SiteAnimator\Models\Site\LanguagesOrder;
use App\SiteAnimator\Models\Site\LanguagesUpdate;

class LanguagesUpdateSequenceUp extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $languageRow = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function sequenceUp( $selection, $data ){
        
        // debug info
        $this->debug( 'Languages sequenceUp ' );
                
        // validate 
        $validateResult = $this->validate( $selection, $data );
        
        // has error
        if( $validateResult ){
            
            // validate updated at
            return $validateResult;

        }
        // has error

        // debug info
        $this->debug( 'parentId: ' . $this->languageRow->parent_id );
        // debug info
        $this->debug( 'sequence: ' . $this->languageRow->sequence );                
        
        
        // get previous 
        $previous = LanguagesOrder::getPrevious( $this->database, 
                                                 $this->languageRow->sequence );
        // get previous 
        
        // row ! found
        if( !$previous ){
                        
            // handle error
            return $this->handleError( 'previous alreadyDeleted' );
            
        }
        // row ! found
        
        // debug info
        $this->debug( 'previous: ' . $previous->id );
        // debug info
        $this->debug( 'this: ' . $this->languageRow->id );                
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // temporary set sequence
        LanguagesUpdate::updateSequence( $this->database, 
                                         $this->languageRow->id, 
                                         null, 
                                         $updatedAt );
        
        // temporary set sequence
                
        // set previous sequence
        LanguagesUpdate::updateSequence( $this->database, 
                                         $previous->id, 
                                         $this->languageRow->sequence, 
                                         $updatedAt );
        
        // set previous sequence
                
        // set option sequence
        LanguagesUpdate::updateSequence( $this->database, 
                                         $this->languageRow->sequence, 
                                         $previous->sequence, 
                                         $updatedAt,
                                         $this->debugger );
        
        // set option sequence
        
        // return ok
        return array( 'ok' => 'updated id: ' . $this->languageRow->id );
                
    }    
    public function validate( $selection, $data ) {
        
        // get row
        $this->languageRow = Languages::getLanguage( $this->database, $selection['id'] );

        // row ! found
        if( !$this->languageRow ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted id: ' . $selection['id'] );
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->languageRow->updated_at ); 

        // get data date
        $dataDate = \DateTime::createFromFormat( 'Y-m-d H:i:s', $data['updatedAt'] ); 

        // updated at ! updated at
        if( $date != $dataDate ){

            // handle error
            return $this->handleError( 'dataOutOfDate' );
            
        }
        // updated at ! updated at
        
    }
    private function handleError( $error ){
        
        // create and return error
        return array(
            'error'         =>   $error
        );
        // create error

    }

}
