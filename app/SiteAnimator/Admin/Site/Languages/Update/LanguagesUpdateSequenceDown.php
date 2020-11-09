<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       LanguagesUpdateSequenceDown.php
        function:   
                    
        Last revision: 23-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Languages\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Languages;
use App\SiteAnimator\Models\Site\LanguagesOrder;
use App\SiteAnimator\Models\Site\LanguagesUpdate;

class LanguagesUpdateSequenceDown extends BaseClass {

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
    public function sequenceDown( $selection, $data ){
        
        // debug info
        $this->debug( 'Languages sequenceDown' );        
        
        // validate 
        $validateResult = $this->validate( $selection, $data );
        
        // has error
        if( $validateResult ){
            
            // validate updated at
            return $validateResult;

        }
        // has error
                 
        // get next 
        $next = LanguagesOrder::getNext( $this->database, 
                                         $this->languageRow->sequence );
        // get next 
        
        // row ! found
        if( !$next ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted' );
            
        }
        // row ! found
        
        // debug info
        $this->debug( 'next: ' . $next->id );
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
                                         $next->id, 
                                         $this->languageRow->sequence, 
                                         $updatedAt );
        
        // set previous sequence        
        
        // set sequence
        LanguagesUpdate::updateSequence( $this->database, 
                                         $this->languageRow->id, 
                                         $next->sequence, 
                                         $updatedAt );
        
        // set sequence
        
        // return ok
        return array( 'ok' => 'updated id: ' . $this->languageRow->id );
                
    }    
    public function validate( $selection, $data ) {
        
        // get list row
        $this->languageRow = Languages::getLanguage( $this->database, $selection['id'] );

        // row ! found
        if( !$this->languageRow ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted' . $selection['id'] );
            
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
