<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsUpdateSequenceUp.php
        function:   
                    
        Last revision: 24-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\PageParts;
use App\SiteAnimator\Models\Site\PagePartsOrder;

class PagePartsUpdateSequenceUp extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $pagePartsRow = null;
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
        $previous = PagePartsOrder::getPrevious( $this->database, 
                                                 $selection['routeId'], 
                                                 $this->pagePartsRow->parent_id, 
                                                 $this->pagePartsRow->sequence );
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
        $this->debug( 'this: ' . $this->pagePartsRow->id );
        
        
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // temporary set sequence
        PageParts::updatePagePartSequence( $this->database, 
                                           $this->pagePartsRow->id, 
                                           null, 
                                           $updatedAt,
                                           $this->debugger );
        
        // temporary set sequence
        
        
        // set previous sequence
        PageParts::updatePagePartSequence( $this->database, 
                                           $previous->id, 
                                           $this->pagePartsRow->sequence, 
                                           $updatedAt,
                                           $this->debugger );
        
        // set previous sequence
        
        
        // set page part sequence
        PageParts::updatePagePartSequence( $this->database, 
                                           $this->pagePartsRow->id, 
                                           $previous->sequence, 
                                           $updatedAt,
                                           $this->debugger );
        
        // set page part sequence
        
        
        
        // return ok
        return array( 'ok' => 'updated id: ' . $this->pagePartsRow->id );
        
        
    }    
    public function validate( $selection, $data ) {
        
        // get page parts row
        $this->pagePartsRow = SiteOptions::getOption( $this->database, $selection['id'] );

        // row ! found
        if( !$this->pagePartsRow ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted' );
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->pagePartsRow->updated_at ); 

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
