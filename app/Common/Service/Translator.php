<?php

/*
        @package    Pleisterman/Common
  
        file:       Translator.php
        function:   
  
 
        Last revision: 19-01-2020
 
*/
    
namespace App\Common\Service;

use App\Http\Base\BaseClass;
use App\Common\Models\Site\Routes;
use App\Common\Models\Translations;

class Translator extends BaseClass {
    
    protected $debugOn = false;
    private $database = null;
    private $isAdmin = false;
    private $textTranslations = array();
    private $newTranslations = array();
    public function __construct( $request ) {
        
        // call parent
        parent::__construct();
        
        // get request action
        $action = $request->route()->getAction();
        
        // set database
        $this->database = $action['database'];
        
        // set admin
        $this->isAdmin = $action['isAdmin'];
        
    }
    public function getLanguageRoutes( $request, $route ) {

        // debug info
        $this->debug( 'translator getLanguageRoutes' );

        // get site languages
        $languages = $request->attributes->get( 'siteLanguages' );

        // translate language route
        return Routes::getlanguageRoutes( $this->database, $languages, $route );
        
    }
    public function getTextTranslations( $request ) {

        // debug info
        $this->debug( 'getTextTranslations' );
        
        // get languageId
        $languageId = $request->attributes->get( 'siteLanguageId' );

        // get new translations
        $this->newTranslations = Translations::getTranslationsByTypeAndLanguage( $this->database, false, $languageId, 'text' );

        // get text translations
        $this->textTranslations = Translations::getTranslationsByTypeAndLanguage( $this->database, false, $languageId, 'text' );
        
        // get index translations
 //       $indexTranslations = Translations::getTranslationsByType( $this->database, false, $languageId, 'index' );
        
        // add index translations to request
  //      $request->attributes->set( 'siteTranslations', $indexTranslations );
        
        // debug info
  //      $this->debug( 'languageId: ' . $languageId );
        // debug info
 //       $this->debug( 'index translations: ' . json_encode( $indexTranslations ) );
        
    }
    public function getTranslationsByType( $type ) {

        // debug info
        $this->debug( 'getTranslationsByType' );
        
        // return index translations
        return Translations::getTranslationsByType( $this->database, $this->isAdmin, $type );
        
    }
    public function translateBlogText( $languageId, $json ) {

        // debug info
        $this->debug( 'translateBlogText' );
        
        // loop over json
        foreach( $json as $key => $value ) {
 
            // create translation
            $translation = null;   
            
            // translationId exists and blogText exists
            if( isset( $value['translationId'] ) && 
                isset( $value['blogText'] ) ) {

                // debug info
                $this->debug( 'find BlogText: ' . $value['translationId'] );
                // debug info
                $this->debug( 'find siteLanguageId: ' . $languageId );
                
                // get translation
                $translation = Translations::getTranslationsByTypeAndLanguage( $this->database, 
                                                                               false,
                                                                               $languageId,
                                                                               'blogText',
                                                                               array( $value['translationId'] ) );
                // get translation
                
            }
            else if( isset( $value['translationId'] ) ) {

                // debug info
                $this->debug( 'find text: ' . $value['translationId'] );

                // get translation
                $translation = Translations::getTranslationsByTypeAndLanguage( $this->database, 
                                                                               false,
                                                                               $languageId,
                                                                               'text',
                                                                               array( $value['translationId'] ) );
                // get translation
                
            }
            // translationId exists and blogText exists

            // translation exusts
            if( $translation && isset( $translation[$value['translationId']] ) ){

                // replace line returns
                $translation[$value['translationId']] = str_replace( "\n", '<br>', $translation[$value['translationId']] );
                
                // set translation
                $json[$key]['text'] = $translation[$value['translationId']];
                
                // debug info
                $this->debug( 'set blogText translation id: ' . $value['translationId'] . ' translation: ' . $translation[$value['translationId']] );
                
            }
            // translation exusts
            
        }
        // loop over json
        
        // return result
        return $json;
        
    }
    public function translate( $languageId, $json ) {
                
        // debug info
        $this->debug( 'translate ' . json_encode($json) );
                
        // loop over json
        foreach( $json as $key => $value ) {

            // new translationId exists and text exists and text translation exists
            if( isset( $value['newTranslationId'] ) && 
                isset( $value['text'] ) && 
                isset( $this->newTranslations[$value['newTranslationId']] ) ) {
            
                // set translation
                $json[$key]['text'] = $this->newTranslations[$value['newTranslationId']]['translation'];
                $this->debug( 'set text translation id: ' . $value['newTranslationId'] );
                // debug info
                $this->debug( 'translate result: ' . json_encode($json));
                
            }
            // new translationId exists and text exists and text translation exists
                
            // translationId exists and text exists and text translation exists
            if( isset( $value['translationId'] ) && 
                isset( $value['text'] ) && 
                isset( $this->textTranslations[$value['translationId']] ) ) {
                
                // set translation
                $json[$key]['text'] = $this->textTranslations[$value['translationId']];
                $this->debug( 'set text translation id: ' . $value['translationId'] . ' translation: ' . $this->textTranslations[$value['translationId']] );
                // debug info
                $this->debug( 'translate result: ' . json_encode($json));
                
            }
            // translationId exists and text exists and text translation exists

            // route exists and route translation exists
            if( isset( $value['route'] ) ) {
                
                // translate page route
                $json[$key]['route'] = Routes::getRouteTranslation( $this->database, $languageId, $value['route'] );
                
            }
            // route exists and route translation exists
            
            // is array
            if ( is_array( $value ) ) {
                // call recusrsive
                $json[$key] = $this->translate( $languageId, $json[$key] );
            }
            // is array
            
        }
        // loop over json
        
        // return result
        return $json;
        
    }
    
}