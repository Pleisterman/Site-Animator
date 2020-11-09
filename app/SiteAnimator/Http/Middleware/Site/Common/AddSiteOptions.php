<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddSiteOptions.php
        function:   
                    
        Last revision: 03-05-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site\Common;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Http\Middleware\Site\Common\AddListGroup;
use App\SiteAnimator\Models\Site\Routes;
use App\SiteAnimator\Models\Site\Translations;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Media\Read\MediaReadMediaById;
use App\SiteAnimator\Admin\Site\Animations\Read\AnimationsReadAnimationById;

class AddSiteOptions extends BaseClass {
    
    protected $debugOn = false;
    private $appCode = null;
    private $database = null;
    private $languageId = null;
    public function __construct( $appCode, $database, $languageId ){
    
        // remember app code
        $this->appCode = $appCode;
                
        // remember database
        $this->database = $database;

        // remember language id
        $this->languageId = $languageId;

        // call parent
        parent::__construct();
            
    }
    public function addSiteObjects( $options )
    {

        // loop over options
        foreach( $options as $key => $option ) {
 
            // list group exists
            if( isset( $option['listGroup'] ) && isset( $option['id'] ) ){

                // add list group
                $options[$key] = $this->addListGroup( $option );
                
            }
            // list group exists
            
            // site object exists
            if( isset( $option['siteObject'] ) ){

                // is css
                if( isset( $option['css'] ) ){

                    // add site object
                    $cssObject = $this->addSiteObject( $option );

                    // loop over css object
                    foreach( $cssObject as $index => $value ){

                        // set option
                        $options[$index] = $value;

                    }
                    // loop over css object
                }
                // is css
                
            }
            // site object exists
                
        }
        // loop over options
        
        // loop over options
        foreach( $options as $key => $option ) {
 
            // site object exists
            if( isset( $option['siteObject'] ) ){

                // translation exists
                if( isset( $option['translation'] ) && $key === 'text' && isset( $option['id'] ) ){

                    // add site object
                    $options['translationId'] = $option['id'];

                }
                // translation exists

                // add site object
                $options[$key] = $this->addSiteObject( $option );
                
            }
            else {
                
                // is array
                if ( is_array( $option ) ) {

                    // debug info
                    $this->debug( 'addSiteObjects KEY: ' . $key );

                    // call recusrsive
                    $options[$key] = $this->addSiteObjects( $option );

                }
                else {
                    
                    // enhance text
                    if( strstr( $option, 'colorText' ) ){
                    
                        $text = explode( ':', $option );
                        
                        $options[$key] = $text[count( $text ) - 1];
                        
                    }
                    // enhance text
                    
                }
                // is array

            }
            // site object exists
            
        }
        // loop over options
        
        // return options
        return $options;
        
    }
    private function addSiteObject( $options ) {

        // debug info
        $this->debug( 'addSiteObjects id: ' . $options['id'] );

        // route exists
        if( isset( $options['route'] ) && isset( $options['id'] ) ){

            // debug info
            $this->debug( 'addRoute' );
            
            // add site object
            $options = $this->addRoute( $options );

        }
        // route exists
        
        // translation exists
        if( isset( $options['translation'] ) && isset( $options['id'] ) ){

            // debug info
            $this->debug( 'addtranslation' );
            
            // add site object
            $options = $this->addTranslation( $options );

        }
        // translation exists
        
        // css exists
        if( isset( $options['css'] ) && isset( $options['id'] ) ){

            // debug info
            $this->debug( 'addCss' );
            
            // add site object
            $options = $this->addCss( $options );

        }
        // css exists

        // color exists
        if( isset( $options['color'] ) && isset( $options['id'] ) ){

            // debug info
            $this->debug( 'addColor' );
            
            // add site object
            $options = $this->addColor( $options );

        }
        // color exists

        // media exists
        if( isset( $options['media'] ) && isset( $options['id'] ) ){

            // debug info
            $this->debug( 'addMedia' );
            
            // add site object
            $options = $this->addMedia( $options );

        }
        // media exists
        
        // animation exists
        if( isset( $options['animation'] ) && isset( $options['id'] ) ){

            // debug info
            $this->debug( 'addAnimation' );
            
            // add site object
            $options = $this->addAnimation( $options );

        }
        // animation exists
        
        // return result
        return $options;
        
    }
    private function addRoute( $options ) {

        // get route
        $routeRow = Routes::getRouteById( $this->database, 
                                          $options['id'] );
        // get route
        
        // route row exits
        if( $routeRow ){
            
            // create route
            $route = array(
                'type'          =>  'internal',
                'route'         =>  $routeRow->route,
                'languageId'    =>  $routeRow->language_id
            );
            // create route
                
            // return route
            return $route;
            
        }
        // route exits
        
        // return result
        return 'route not found';
        
    }    
    private function addTranslation( $options ) {

        // get translation id row
        $translationIdRow = Translations::getTranslationIdRow( $this->database, 
                                                               false,
                                                               $options['id'] );
        // get translation id row
        
        // get tags
        $tags = json_decode( $translationIdRow->options, true );
        
        
        // get translation
        $translationRow = Translations::getTranslation( $this->database, 
                                                        false,
                                                        $options['id'],
                                                        $this->languageId );
        // get translation
        
        // translation row exits
        if( $translationRow ){
            
            // replace line returns
            $translation = str_replace( "\n", '<br>', $translationRow->translation );
             
            // decode tags
            $translation = $this->decodeTags( $translation, $tags );
            
            // return translation
            return $translation;
            
        }
        // translation exits
        
        // return result
        return 'translation not found';
        
    }    
    private function decodeTags( $translation, $tags ) {

        // loop over tags
        foreach( $tags as $index => $tag ){

            // loop over tags
            foreach( $tag as $tagItemindex => $tagItem ){

                // create start code
                $startCode = '';
                
                // create end code
                $endCode = '';
                    
                // is font size
                if( $tagItemindex == 'fontSize' ||
                    $tagItemindex == 'marginLeft' ||
                    $tagItemindex == 'marginRight' ||
                    $tagItemindex == 'color' ){
                    
                    // create start code
                    $startCode = '<span style="';
                    // create end code
                    $endCode = '</span>';
                    
                }
                // is font size
                
                // is font size
                if( $tagItemindex == 'fontSize' ){

                    $startCode .= 'font-size: ' . $tagItem . ';">';
                    
                }
                // is font size
                
                // is margin left
                if( $tagItemindex == 'marginLeft' ){

                    $startCode .= 'margin-left: ' . $tagItem . ';">';
                    
                }
                // is margin left
                
                // is margin right
                if( $tagItemindex == 'marginRight' ){

                    $startCode .= 'margin-right: ' . $tagItem . ';">';
                    
                }
                // is margin right
                
                // is color
                if( $tagItemindex == 'color' ){

                    $startCode .= 'color: ' . $tagItem . ';">';
                    
                }
                // is font size
                
                // is font size
                if( $tagItemindex == 'fontSize' ||
                    $tagItemindex == 'color'||
                    $tagItemindex == 'marginLeft'||
                    $tagItemindex == 'marginRight' ){
                    
                    // replace tags in translation text
                    $translation = str_replace( '<' . $index . '>', $startCode, $translation );
                    
                    // replace tags in translation text
                    $translation = str_replace( '</' . $index . '>', $endCode, $translation );

                }
                // is font size
                
            }
            // loop over tags
            
        }
        // loop over tags
        
        
        // return result
        return $translation;
        
    }    
    private function addListGroup( $options ) {

        // create add list group
        $addListGroup = new AddListGroup( $this->database );
        
        // call list group
        return $addListGroup->add( $options );
        
    }    
    private function addCss( $options ) {

        // get css
        $css = SiteOptions::getOption( $this->database, 
                                       $options['id'] );
        // get css
        
        // css exits
        if( $css ){
            
            // return css options
            return json_decode( $css->value, true );
            
        }
        // css exits
        
        // return result
        return array();
        
    }    
    private function addColor( $options ) {

        // get color
        $color = SiteOptions::getOption( $this->database, 
                                         $options['id'] );
        // get color
        
        // color exits
        if( $color ){
            
            // get color options
            $colorOptions = json_decode( $color->value, true );

            // has color
            if( isset( $colorOptions['color'] ) ){
                
                // create gradient
                return $colorOptions['color'];
                
            }
            // has color
            
            // has gradient
            if( isset( $colorOptions['gradient'] ) ){
                
                // create gradient
                return $this->addGradient( $colorOptions['gradient'] );
                
            }
            // has gradient
            
            
        }
        // color exits
        
        // return result
        return 'color not found';
        
    }    
    private function addGradient( $gradientOptions ) {

        // create gradient
        $gradient = '';

        // has type / else
        if( isset( $gradientOptions['type'] ) ){
        
            // add type
            $gradient .= $gradientOptions['type'] . '-gradient( ';
            
        }
        else {
            
            // add type
            $gradient .= 'linear-gradient( ';
            
        }
        // has type / else
        
        // has angle
        if( isset( $gradientOptions['angle'] ) ){
        
            // add angle
            $gradient .= $gradientOptions['angle'] . 'deg, ';
            
        }
        // has angle
        
        // has color stops
        if( isset( $gradientOptions['colorStops'] ) ){
        
            // create iterator
            $i = 0;
            
            // loop over color stops
            foreach( $gradientOptions['colorStops'] as $index => $colorStop ){

                // has color
                if( isset( $colorStop['color'] ) ){

                    // get color options
                    $colorStopArray = explode( ':', $colorStop['color'] );

                    $color = $colorStopArray[count( $colorStopArray ) - 1];
                    
                    
                    // add color
                    $gradient .= ' ' .  $color . ' ';

                }
                // has color

                // has percentage
                if( isset( $colorStop['percentage'] ) ){

                    // add color
                    $gradient .= $colorStop['percentage'] . '% ';

                }
                // has percentage                
                
                // not last
                if( $i < count( $gradientOptions['colorStops'] ) - 1 ){
                    
                    // add separator
                    $gradient .= ', ';
                
                }
                
                // update iterator
                $i++;
                
            }
            // loop over color stops
            
        }
        // has color stops
        
        // close gradient
        $gradient .= ' )';
        
        // 
        $this->debug( 'gradient: ' . $gradient );
        
        // return result
        return $gradient;
        
    }    
    private function addMedia( $options ) {

        // create selection
        $selection = array(
            'id'    =>  $options['id']
        );
        // create selection
        
        // create read media
        $readMedia = new MediaReadMediaById();
        
        // read
        $mediaRow = $readMedia->read( $this->appCode, $this->database, $selection );
        
        // media exists
        if( $mediaRow && !isset( $mediaRow['error'] ) ){
            
            // return media
            return array(
                'name'      =>  $mediaRow['name'],
                'url'       =>  $mediaRow['url'],   
                'fileName'  =>  $mediaRow['fileName']
            );
            // return media
            
        }
        // media exists
        
        // return result
        return 'media not found';
        
    }    
    private function addAnimation( $options ) {

        // create selection
        $selection = array(
            'id'    =>  $options['id']
        );
        // create selection
        
        // create read animation
        $readAnimation = new AnimationsReadAnimationById();
        
        // read
        $animationRow = $readAnimation->read( $this->database, $selection );
        
        // animation exists
        if( $animationRow && !isset( $animationRow['error'] ) ){
            
            // return animation
            return array(
                'name'      =>  $animationRow['name'],
            );
            // return animation
            
        }
        // animation exists
        
        // return result
        return 'animation not found';
        
    }    
    
}
