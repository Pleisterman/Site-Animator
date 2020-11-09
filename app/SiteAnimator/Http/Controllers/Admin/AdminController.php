<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       AdminController.php
        function:   handles login route
  
        Last revision: 22-01-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Common\Models\Languages;
use App\Common\Models\Translations;

class AdminController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    private $appCode = false;
    private $database = false;
    private $isAdmin = true;
    private $view = 'siteAnimator.admin.admin';
    public function index( Request $request ) {
        
        // create debugger
        $this->createDebugger();
        
        // debug info
        $this->debug( 'CONTROLLER CodeAnalyser Login index' );

        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $this->database = isset( $action['database'] ) ? $action['database'] : false;
        
        // get app code
        $this->appCode = isset( $action['appCode'] ) ? $action['appCode'] : false;
        
        // get site path
        $sitePath = isset( $action['sitePath'] ) ? $action['sitePath'] : false;
        
        // get user
        $user = $request->attributes->get( 'adminUser' );
         
        // database / app code /  user ! exists
        if( !$this->database || !$this->appCode || !isset( $user ) ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->routeError( $request, 'values not set' );
            
        }
        // database / app code /  user ! exists
        
        // get user options
        $userOptions = $request->attributes->get( 'adminUserOptions' );
        
        // denug info
        $this->debug( 'language: ' . $userOptions['languageId'] );
        
        // get user language
        $userLanguageRow = Languages::getLanguage( $this->database, $this->isAdmin, $userOptions['languageId'] );
        
        // get admin languages
        $adminLanguages = $request->attributes->get( 'adminLanguages' );

        // create view options
        $viewOptions = array(
            'userAgent'             =>  $request->attributes->get( 'userAgent' ),
            'adminLanguages'        =>  $request->attributes->get( 'adminLanguages' ),
            'adminTranslations'     =>  $this->getTranslations( $userOptions['languageId'] ),
            'selectedLanguageId'    =>  $userLanguageRow->id,
            'selectedLanguageCode'  =>  substr( $adminLanguages[$userLanguageRow->id]['code'], 0, 2 ),
            'adminColors'           =>  $request->attributes->get( 'adminColors' ),
            'adminUid'              =>  $user->uid,
            'adminUserName'         =>  $user->name,
            'adminUserRoute'        =>  $user->route,
            'adminUserOptions'      =>  $userOptions,
            'adminSettings'         =>  $request->attributes->get( 'adminSettings' ),
            'adminIsResetPassword'  =>  false,
            'adminToken'            =>  $request->attributes->get( 'adminToken' ),
            'sitePath'              =>  $sitePath,
            'route'                 =>  $request->attributes->get( 'route' ),
            'siteItems'             =>  $request->attributes->get( 'siteItems' ),
            'siteItemsFiles'        =>  $request->attributes->get( 'siteItemsFiles' ),
            'siteLanguages'         =>  $request->attributes->get( 'siteLanguages' ),
            'siteDefaultLanguageId' =>  $request->attributes->get( 'siteDefaultLanguageId' ),
            'siteLanguageId'        =>  $request->attributes->get( 'siteLanguageId' ),
            'siteTranslations'      =>  $request->attributes->get( 'siteTranslations' ),
            'languageRoutes'        =>  $request->attributes->get( 'languageRoutes' ),
            'siteSettings'          =>  $request->attributes->get( 'siteSettings' ),
            'siteFonts'             =>  $request->attributes->get( 'siteFonts' ),
            'animationSequences'    =>  $request->attributes->get( 'animationSequences' ),
            'routeVariables'        =>  $request->attributes->get( 'routeVariables' ),
            'page'                  =>  $request->attributes->get( 'pageJson' )          
        );
        // create view options
        
        // create content
        $contents = view( $this->view, $viewOptions );        
        
        // create response
        $response = Response::make( $contents );
        
        // add headers
        $this->addHeaders( $request, $response );
        
        //  return response
        return $response;
        
    }
    private function getTranslations( $languageId ){
        
        // create result
        $result = array();
        
        // get login translations
        $result = Translations::getTranslationsByTypeAndLanguage( $this->database, 
                                                                  $this->isAdmin, 
                                                                  $languageId,
                                                                  'login' );
        // get login translations
        
        // get index translations
        $result = array_merge( $result, Translations::getTranslationsByTypeAndLanguage( $this->database, 
                                                                                        $this->isAdmin,
                                                                                        $languageId,        
                                                                                        'index' ) );
        // get index translations        
        
        // return result
        return $result;
        
    }
    private function addHeaders( $request, $response ){
        
        // get headers
        $headers = $request->attributes->get( 'headers' );

        // no headers
        if( !$headers ){
        
            // done 
            return;
            
        }
        // no headers
        
        // loop over headers
        forEach( $headers as $name => $content ){

            // debug info
            $this->debug( "ADD HEADERS : " . $name  . ' value: ' . $content );
            
            // add header
            $response->header( $name, $content );
            
        }
        // loop over headers
        
    }
    private function createDebugger( ){
    
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    
        
    }
    private function debug( $message  ){
        
        // debug is on    
        if( $this->debugOn ){
            
            // debug
            $this->debugger->log( $message );
            
        }
        // debug is on    
        
    }
    
}