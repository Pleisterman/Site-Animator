<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsUpdateSequenceDown.php
        function:   
                    
        Last revision: 24-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\PageParts;
use App\SiteAnimator\Models\Site\PagePartsOrder;

class PagePartsUpdateSequenceDown extends BaseClass {

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
    public function sequenceDown( $selection, $data ){
        
        // debug info
        $this->debug( 'sequenceDown' );        
        
        // validate 
        $validateResult = $this->validate( $selection, $data );
        
        // has error
        if( $validateResult ){
            
            // validate updated at
            return $validateResult;

        }
        // has error
                 
        // get next 
        $next = PagePartsOrder::getNext( $this->database, 
                                         $selection['routeId'], 
                                         $this->pagePartsRow->parent_id, 
                                         $this->pagePartsRow->sequence );
        // get next 
        
        // row ! found
        if( !$next ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted' );
            
        }
        // row ! found
        
        // debug info
        $this->debug( 'previous: ' . $next->id );
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
                                           $next->id, 
                                           $this->pagePartsRow->sequence, 
                                           $updatedAt,
                                           $this->debugger );
        
        // set previous sequence
        
        
        // set page part sequence
        PageParts::updatePagePartSequence( $this->database, 
                                           $this->pagePartsRow->id, 
                                           $next->sequence, 
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
