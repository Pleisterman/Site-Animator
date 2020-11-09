<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TranslationsInsertSave.php
        function:   
                    
        Last revision: 27-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Translations;

class TranslationsInsertSave extends BaseClass {

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
    public function save( $data ){
        
        $this->debug( 'group: ' . json_decode( $data['groupId'] ) );
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // insert translation id
        $translationId = Translations::insertTranslationId( $this->database,
                                                            false,
                                                            $data,
                                                            $updatedAt );
        // insert translation id

        // loop over translations
        foreach ( $data['translations'] as $index => $translation ){

            // insert translation
            Translations::insertTranslation( $this->database,
                                             false,
                                             $translation,
                                             $translationId );
            // insert translation
            
        }
        // loop over translations
        
        // return translations id
        return array( 'translationId' => $translationId );
        
    }        
    
}
