<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TranslationsUpdate.php
        function:   
                    
        Last revision: 27-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Translations\Update\TranslationsPrepareUpdate;
use App\SiteAnimator\Admin\Site\Translations\Update\TranslationsUpdateSave;

class TranslationsUpdate extends BaseClass {

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
        $prepareUpdate = new TranslationsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct translations save
        $translationsSave = new TranslationsUpdateSave( $this->database, $this->appCode );

        // save translations        
        return $translationsSave->save( $selection, $data );
        
    }
    
}
