<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       addPage.php
        function:   translates the route to a page
                    the search follows the path
                        page with route and mobile with language
                        page with route and mobile
                        page with route with language
                        page with route
                        page not found with language
                        page not found
                        error page
                    combines the page information to a json named array
                    adds pageJson to request
                    adds language routes to request
 
        Last revision: 12-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Http\Base\BaseClass;
use App\Common\Models\Site\Routes;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Http\Middleware\Site\Common\AddSiteOptions;

class addPage extends BaseClass {
    
    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $translator = null;
    private $addSiteOptions = null;
    private $page = null;
    private $pageRoute = null;
    private $userAgent = null;
    private $showNotPublic = false;
    private $siteLanguageId = null;
    private $routeVariables = null;
    public function handle( $request, Closure $next )
    {
        
        // debug
        $this->debug( 'MIDDLEWARE SiteAnimator site addPage' );

        // initialize
        $this->initialize( $request );
        
        // get mobile page with specific language
        $this->getMobilePageWithLanguageId( $request );

        // get mobile page all languages
        $this->getMobilePageWithoutLanguage( $request );

        // get page with specific language
        $this->getPageWithLanguageId( $request );
        
        // get page with all languages
        $this->getPageWithoutLanguage( $request );
        
        // get not found page with specific language
        $this->getPageNotFoundPageWithLanguageId( );
        
        // get not found page all languages
        $this->getPageNotFoundPageWithoutLanguageId( );
        
        // get error page with specific language
        $this->getErrorPageWithLanguageId( );
        
        // get error page all languages
        $this->getErrorPageWithoutLanguageId( );
        
        // set page json
        $request->attributes->set( 'pageJson', $this->getPageJson() );

        // set language routes
        $request->attributes->set( 'languageRoutes', $this->translator->getLanguageRoutes( $request, $this->pageRoute ) );
        
        // follow the flow
        return $next( $request );
        
    }
    private function initialize( $request ){

        // get request action
        $action = $request->route()->getAction();
        
        // set app code
        $this->appCode = $action['appCode'];
        
        // set database
        $this->database = $action['database'];
        
        // get show not public
        $showNotPublic = $request->attributes->get( 'showNotPublic' );

        // show not public
        if( $showNotPublic ){
            
            // set show not public
            $this->showNotPublic = true;

        }
        // show not public
        
        // get user agent
        $this->userAgent = $request->attributes->get( 'userAgent' );

        // get route variables
        $this->routeVariables = $request->attributes->get( 'routeVariables' );
        
        // get force mobile
        $forceMobile = isset( $this->routeVariables['forceMobile'] ) ? true : false;

        // force mobile
        if( $forceMobile ){

            // set mobile
            $this->userAgent['isMobile'] = true;

            // set user agent
            $request->attributes->set( 'userAgent', $this->userAgent );

        }
        // force mobile
        
        // get language id
        $this->siteLanguageId = $request->attributes->get( 'siteLanguageId' );

        // create translator
        $this->translator = \App::make( 'Translator' );
        
        // create add site options
        $this->addSiteOptions = new AddSiteOptions( $this->appCode, $this->database, $this->siteLanguageId );
        
        // debug
        $this->debug( 'route: "' . $request->attributes->get( 'route' ) . '"' );
        
        // debug
        $this->debug( 'languageId: ' . $this->siteLanguageId );
        
    }        
    private function getMobilePageWithLanguageId( $request ){
        
        // page exists
        if( $this->page ){
            
            // done 
            return;

        }
        // page exists
        
        // not mobile
        if( !$this->userAgent['isMobile'] ){

            // done 
            return;

        }
        // not mobile
        
        // debug info
        $this->debug( 'find mobile page with language ' );

        // find page
        $page = Routes::findRoute( $this->database, 
                                   $this->siteLanguageId, 
                                   $request->attributes->get( 'route' ), 
                                   true, 
                                   $this->showNotPublic );
        // find page
        
        // page exists
        if( $page ){

            // debug info
            $this->debug( 'page found' );
            
            // set page
            $this->page = $page;

            // set page route
            $this->pageRoute = $this->page['route'];

            // get parent page
            $this->getParentPage();

        }
        // page exists

    }
    private function getMobilePageWithoutLanguage( $request ){

        // page exists
        if( $this->page ){
            
            // done 
            return;

        }
        // page exists
        
        // not mobile
        if( !$this->userAgent['isMobile'] ){

            // done 
            return;

        }
        // not mobile
        
        // debug info
        $this->debug( 'find mobile page without language' );

        // find page
        $page = Routes::findRoute( $this->database, 
                                   false, 
                                   $request->attributes->get( 'route' ), 
                                   true, 
                                   $this->showNotPublic );
        // find page
        
        // page exists
        if( $page ){

            // debug info
            $this->debug( 'page found' );
                
            // set page
            $this->page = $page;

            // set page route
            $this->pageRoute = $page->route;
            
        }
        // page exists
        
    }
    private function getPageWithLanguageId( $request ){
        
        // page exists
        if( $this->page ){
            
            // done 
            return;
            
        }
        // page exists

        // debug info
        $this->debug( 'find page with language' );

        // find page
        $page = Routes::findRoute( $this->database, 
                                   $this->siteLanguageId, 
                                   $request->attributes->get( 'route' ), 
                                   false, 
                                   $this->showNotPublic );
        // find page
        
        // page exists
        if( $page ){

            // debug info
            $this->debug( 'page found' );
            
            // set page
            $this->page = $page;

            // set page route
            $this->pageRoute = $page->route;

            // get parent page
            $this->getParentPage();

        }
        // page exists

    }
    private function getPageWithoutLanguage( $request ){
        
        // page exists
        if( $this->page ){
            
            // done 
            return;
            
        }
        // page exists
        
        // debug info
        $this->debug( 'find page without language' );

        // find page
        $page = Routes::findRoute( $this->database, 
                                   false, 
                                   $request->attributes->get( 'route' ), 
                                   false, 
                                   $this->showNotPublic );
        // find page

        // page exists
        if( $page ){

            // debug info
            $this->debug( 'page found' );
                
            // set page
            $this->page = $page;

            // set page route
            $this->pageRoute = $page->route;
            
        }
        // page exists

    }
    private function getPageNotFoundPageWithLanguageId( ){
        
        // page exists
        if( $this->page ){
            
            // done 
            return;
            
        }
        // page exists
            
        // debug info    
        $this->debug( 'find not found page with language' );
            
        // find not found page with language
        $page = Routes::findNotFoundRoute( $this->database, 
                                           $this->siteLanguageId, 
                                           $this->showNotPublic );
        // find not found page with language

        // page exists
        if( $page ){

            // debug info
            $this->debug( 'page found' );
            
            // set page
            $this->page = $page;

            // set page route
            $this->pageRoute = $page->route;

            // get parent page
            $this->getParentPage();

        }
        // page exists
            
    }
    private function getPageNotFoundPageWithoutLanguageId( ){
        
        // page exists
        if( $this->page ){
            
            // done 
            return;
            
        }
        // page exists
            
        // debug info    
        $this->debug( 'find not found page without language' );
            
        // find not found page without language
        $page = Routes::findNotFoundRoute( $this->database, 
                                           false, 
                                           $this->showNotPublic );
        // find not found page without language
        
        // page exists
        if( $page ){

            // debug info
            $this->debug( 'page found' );
            
            // set page
            $this->page = $page;

            // set page route
            $this->pageRoute = $page->route;

        }
        // page exists
                
    }
    private function getErrorPageWithLanguageId( ){
        
        // page exists
        if( $this->page ){
            
            // done 
            return;
            
        }
        // page exists
            
        // debug info    
        $this->debug( 'finding error page with language' );
        
        // find error page with language
        $page = Routes::findErrorRoute( $this->database, 
                                        $this->siteLanguageId, 
                                        $this->showNotPublic );
        // find error page with language

        // page exists
        if( $page ){

            // debug info
            $this->debug( 'page found' );
            
            // set page
            $this->page = $page;
        
            // set page route
            $this->pageRoute = $this->page['route'];

            // get parent page
            $this->getParentPage();
            
        }
        // page exists

    }            
    private function getErrorPageWithoutLanguageId( ){
        
        // page exists
        if( $this->page ){
            
            // done 
            return;
            
        }
        // page exists
            
        // debug info    
        $this->debug( 'finding error page with language' );
        
        // find error page without language
        $page = Routes::findErrorRoute( $this->database, 
                                        false, 
                                        $this->showNotPublic );
        // find error page without language

        // page exists
        if( $page ){

            // debug info
            $this->debug( 'page found' );
            
            // set page
            $this->page = $page;
        
            // set page route
            $this->pageRoute = $this->page['route'];

        }
        // page exists

    }            
    private function getParentPage( ){
        
        // page exists and has parent
        if( $this->page && $this->page->parent_id ){

            // get child options
            $childOptions = json_decode( $this->page->options, true );

            // get parent
            $parentPage = Routes::findParentRoute( $this->database, 
                                                   $this->page->parent_id );

            // parent exists
            if( $parentPage ){
                
                // get page options
                $parentPageOptions = json_decode( $parentPage->options, true );

                // merge options
                $options = array_merge( $childOptions, $parentPageOptions );

                // set parent page options
                $parentPage->options = json_encode( $options );
                
                // set page
                $this->page = $parentPage;
                
            }
            // parent exists

        }
        // page exists and has parent
            
    }            
    private function getPageJson( ){
        
        // get options
        $options = json_decode( $this->page->options, true );
        
        // add site objects options
        $options = $this->addSiteOptions->addSiteObjects( $options );

        // create page json
        $pageJson = array(
            'id'            => $this->page->id,
            'name'          => $this->page->name,
            'languageId'    => $this->page->language_id,
            'adminGroupId'  => $this->page->site_options_id,
            'options'       => $options,
            'parts'         => $this->getPageParts( )
        );
        // create page array

        // done
       return $pageJson;
        
    }
    private function getPageParts( ){

        // get page parts
        $pageParts = SiteOptions::getPageOptions( $this->database, 
                                                  $this->page->id,
                                                  $this->showNotPublic );
        // get page parts
        
        // create result
        $result = array();
            
        // loop over page parts
        foreach( $pageParts as $pagePartRow ) {

            // get part
            $part = $this->getPart( $pagePartRow );
   
            // add part to result
            array_push( $result, $part );
            
        }
        // loop over parts
        
        
        // done
        return $result;        
        
    }
    private function getPart( $pagePartRow ){
        
            // create parentId
            $parentId = $pagePartRow->id;
        
            // decode page part options
            $pagePartOptions = json_decode( $pagePartRow->value, true );
           
            // get part row
            $partRow = SiteOptions::getOption( $this->database, $pagePartRow->part_id );
                        
            // add part route
            $routeId = $pagePartRow->site_routes_id;
            
            // add part id
            $partId = $pagePartRow->id;
            
            // get part name
            $partName = $pagePartRow->name;
            
            // part row type is template
            if( $partRow->type == 'template' ){
            
                $this->debug( 'hueru template: ' . $partRow->id );
                
                // create template row
                $templateRow = $partRow;
                
                // set parent
                $parentId = $templateRow->id;
                
                // get template part row
                $partRow = SiteOptions::getOption( $this->database, $templateRow->part_id );
                
            }
            // part row type is template
            
            // decode part options
            $partOptions = json_decode( $partRow->value, true );
           
            // template row exists
            if( isset( $templateRow ) ){
                
                $this->debug( 'hueru' );
                
                // decode part options
                $templateOptions = json_decode( $templateRow->value, true );
                
                // merge options
                $partOptions = array_replace_recursive( $partOptions, $templateOptions );

            }
            // template row exists

            $this->debug(json_encode($partOptions));
                
            // merge options
            $options = array_replace_recursive( $partOptions, $pagePartOptions );
            
            $this->debug(json_encode($options));
                
            // add site objects
            $options = $this->addSiteOptions->addSiteObjects( $options );

            // add route id
            $options['routeId'] = $routeId;

            // add part id
            $options['partId'] = $partId;

            // add part name
            $options['partName'] = $partName;

            // create part array
            $part = array(
                'id'        => $pagePartRow->id,
                'partId'    => $pagePartRow->part_id,
                'name'      => $pagePartRow->name,
                'type'      => $partRow->type,
                'options'   => $options,
                'parts'     => $this->getPartParts( $parentId )
            );
 
            // return result
            return $part;
            
    }
    private function getPartParts( $parentId ){
        
        // create result
        $result = array();

        // get parts
        $parts = SiteOptions::getPageParts( $this->database, 
                                            $parentId,
                                            $this->showNotPublic );
        // get parts

        // loop over parts
        foreach ( $parts as $partRow ) {
            
            // get part
            $part = $this->getPart( $partRow );
            
            // add part to result
            array_push( $result, $part );
            
        }
        // loop over parts
        
        // return result
        return $result;
        
    }
    
}
