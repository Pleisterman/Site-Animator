<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatePartsUpdateSequenceUp.php
        function:   
                    
        Last revision: 23-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsUpdate;
use App\SiteAnimator\Models\Site\SiteOptionsOrder;

class TemplatePartsUpdateSequenceUp extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $templatePartsRow = null;
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
        $this->debug( 'sequenceUp ' );
        
        // validate 
        $validateResult = $this->validate( $selection, $data );
        
        // has error
        if( $validateResult ){
            
            // validate updated at
            return $validateResult;

        }
        // has error
                 
        // get previous 
        $previous = SiteOptionsOrder::getPrevious( $this->database, 
                                                   $this->templatePartsRow->parent_id, 
                                                   $this->templatePartsRow->sequence,
                                                   null );
        // get previous 
        
        // row ! found
        if( !$previous ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted' );
            
        }
        // row ! found
        
        // debug info
        $this->debug( 'previous: ' . $previous->id );
        // debug info
        $this->debug( 'this: ' . $this->templatePartsRow->id );
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // temporary set sequence
        SiteOptionsUpdate::updateOptionSequence( $this->database, 
                                                 $this->templatePartsRow->id, 
                                                 null, 
                                                 $updatedAt );
        
        // temporary set sequence
        
        
        // set previous sequence
        SiteOptionsUpdate::updateOptionSequence( $this->database, 
                                                 $previous->id, 
                                                 $this->templatePartsRow->sequence, 
                                                 $updatedAt );
        
        // set previous sequence
        
        
        // set option sequence
        SiteOptionsUpdate::updateOptionSequence( $this->database, 
                                                 $this->templatePartsRow->id, 
                                                 $previous->sequence, 
                                                 $updatedAt );
        
        // set option sequence
        
        
        
        // return ok
        return array( 'ok' => 'updated id: ' . $this->templatePartsRow->id );
        
        
    }    
    public function validate( $selection, $data ) {
        
        // get template parts row
        $this->templatePartsRow = SiteOptions::getOption( $this->database, $selection['id'] );

        // row ! found
        if( !$this->templatePartsRow ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted' );
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->templatePartsRow->updated_at ); 

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
