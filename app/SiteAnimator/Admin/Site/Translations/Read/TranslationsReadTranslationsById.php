<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TranslationsReadTranslationsById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 01-10-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Translations;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Admin\Site\Translations\SiteObject\SiteObjectRead as ReadTranslation;
use App\SiteAnimator\Admin\Site\Sequences\SiteObject\SiteObjectRead as ReadSequence;
use App\SiteAnimator\Admin\Site\Css\SiteObject\SiteObjectRead as ReadCss;
use App\SiteAnimator\Admin\Site\Colors\SiteObject\SiteObjectRead as ReadColor;
use App\SiteAnimator\Admin\Site\Media\SiteObject\SiteObjectRead as ReadMedia;

class TranslationsReadTranslationsById extends BaseClass {

    protected $debugOn = true;
    protected $selection = true;
    protected $database= true;
    public function read( $database, $selection ){

        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;
        
        // debug info
        $this->debug( 'TranslationsReadList translationIds Id: ' . $selection['id'] );
        
        // get translation row
        $translationIdRow = Translations::getTranslationIdRow( $database, false, $selection['id'] );    
        
        // row ! found
        if( !$translationIdRow ){
            
            // return already deleted
            return array( 'error' => 'translation not found' );
            
        }
        // row ! found
        
        // get translaton rows
        $translationRows = Translations::getTranslationRows( $database, false, $selection['id'] );

        // create result
        return $this->createResult( $translationIdRow, $translationRows );
        
    }
    private function createResult( $translationIdRow, $translationRows ) {
        
        // create result
        return array(
            'id'            =>  $translationIdRow->id,
            'name'          =>  $translationIdRow->name,   
            'groupId'       =>  $translationIdRow->groupId,   
            'options'       =>  $this->enhanceOptions( json_decode( $translationIdRow->options, true ) ),   
            'updatedAt'     =>  $translationIdRow->updatedAt,
            'translations'  =>  $this->addTranslationsToResult( $translationRows )
        );
        // create result
        
    }
    private function addTranslationsToResult( $translationRows ) {

        // create result
        $result = array();
        
        // loop over translations
        forEach( $translationRows as $translationRow ) {

            // create translation array
            $translation = array(
                'id'            => $translationRow->id,
                'value'         => $translationRow->translation
            );
            // create translation
            
            // add to translation to array
            $result[$translationRow->languageId] = $translation;

        }
        // loop over translations        
        
        // return result
        return $result;
            
    }    
    private function enhanceOptions( $options ){
                
        // loop over options
        foreach( $options as $key => $value ) {
 
            // site object exists
            if( isset( $value['siteObject'] ) ) {
                
                // get site object
                $options[$key] = $this->getSiteObject( $value );
                
            }
            // site object exists
            
            
            // is array
            if ( is_array( $value ) ) {
                
                // call recursive
                $options[$key] = $this->enhanceOptions( $options[$key] );
                
            }
            // is array
            
        }
        // loop over options        
        
        // return result       
        return $options;
        
    }
    private function getSiteObject( $options ){
        
        // is translation
        if( isset( $options['translation'] ) ){
        
            // create read
            $readTranslation = new ReadTranslation( $this->database );
            
            // read translation
            $options = $readTranslation->read( $options );
            
        }
        // is translation

        // is color
        if( isset( $options['color'] ) ){
        
            // create read
            $readColor = new ReadColor( $this->database );
            
            // read color
            $options = $readColor->read( $options );
            
        }
        // is color
        
        // is css
        if( isset( $options['css'] ) ){
        
            // create read
            $readCss = new ReadCss( $this->database );
            
            // read css
            $options = $readCss->read( $options );
            
        }
        // is css
        
        // is media
        if( isset( $options['media'] ) ){
        
            // create read
            $readMedia = new ReadMedia( $this->database );
            
            // read media
            $options = $readMedia->read( $options );
            
        }
        // is media
        
        // is sequence
        if( isset( $options['sequence'] ) ){
        
            // create read
            $readSequence = new ReadSequence( $this->database );
            
            // read sequence
            $options = $readSequence->read( $options );
            
        }
        // is sequence
        
        
        // return result
        return $options;
        
    }
    private function getSiteItemId( $pagePartsRow, $pagePart ){
        
        // create result 
        $result = null;
        
        // ! is template
        if( $pagePartsRow->is_template == 0 ){
        
            // get site item
            $siteItem = SiteItems::getSiteItemPart( $this->database, $pagePart->id );

            // set result
            $result = $siteItem->id;
            
        }
        // ! is template
        
        // return result;
        return $result;
        
    }

}
