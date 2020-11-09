<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TranslationsUpdateSave.php
        function:   
                    
        Last revision: 27-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Translations;

class TranslationsUpdateSave extends BaseClass {

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
    public function save( $selection, $data ){
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );

        // insert translation id
        Translations::updateTranslationId( $this->database,
                                           false,
                                           $selection,
                                           $data,
                                           $updatedAt );
        // insert translation id

        
        // loop over translations
        foreach ( $data['translations'] as $index => $translation ){

            // update translation
            Translations::updateTranslation( $this->database,
                                             false,
                                             $translation );
            // update translation
            
        }
        // loop over translations
                
        // return updated at
        return array( 'updatedAt' => $updatedAt );
    }        
    
}
