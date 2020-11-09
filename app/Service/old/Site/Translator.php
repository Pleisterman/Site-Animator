<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Service/Common/Site/Translator.php
        function:   
  
 
        Last revision: 27-09-2019
 
*/
    
namespace App\Service\Site;

use App\Http\Base\BaseClass;
use App\Models\Site\SitePages;
use App\Models\Site\SiteTranslationIds;

class Translator extends BaseClass {
    
    protected $debugOn = false;
    private $database = array();
    private $isAdmin = array();
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
    public function getLanguageRoutes( $languages, $route ) {

        // debug info
        $this->debug( 'translator getLanguageRoutes' );

        // translate page route
        return SitePages::getlanguageRoutes( $languages, $route );
        
    }
    public function getTextTranslations( $request ) {

        // debug info
        $this->debug( 'getTextTranslations' );
        
        // get languageId
        $languageId = $request->attributes->get( 'siteLanguageId' );

        // get new translations
        $this->newTranslations = SiteTranslationIds::getNewTranslations( $languageId );
        

        // get text translations
        $this->textTranslations = SiteTranslationIds::getTextTranslations( $languageId );
        
        // get index translations
       // $indexTranslations = SiteTranslationIds::getIndexTranslations( );
        
        // add index translations to request
        //$request->attributes->set( 'siteTranslations', $indexTranslations );
        
        // debug info
    //    $this->debug( 'languageId: ' . $languageId );
        // debug info
  ///      $this->debug( 'index translations: ' . json_encode( $indexTranslations ) );
        
    }
    public function translateBlogText( $siteLanguageId, $json ) {

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
                $this->debug( 'find siteLanguageId: ' . $siteLanguageId );
        
                
                // get translation
                $translation = SiteTranslationIds::translate( $value['translationId'], 'blogText', $siteLanguageId );
                
            }
            else if( isset( $value['translationId'] ) ) {

                // debug info
                $this->debug( 'find text: ' . $value['translationId'] );

                // get translation
                $translation = SiteTranslationIds::translate( $value['translationId'], 'text', $siteLanguageId );
                
            }
            // translationId exists and blogText exists

            // translation exusts
            if( $translation ){

                // replace line returns
                $translation->translation = str_replace( "\n", '<br>', $translation->translation );
                
                // set translation
                $json[$key]['text'] = $translation->translation;
                
                // debug info
                $this->debug( 'set blogText translation id: ' . $value['translationId'] . ' translation: ' . $translation->translation );
                
            }
            // translation exusts
            
        }
        // loop over json
        
        // return result
        return $json;
        
    }
    public function translate( $siteLanguageId, $json ) {
                
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
                $json[$key]['route'] = SitePages::getRouteTranslation( $siteLanguageId, $value['route'] );
                
            }
            // route exists and route translation exists
            
            // is array
            if ( is_array( $value ) ) {
                // call recusrsive
                $json[$key] = $this->translate( $siteLanguageId, $json[$key] );
            }
            // is array
            
        }
        // loop over json
        
        // return result
        return $json;
        
    }
    
}