<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       InsertController.php
        function:   handles api insert
 
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SiteAnimator\Admin\Site\Routes\Insert\RoutesInsert as SiteRoutesInsert;
use App\SiteAnimator\Admin\Site\SiteItems\Insert\SiteItemsInsert;
use App\SiteAnimator\Admin\Site\Languages\Insert\LanguagesInsert as SiteLanguagesInsert;
use App\SiteAnimator\Admin\Site\Templates\Insert\TemplatesInsert as SiteTemplatesInsert;
use App\SiteAnimator\Admin\Site\PageParts\Insert\PagePartsInsert as SitePagePartsInsert;
use App\SiteAnimator\Admin\Site\Translations\Insert\TranslationsInsert as SiteTranslationsInsert;
use App\SiteAnimator\Admin\Site\Lists\Insert\ListsInsert as SiteListsInsert;
use App\SiteAnimator\Admin\Site\Animations\Insert\AnimationsInsert as SiteAnimationsInsert;
use App\SiteAnimator\Admin\Site\Sequences\Insert\SequencesInsert as SiteSequencesInsert;
use App\SiteAnimator\Admin\Site\Css\Insert\CssInsert as SiteCssInsert;
use App\SiteAnimator\Admin\Site\Colors\Insert\ColorsInsert as SiteColorsInsert;
use App\SiteAnimator\Admin\Site\Groups\Insert\GroupsInsert as SiteGroupsInsert;

class InsertController extends Controller
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
        $this->debug( 'CONTROLLER SiteAnimator Insert index' );

        // get request values
        $this->getRequestValues( $request );
        
        // insert
        $result = $this->insert( $request->input('subject'),
                                 $request->input('data') );
        // insert
        
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
   private function insert( $subject, $data ){
        
        // choose subject
        switch ( $subject ) {
                        
            // site routes
            case 'siteRoutes': {
                
                // create site routes
                $siteRoutesInsert = new SiteRoutesInsert( $this->database, $this->appCode );
                
                // return site routes call
                return $siteRoutesInsert->insert( $data );
                
            }
            // site languages
            case 'siteLanguages': {
                
                // create site languages
                $siteLanguagesInsert = new SiteLanguagesInsert( $this->database, $this->appCode );
                
                // return site languages call
                return $siteLanguagesInsert->insert( $data );
                
            }
            // site site items
            case 'siteItems': {
                
                // create items routes
                $siteItemsInsert = new SiteItemsInsert( $this->database, $this->appCode );
                
                // return site items call
                return $siteItemsInsert->insert( $data );
                
            }
            // site templates
            case 'siteTemplates': {
                
                // create templates
                $siteTemplatesInsert = new SiteTemplatesInsert( $this->database, $this->appCode );
                
                // return templates call
                return $siteTemplatesInsert->insert( $data );
                
            }
            // site page parts
            case 'sitePageParts': {
                
                // create site page parts
                $sitePagePartsInsert = new SitePagePartsInsert( $this->database, $this->appCode );
                
                // return site page parts call
                return $sitePagePartsInsert->insert( $data );
                
            }
            // site translations
            case 'siteTranslations': {
                
                // create site translations
                $siteTranslationsInsert = new SiteTranslationsInsert( $this->database, $this->appCode );
                
                // return site translations call
                return $siteTranslationsInsert->insert( $data );
                
            }
            // site blog
            case 'siteLists': {
                
                // create site blog
                $siteListsInsert = new SiteListsInsert( $this->database, $this->appCode );
                
                // return site blog call
                return $siteListsInsert->insert( $data );
                
            }
            // site animations
            case 'siteAnimations': {
                
                // create site animations
                $siteAnimationsInsert = new SiteAnimationsInsert( $this->database, $this->appCode );
                
                // return site animations call
                return $siteAnimationsInsert->insert( $data );
                
            }
            // site sequences
            case 'siteSequences': {
                
                // create site sequences
                $siteSequencesInsert = new SiteSequencesInsert( $this->database, $this->appCode );
                
                // return site sequences call
                return $siteSequencesInsert->insert( $data );
                
            }
            // site css
            case 'siteCss': {
                
                // create site css
                $siteCssInsert = new SiteCssInsert( $this->database, $this->appCode );
                
                // return site css call
                return $siteCssInsert->insert( $data );
                
            }
            // site colors
            case 'siteColors': {
                
                // create site colors
                $siteColorsInsert = new SiteColorsInsert( $this->database, $this->appCode );
                
                // return site colors call
                return $siteColorsInsert->insert( $data );
                
            }
            // site groups
            case 'siteGroups': {
                
                // create site groups
                $siteGroupsInsert = new SiteGroupsInsert( $this->database, $this->appCode );
                
                // return site groups call
                return $siteGroupsInsert->insert( $data );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'InsertController error insert, subject not found: ' . $subject );
                
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