<?php

/*
        @package    Pleisterman\CodeAnalyser
  
        file:       Translations.php
        function:   
                    
        Last revision: 19-12-2019
 
*/

namespace App\Common\Admin\Translations;

use App\Common\Base\BaseClass;
use App\Common\Models\Translations as AdminTranslations;

class Translations extends BaseClass {

    protected $debugOn = true;
    private $database = 'none';
    public function read( $database, $selection ){
        
        // debug info
        $this->debug( 'Admin Translations get translation ' );

        // remember database
        $this->database = $database;

        // type ! exists
        if( !isset( $selection['type'] ) ){
            
            // return with error
            return array( 'criticalError', 'typeNotSet' );
            
        }
        // type ! exists
        
        // language id ! exists
        if( !isset( $selection['languageId'] ) ){
            
            // return with error
            return array( 'criticalError', 'languageNotSet' );
            
        }
        // language id ! exists

        // create translation ids
        $translationIds = isset( $selection['translationIds'] ) ? $selection['translationIds'] : null;
        
        // get translations
        $translations = AdminTranslations::getTranslationsByTypeAndLanguage( $this->database,
                                                                             'true',  
                                                                             $selection['languageId'], 
                                                                             $selection['type'], 
                                                                             $translationIds );
        // get translations

        
        // return result
        return $translations;
        
    }
    
}
