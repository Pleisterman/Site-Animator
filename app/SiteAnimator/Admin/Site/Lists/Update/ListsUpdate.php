<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsUpdate.php
        function:   
                    
        Last revision: 05-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Lists\Update\ListsPrepareUpdate;
use App\SiteAnimator\Admin\Site\Lists\Update\ListsUpdateSave;
use App\SiteAnimator\Admin\Site\Lists\Update\ListsUpdateSequenceUp;
use App\SiteAnimator\Admin\Site\Lists\Update\ListsUpdateSequenceDown;

class ListsUpdate extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function update( $selection, $data ){
        
        // choose what
        switch ( $selection['what'] ) {
        
            // row by id
            case 'rowById': {

                // update row
                return $this->updateRow( $selection, $data );
                
            }
            // sequence up
            case 'sequenceUp': {

                // sequence up
                return $this->sequenceUp( $selection, $data );
                
            }
            // sequence down
            case 'sequenceDown': {

                // sequence down
                return $this->sequenceDown( $selection, $data );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'ListsUpdate error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
            
        }
        // choose what
    }
    public function updateRow( $selection, $data ){
        
        // construct prepare update
        $prepareUpdate = new ListsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct list item save
        $listItemSave = new ListsUpdateSave( $this->database, $this->appCode );

        // save list item        
        return $listItemSave->save( $selection, $data );
        
    }
    private function sequenceUp( $selection, $data ){
        
        // construct sequence update up
        $sequenceUpdateUp = new ListsUpdateSequenceUp( $this->database, $this->appCode );

        // sequence up        
        return $sequenceUpdateUp->sequenceUp( $selection, $data );
        
    }
    private function sequenceDown( $selection, $data ){
        
        // construct sequence update down
        $sequenceUpdateDown = new ListsUpdateSequenceDown( $this->database, $this->appCode );

        // sequence up        
        return $sequenceUpdateDown->sequenceDown( $selection, $data );
        
    }
    
}
