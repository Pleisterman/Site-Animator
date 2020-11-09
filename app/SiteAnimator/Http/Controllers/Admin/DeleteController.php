<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       DeleteController.php
        function:   handles api delete
 
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SiteAnimator\Admin\Site\Routes\Delete\RoutesDelete as SiteRoutesDelete;
use App\SiteAnimator\Admin\Site\SiteItems\Delete\SiteItemsDelete;
use App\SiteAnimator\Admin\Site\Languages\Delete\LanguagesDelete as SiteLanguagesDelete;
use App\SiteAnimator\Admin\Site\Templates\Delete\TemplatesDelete as SiteTemplatesDelete;
use App\SiteAnimator\Admin\Site\PageParts\Delete\PagePartsDelete as SitePagePartsDelete;
use App\SiteAnimator\Admin\Site\Translations\Delete\TranslationsDelete as SiteTranslationsDelete;
use App\SiteAnimator\Admin\Site\Lists\Delete\ListsDelete as SiteListsDelete;
use App\SiteAnimator\Admin\Site\Animations\Delete\AnimationsDelete as SiteAnimationsDelete;
use App\SiteAnimator\Admin\Site\Sequences\Delete\SequencesDelete as SiteSequencesDelete;
use App\SiteAnimator\Admin\Site\Media\Delete\MediaDelete as SiteMediaDelete;
use App\SiteAnimator\Admin\Site\Css\Delete\CssDelete as SiteCssDelete;
use App\SiteAnimator\Admin\Site\Colors\Delete\ColorsDelete as SiteColorsDelete;
use App\SiteAnimator\Admin\Site\Groups\Delete\GroupsDelete as SiteGroupsDelete;

class DeleteController extends Controller
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
        $this->debug( 'CONTROLLER SiteAnimator Delete index' );

        // get request values
        $this->getRequestValues( $request );
        
        // delete
        $result = $this->delete( $request->input('subject'),
                                 $request->input('selection') );
        // delete
        
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
   private function delete( $subject, $selection ){
        
        // choose subject
        switch ( $subject ) {
                        
            // site routes
            case 'siteRoutes': {
                
                // create site routes
                $siteRoutesDelete = new SiteRoutesDelete( $this->database, $this->appCode );
                
                // return site routes call
                return $siteRoutesDelete->delete( $selection );
                
            }
            // site languages
            case 'siteLanguages': {
                
                // create site languages
                $siteLanguagesDelete = new SiteLanguagesDelete( $this->database, $this->appCode );
                
                // return site languages call
                return $siteLanguagesDelete->delete( $selection );
                
            }
            // site items
            case 'siteItems': {
                
                // create site items
                $siteItemsDelete = new SiteItemsDelete( $this->database, $this->appCode );
                
                // return site items call
                return $siteItemsDelete->delete( $selection );
                
            }
            // site templates
            case 'siteTemplates': {
                
                // create templates
                $siteTemplatesDelete = new SiteTemplatesDelete( $this->database, $this->appCode );
                
                // return templates call
                return $siteTemplatesDelete->delete( $selection );
                
            }
            // site page parts
            case 'sitePageParts': {
                
                // create site page parts
                $sitePagePartsDelete = new SitePagePartsDelete( $this->database, $this->appCode );
                
                // return site page parts call
                return $sitePagePartsDelete->delete( $selection );
                
            }
            // site translations
            case 'siteTranslations': {
                
                // create site translations
                $siteTranslationsDelete = new SiteTranslationsDelete( $this->database, $this->appCode );
                
                // return site translations call
                return $siteTranslationsDelete->delete( $selection );
                
            }
            // site lists
            case 'siteLists': {
                
                // create site lists
                $siteListsDelete = new SiteListsDelete( $this->database, $this->appCode );
                
                // return site lists call
                return $siteListsDelete->delete( $selection );
                
            }
            // site animations
            case 'siteAnimations': {
                
                // create site animations
                $siteAnimationsDelete = new SiteAnimationsDelete( $this->database, $this->appCode );
                
                // return site animations call
                return $siteAnimationsDelete->delete( $selection );
                
            }
            // site sequences
            case 'siteSequences': {
                
                // create site sequences
                $siteSequencesDelete = new SiteSequencesDelete( $this->database, $this->appCode );
                
                // return site sequences call
                return $siteSequencesDelete->delete( $selection );
                
            }
            // site media
            case 'siteMedia': {
                
                // create site media
                $siteMediaDelete = new SiteMediaDelete( $this->database, $this->appCode );
                
                // return site media call
                return $siteMediaDelete->delete( $selection );
                
            }
            // site css
            case 'siteCss': {
                
                // create site css
                $siteCssDelete = new SiteCssDelete( $this->database, $this->appCode );
                
                // return site css call
                return $siteCssDelete->delete( $selection );
                
            }
            // site colors
            case 'siteColors': {
                
                // create site colors
                $siteColorsDelete = new SiteColorsDelete( $this->database, $this->appCode );
                
                // return site colors call
                return $siteColorsDelete->delete( $selection );
                
            }
            // site groups
            case 'siteGroups': {
                
                // create site groups
                $siteGroupsDelete = new SiteGroupsDelete( $this->database, $this->appCode );
                
                // return site groups call
                return $siteGroupsDelete->delete( $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'DeleteController error delete, subject not found: ' . $subject );
                
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