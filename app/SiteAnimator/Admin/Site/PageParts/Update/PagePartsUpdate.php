<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsUpdate.php
        function:   
                    
        Last revision: 24-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\PageParts\Update\PagePartsPrepareUpdate;
use App\SiteAnimator\Admin\Site\PageParts\Update\PagePartsUpdateSave;
use App\SiteAnimator\Admin\Site\PageParts\Update\PagePartsUpdateSequenceUp;
use App\SiteAnimator\Admin\Site\PageParts\Update\PagePartsUpdateSequenceDown;

class PagePartsUpdate extends BaseClass {

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
                $this->debug( 'PagePartsUpdate error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
            
        }
        // choose what
                        
    }
    private function updateRow( $selection, $data ){
        
        // construct prepare update
        $prepareUpdate = new PagePartsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct save
        $save = new PagePartsUpdateSave( $this->database, $this->appCode );

        // save        
        return $save->save( $selection, $data );
        
    }
    private function sequenceUp( $selection, $data ){
        
        // construct sequence update up
        $sequenceUpdateUp = new PagePartsUpdateSequenceUp( $this->database, $this->appCode );

        // sequence up        
        return $sequenceUpdateUp->sequenceUp( $selection, $data );
        
    }
    private function sequenceDown( $selection, $data ){
        
        // construct sequence update down
        $sequenceUpdateDown = new PagePartsUpdateSequenceDown( $this->database, $this->appCode );

        // sequence up        
        return $sequenceUpdateDown->sequenceDown( $selection, $data );
        
    }
    
}
