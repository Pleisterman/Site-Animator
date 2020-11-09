<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       UpdateController.php
        function:   handles api read
 
        Last revision: 13-05-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SiteAnimator\Admin\Users\UserOptionsUpdate as AdminUserOptionsUpdate;
use App\SiteAnimator\Admin\Site\Settings\SettingsUpdate as SiteSettingsUpdate;
use App\SiteAnimator\Admin\Site\Languages\Update\LanguagesUpdate as SiteLanguagesUpdate;
use App\SiteAnimator\Admin\Site\Routes\Update\RoutesUpdate as SiteRoutesUpdate;
use App\SiteAnimator\Admin\Site\SiteItems\Update\SiteItemsUpdate;
use App\SiteAnimator\Admin\Site\Templates\Update\TemplatesUpdate as SiteTemplatesUpdate;
use App\SiteAnimator\Admin\Site\PageParts\Update\PagePartsUpdate as SitePagePartsUpdate;
use App\SiteAnimator\Admin\Site\Translations\Update\TranslationsUpdate as SiteTranslationsUpdate;
use App\SiteAnimator\Admin\Site\Lists\Update\ListsUpdate as SiteListsUpdate;
use App\SiteAnimator\Admin\Site\Animations\Update\AnimationsUpdate as SiteAnimationsUpdate;
use App\SiteAnimator\Admin\Site\Sequences\Update\SequencesUpdate as SiteSequencesUpdate;
use App\SiteAnimator\Admin\Site\Css\Update\CssUpdate as SiteCssUpdate;
use App\SiteAnimator\Admin\Site\Colors\Update\ColorsUpdate as SiteColorsUpdate;
use App\SiteAnimator\Admin\Site\Groups\Update\GroupsUpdate as SiteGroupsUpdate;

class UpdateController extends Controller
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
        $this->debug( 'CONTROLLER SiteAnimator Update index' );

        // get request values
        $this->getRequestValues( $request );
        
        // update
        $result = $this->update( $request->input('subject'),
                                 $request->input('selection'),
                                 $request->input('data') );
        // update
        
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
   private function update( $subject, $selection, $data ){
        
        // choose subject
        switch ( $subject ) {
                        
            //  user options
            case 'adminUserOptions': {

                // create user options update
                $userOptionsUpdate = new AdminUserOptionsUpdate( $this->database, $this->appCode );
                
                // call user options update
                return $userOptionsUpdate->update( $selection, $data );
                
            }
            // site settings
            case 'siteSettings': {
                
                // create settings
                $settingsUpdate = new SiteSettingsUpdate( $this->database, $this->appCode );
                
                // return settings call
                return $settingsUpdate->update( $selection, $data );
                
            }
            // site languages
            case 'siteLanguages': {
                
                // create site languages
                $languagesUpdate = new SiteLanguagesUpdate( $this->database, $this->appCode );
                
                // return languages call
                return $languagesUpdate->update( $selection, $data );
                
            }
            // site routes
            case 'siteRoutes': {
                
                // create routes
                $routesUpdate = new SiteRoutesUpdate( $this->database, $this->appCode );
                
                // return routes call
                return $routesUpdate->update( $selection, $data );
                
            }
            // site templates
            case 'siteTemplates': {
                
                // create templates
                $templatesUpdate = new SiteTemplatesUpdate( $this->database, $this->appCode );
                
                // return templates call
                return $templatesUpdate->update( $selection, $data );
                
            }
            // site page parts
            case 'sitePageParts': {
                
                // create page parts
                $pagePartsUpdate = new SitePagePartsUpdate( $this->database, $this->appCode );
                
                // return page parts call
                return $pagePartsUpdate->update( $selection, $data );
                
            }
            // site items
            case 'siteItems': {
                
                // create site items
                $siteItemsUpdate = new SiteItemsUpdate( $this->database, $this->appCode );
                
                // return site items call
                return $siteItemsUpdate->update( $selection, $data );
                
            }
            // site groups
            case 'siteGroups': {
                
                // create groups
                $groupsUpdate = new SiteGroupsUpdate( $this->database, $this->appCode );
                
                // return groups call
                return $groupsUpdate->update( $selection, $data );
                
            }
            // site translations
            case 'siteTranslations': {
                
                // create translations
                $translationsUpdate = new SiteTranslationsUpdate( $this->database, $this->appCode );
                
                // return translations call
                return $translationsUpdate->update( $selection, $data );
                
            }
            // site blog
            case 'siteLists': {
                
                // create lists
                $blogUpdate = new SiteListsUpdate( $this->database, $this->appCode );
                
                // return lists call
                return $blogUpdate->update( $selection, $data );
                
            }
            // site animations
            case 'siteAnimations': {
                
                // create animations
                $animationsUpdate = new SiteAnimationsUpdate( $this->database, $this->appCode );
                
                // return animations call
                return $animationsUpdate->update( $selection, $data );
                
            }
            // site sequences
            case 'siteSequences': {
                
                // create sequences
                $sequencesUpdate = new SiteSequencesUpdate( $this->database, $this->appCode );
                
                // return sequences call
                return $sequencesUpdate->update( $selection, $data );
                
            }
            // site css
            case 'siteCss': {
                
                // create css
                $cssUpdate = new SiteCssUpdate( $this->database, $this->appCode );
                
                // return css call
                return $cssUpdate->update( $selection, $data );
                
            }
            // site colors
            case 'siteColors': {
                
                // create colors
                $colorsUpdate = new SiteColorsUpdate( $this->database, $this->appCode );
                
                // return colors call
                return $colorsUpdate->update( $selection, $data );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'UpdateController error get, subject not found: ' . $subject );
                
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