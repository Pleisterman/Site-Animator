<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       LanguagesUpdate.php
        function:   
                    
        Last revision: 23-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Languages\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Languages\Update\LanguagesPrepareUpdate;
use App\SiteAnimator\Admin\Site\Languages\Update\LanguagesUpdateSave;
use App\SiteAnimator\Admin\Site\Languages\Update\LanguagesUpdateSequenceUp;
use App\SiteAnimator\Admin\Site\Languages\Update\LanguagesUpdateSequenceDown;

class LanguagesUpdate extends BaseClass {

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
                $this->debug( 'LanguagesUpdate error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
            
        }
        // choose what
                        
    }
    private function updateRow( $selection, $data ){
        
        // construct prepare update
        $prepareUpdate = new LanguagesPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct save
        $save = new LanguagesUpdateSave( $this->database, $this->appCode );

        // save        
        return $save->save( $selection, $data );
        
    }
    private function sequenceUp( $selection, $data ){
        
        // construct sequence update up
        $sequenceUpdateUp = new LanguagesUpdateSequenceUp( $this->database, $this->appCode );

        // sequence up        
        return $sequenceUpdateUp->sequenceUp( $selection, $data );
        
    }
    private function sequenceDown( $selection, $data ){
        
        // construct sequence update down
        $sequenceUpdateDown = new LanguagesUpdateSequenceDown( $this->database, $this->appCode );

        // sequence up        
        return $sequenceUpdateDown->sequenceDown( $selection, $data );
        
    }
    
}
