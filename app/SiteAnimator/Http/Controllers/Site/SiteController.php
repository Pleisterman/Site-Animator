<?php

/*
        @package    Pleisterman\SiteAnimator\Website
  
        file:       SiteController.php
        function:   handles web site routes
  
        Last revision: 03-01-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Site;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    private $siteView = 'siteAnimator.site.site';
    public function index( Request $request ) {
        
        // create debugger
        $this->createDebugger();
        
        // debug info
        $this->debug( 'CONTROLLER Site Animator Site index' );

        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $this->database = isset( $action['database'] ) ? $action['database'] : false;
        
        // get app code
        $this->appCode = isset( $action['appCode'] ) ? $action['appCode'] : false;
        
        // database / app code /  user ! exists
        if( !$this->database || !$this->appCode ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->criticalError( $request, 'values not set' );
            
        }
        // database / app code /  user ! exists
        
        // create view options
        $viewOptions = array(
              'userAgent'               => $request->attributes->get( 'userAgent' ),
              'siteItemsFiles'          => $request->attributes->get( 'siteItemsFiles' ),
              'siteLanguages'           => $request->attributes->get( 'siteLanguages' ),
              'siteDefaultLanguageId'   => $request->attributes->get( 'siteDefaultLanguageId' ),
              'siteLanguageId'          => $request->attributes->get( 'siteLanguageId' ),
              'siteTranslations'        => $request->attributes->get( 'siteTranslations' ),
              'languageRoutes'          => $request->attributes->get( 'languageRoutes' ),
              'siteSettings'            => $request->attributes->get( 'siteSettings' ),
              'siteFonts'               => $request->attributes->get( 'siteFonts' ),
              'animationSequences'      => $request->attributes->get( 'animationSequences' ),
              'routeVariables'          => $request->attributes->get( 'routeVariables' ),
              'page'                    => $request->attributes->get( 'pageJson' ),
        );
        // create view options
        
        // create content
        $contents = view( $this->siteView, $viewOptions );        
        
        // create response
        $response = Response::make( $contents );
        
        // add headers
        $this->addHeaders( $request, $response );
        
        //  return response
        return $response;

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