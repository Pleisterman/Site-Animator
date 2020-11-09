<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ReadController.php
        function:   handles api read
 
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Common\Admin\Translations\Translations as AdminTranslations;
use App\SiteAnimator\Admin\Site\Settings\SettingsRead as SiteSettingsRead;
use App\SiteAnimator\Admin\Site\Languages\Read\LanguagesRead as SiteLanguagesRead;
use App\SiteAnimator\Admin\Site\Routes\Read\RoutesRead as SiteRoutesRead;
use App\SiteAnimator\Admin\Site\SiteItems\Read\SiteItemsRead;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesRead as SiteTemplatesRead;
use App\SiteAnimator\Admin\Site\PageParts\Read\PagePartsRead as SitePagePartsRead;
use App\SiteAnimator\Admin\Site\Translations\Read\TranslationsRead as SiteTranslationsRead;
use App\SiteAnimator\Admin\Site\Lists\Read\ListsRead as SiteListsRead;
use App\SiteAnimator\Admin\Site\Animations\Read\AnimationsRead as SiteAnimationsRead;
use App\SiteAnimator\Admin\Site\Sequences\Read\SequencesRead as SiteSequencesRead;
use App\SiteAnimator\Admin\Site\Media\Read\MediaRead as SiteMediaRead;
use App\SiteAnimator\Admin\Site\Css\Read\CssRead as SiteCssRead;
use App\SiteAnimator\Admin\Site\Colors\Read\ColorsRead as SiteColorsRead;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsRead as SiteGroupsRead;

class ReadController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    private $appCode = false;
    private $database = false;
    public function index( Request $request ) {
        
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    
        
        // debug info
        $this->debug( 'CONTROLLER SiteAnimator Read Index subject: ' . $request->input('subject') );

        // get request values
        $this->getRequestValues( $request );
        
        // read
        $result = $this->read( $request->input('subject'),
                               $request->input('selection') );
        
        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
    }
   private function getRequestValues( $request ){
        
        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $this->database = isset( $action['database'] ) ? $action['database'] : false;
        
        // get app code
        $this->appCode = isset( $action['appCode'] ) ? $action['appCode'] : false;
        
        // debug info
        $this->debug( ' database: ' . $this->database . ' appCode: ' . $this->appCode  );
        
   }
   private function read( $subject, $selection ){
        
        // choose subject
        switch ( $subject ) {
                        
            // admin translations
            case 'adminTranslations': {
                
                // create translations
                $translations = new AdminTranslations( );
                
                // return translations call
                return $translations->read( $this->database, $selection );
                
            }
            // site languages
            case 'siteLanguages': {
                
                // create site languages
                $siteLanguages = new SiteLanguagesRead( );
                
                // return site languages call
                return $siteLanguages->read( $this->database, $selection );
                
            }
            // site settings
            case 'siteSettings': {
                
                // create site settings read
                $siteSettings = new SiteSettingsRead( );
                
                // return site settings call
                return $siteSettings->read( $this->database, $selection );
                
            }
            // site groups
            case 'siteGroups': {
                
                // create site groups
                $siteGroups = new SiteGroupsRead( );
                
                // return site grroups call
                return $siteGroups->read( $this->database, $selection );
                
            }
            // site routes
            case 'siteRoutes': {
                
                // create routes read
                $siteRoutes = new SiteRoutesRead( );
                
                // return routes call
                return $siteRoutes->read( $this->database, $selection );
                
            }
            // site items
            case 'siteItems': {
                
                // create site items read
                $siteItems = new SiteItemsRead( );
                
                // return site items call
                return $siteItems->read( $this->database, $selection );
                
            }
            // site templates
            case 'siteTemplates': {
                
                // create templates read
                $siteTemplates = new SiteTemplatesRead( );
                
                // return templates call
                return $siteTemplates->read( $this->database, $selection );
                
            }
            // site page parts
            case 'sitePageParts': {
                
                // create page parts read
                $sitePageParts = new SitePagePartsRead( );
                
                // return page parts call
                return $sitePageParts->read( $this->database, $selection );
                
            }
            // site translations
            case 'siteTranslations': {
                
                // create site translations read
                $siteTranslations = new SiteTranslationsRead( );
                
                // return site translations call
                return $siteTranslations->read( $this->database, $selection );
                
            }
            // site blog
            case 'siteLists': {
                
                // create site blog read
                $siteLists = new SiteListsRead( );
                
                // return site blog call
                return $siteLists->read( $this->database, $selection );
                
            }
            // site animations
            case 'siteAnimations': {
                
                // create site animations read
                $siteAnimations = new SiteAnimationsRead( );
                
                // return site animations call
                return $siteAnimations->read( $this->database, $selection );
                
            }
            // site sequences
            case 'siteSequences': {
                
                // create site sequences read
                $siteSequences = new SiteSequencesRead( );
                
                // return site sequences call
                return $siteSequences->read( $this->database, $selection );
                
            }
            // site media
            case 'siteMedia': {
                
                // create site media read
                $siteMedia = new SiteMediaRead( );
                
                // return site media call
                return $siteMedia->read( $this->appCode, $this->database, $selection );
                
            }
            // site css
            case 'siteCss': {
                
                // create site css read
                $siteCss = new SiteCssRead( );
                
                // return site css call
                return $siteCss->read( $this->database, $selection );
                
            }
            // site colors
            case 'siteColors': {
                
                // create site colors read
                $siteColors = new SiteColorsRead( );
                
                // return site colors call
                return $siteColors->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( ' readController error get, subject not found: ' . $subject );
                
                // done with error
                return array( 'criticalError' => 'subjectNotFound' );
                
            }
            
        }        
        // done choose subject
        
    }
    private function debug( $message  ){
        
        // debug is on    
        if( $this->debugOn ){
            
            // debug
            $this->debugger->log( $message );
            
        }
        
    }
}