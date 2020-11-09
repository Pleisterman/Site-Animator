<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsUpdateSequenceUp.php
        function:   
                    
        Last revision: 06-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteListsOrder;
use App\SiteAnimator\Models\Site\SiteOptionsUpdate;

class ListsUpdateSequenceUp extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $listRow = null;
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
        $this->debug( 'Lists sequenceUp ' );
                
        // validate 
        $validateResult = $this->validate( $selection, $data );
        
        // has error
        if( $validateResult ){
            
            // validate updated at
            return $validateResult;

        }
        // has error

        // debug info
        $this->debug( 'parentId: ' . $this->listRow->parent_id );
        // debug info
        $this->debug( 'sequence: ' . $this->listRow->sequence );                
        // debug info
        $this->debug( 'type: ' . $this->listRow->type );
        
        
        // get previous 
        $previous = SiteListsOrder::getPrevious( $this->database, 
                                                 $this->listRow->parent_id, 
                                                 $this->listRow->sequence );
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
        $this->debug( 'this: ' . $this->listRow->id );                
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // temporary set sequence
        SiteOptionsUpdate::updateOptionSequence( $this->database, 
                                                 $this->listRow->id, 
                                                 null, 
                                                 $updatedAt );
        
        // temporary set sequence
                
        // set previous sequence
        SiteOptionsUpdate::updateOptionSequence( $this->database, 
                                                 $previous->id, 
                                                 $this->listRow->sequence, 
                                                 $updatedAt );
        
        // set previous sequence
                
        // set option sequence
        SiteOptionsUpdate::updateOptionSequence( $this->database, 
                                                $this->listRow->id, 
                                                $previous->sequence, 
                                                $updatedAt,
                                                $this->debugger );
        
        // set option sequence
        
        // return ok
        return array( 'ok' => 'updated id: ' . $this->listRow->id );
                
    }    
    public function validate( $selection, $data ) {
        
        // get row
        $this->listRow = SiteOptions::getOption( $this->database, $selection['id'] );

        // row ! found
        if( !$this->listRow ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted id: ' . $selection['id'] );
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->listRow->updated_at ); 

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
