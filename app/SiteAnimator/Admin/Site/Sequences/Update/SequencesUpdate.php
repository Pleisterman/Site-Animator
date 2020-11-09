<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SequencesUpdate.php
        function:   
                    
        Last revision: 27-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Sequences\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Sequences\Update\SequencesPrepareUpdate;
use App\SiteAnimator\Admin\Site\Sequences\Update\SequencesUpdateSave;

class SequencesUpdate extends BaseClass {

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
        
        // construct prepare update
        $prepareUpdate = new SequencesPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct sequences save
        $sequencesSave = new SequencesUpdateSave( $this->database, $this->appCode );

        // save sequences        
        return $sequencesSave->save( $selection, $data );
        
    }
    
}
