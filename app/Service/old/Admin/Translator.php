<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Service/Common/Admin/Translator.php
        function:   
  
 
        Last revision: 01-02-2019
 
*/

namespace  App\Service\Admin;

use App\Http\Base\BaseClass;
use App\Models\Admin\AdminTranslationIds;

class Translator extends BaseClass {
    
    protected $debugOn = false;
    public function getTranslations( $languageId, $subject ) {

        // debug info
        $this->debug( 'getTranslations subject: ' . $subject );
        
        // get translations
        $translations = AdminTranslationIds::getTranslations( $languageId, $subject );

        // debug info
        $this->debug( 'subject: ' . $subject . 
                      ' languageId: ' . $languageId .  
                      ' translations: ' . json_encode( $translations ) );
        // debug info
        
        // return result
        return $translations;
        
    }
    public function getErrorTranslation( $languageId, $errorId ) {

        // debug info
        $this->debug( 'getErrorTranslations errorId: ' . $errorId );
        
        // get translation
        $translation = AdminTranslationIds::getErrorTranslation( $languageId, $errorId );

        // return result
        return $translation;
        
    }
}