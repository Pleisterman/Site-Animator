<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesUpdate.php
        function:   
                    
        Last revision: 22-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Templates\Update\TemplatesPrepareUpdate;
use App\SiteAnimator\Admin\Site\Templates\Update\TemplatesUpdateSave;
use App\SiteAnimator\Admin\Site\Templates\Update\TemplatePartsPrepareUpdate;
use App\SiteAnimator\Admin\Site\Templates\Update\TemplatePartsUpdateSave;
use App\SiteAnimator\Admin\Site\Templates\Update\TemplatePartsUpdateSequenceUp;
use App\SiteAnimator\Admin\Site\Templates\Update\TemplatePartsUpdateSequenceDown;

class TemplatesUpdate extends BaseClass {

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

                // type is template / else
                if( $data['type'] == 'template' ){

                    // update template
                    return $this->updateTemplate( $selection, $data );
            
                }
                else {

                    // update template part
                    return $this->updateTemplatePart( $selection, $data );

                }
                // type is template / else
                
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
                $this->debug( 'TemplatesUpdate error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
            
        }
        // choose what
        
    }        
    private function updateTemplate( $selection, $data ) {

        // construct prepare update
        $prepareUpdate = new TemplatesPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct update save
        $updateSave = new TemplatesUpdateSave( $this->database, $this->appCode );

        // save         
        return $updateSave->save( $selection, $data );
        
    }
    private function updateTemplatePart( $selection, $data ) {

        // construct prepare update
        $prepareUpdate = new TemplatePartsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct update save
        $updateSave = new TemplatePartsUpdateSave( $this->database, $this->appCode );

        // save         
        return $updateSave->save( $selection, $data );
        
    }
    private function sequenceUp( $selection, $data ){
        
        // construct sequence update up
        $sequenceUpdateUp = new TemplatePartsUpdateSequenceUp( $this->database, $this->appCode );

        // sequence up        
        return $sequenceUpdateUp->sequenceUp( $selection, $data );
        
    }
    private function sequenceDown( $selection, $data ){
        
        // construct sequence update down
        $sequenceUpdateDown = new TemplatePartsUpdateSequenceDown( $this->database, $this->appCode );

        // sequence up        
        return $sequenceUpdateDown->sequenceDown( $selection, $data );
        
    }
    
}
