<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatePartsUpdateSequenceDown.php
        function:   
                    
        Last revision: 23-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsUpdate;
use App\SiteAnimator\Models\Site\SiteOptionsOrder;

class TemplatePartsUpdateSequenceDown extends BaseClass {

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
    public function sequenceDown( $selection, $data ){
        
        // debug info
        $this->debug( 'sequenceDown ' );        
        
        // validate 
        $validateResult = $this->validate( $selection, $data );
        
        // has error
        if( $validateResult ){
            
            // validate updated at
            return $validateResult;

        }
        // has error
                 
        // get next 
        $next = SiteOptionsOrder::getNext( $this->database, 
                                           $this->templatePartsRow->parent_id, 
                                           $this->templatePartsRow->sequence,
                                           null );
        // get next 
        
        // row ! found
        if( !$next ){
            
        // debug info
        $this->debug( 'alreadyDeleted' );        
        
            // handle error
            return $this->handleError( 'alreadyDeleted' );
            
        }
        // row ! found
        
        // debug info
        $this->debug( 'next: ' . $next->id );
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
                                                 $next->id, 
                                                 $this->templatePartsRow->sequence, 
                                                 $updatedAt );
        
        // set previous sequence
        
        
        // set option sequence
        SiteOptionsUpdate::updateOptionSequence( $this->database, 
                                                 $this->templatePartsRow->id, 
                                                 $next->sequence, 
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
