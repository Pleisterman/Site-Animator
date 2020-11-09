<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 02-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Routes;
use App\SiteAnimator\Admin\Site\PageParts\Read\PagePartsReadPageParts;
use App\SiteAnimator\Admin\Site\PageParts\Read\PagePartsReadParts;
use App\SiteAnimator\Models\Site\SiteOptions;

class PagePartsReadList extends BaseClass {

    protected $debugOn = true;
    private $selection = null;
    private $database = null;
    public function __construct( $database, $selection ) {
        
        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;

        // call parent
        parent::__construct();
        
    }
    public function read( ){
        
        // add selected item group to open groups
        $this->addSelectedItemToOpenGroups();
        
        // page id exists
        if( isset( $this->selection['pageId'] ) ) {
        
            // get route
            return $this->getRoute();
            
        }
        // page id exists

        // get part parts
        return $this->getPartParts( $this->selection['groupId'] );
        
    }
    private function getRoute( ){
        
        // get row
        $routeRow = Routes::getRouteById( $this->database, $this->selection['pageId'] );
        
        // row ! found
        if( !$routeRow ){
             
            // return deleted
            return $this->handleDeleted();
            
        }
        // row ! found
        
        // create route
        $route = $this->createRoute( $routeRow );
        
        // get page parts
        $pageParts = $this->getPageParts( );

        // has rows
        if( count( $pageParts['groups'] ) > 0 ){
            
            // set has groups
            $route['hasGroups'] = true;
            
            // set collapsed
            $route['collapsed'] = true;
            
            // set groups
            $route['groups'] = $pageParts['groups'];
        }
        // has rows
        
        // return result
        return $route;
        
    }    
    private function getPageParts( ){
    
        // create read page parts 
        $readParts = new PagePartsReadPageParts( $this->database, $this->selection );

        // return page parts call
        return $readParts->read( $this->selection['pageId'] );
        
    }    
    private function getPartParts( $partId ){
    
        // get row
        $partRow = SiteOptions::getOption( $this->database, $partId );
        
        // row ! found
        if( !$partRow ){
             
            // return deleted
            return $this->handleDeleted();
            
        }
        // row ! found
        
        // create read page parts children
        $readParts = new PagePartsReadParts( $this->database, $this->selection );

        // return children call
        return $readParts->read( $partRow->id );
        
    }    
    private function createRoute( $routeRow ){
    
        // get route
        $route = array( 
                    'id'            =>  $routeRow->id,   
                    'subject'       =>  'sitePageParts',
                    'editType'      =>  'group',
                    'groupType'     =>  'routes',
                    'type'          =>  'route',
                    'readOnly'      =>  true,
                    'isGroup'       =>  true,
                    'hasItems'      =>  false,
                    'hasGroups'     =>  false,
                    'sequence'      =>  0,
                    'name'          =>  $routeRow->name   
                );
        // get route

        // return result
        return $route;
        
    }    
    private function handleDeleted( ){

        // create deleted
        $deleted = array( 
            'id'            =>  'null',   
            'subject'       =>  'sitePageParts',
            'editType'      =>  'pageParts',
            'groupType'     =>  'routes',
            'type'          =>  'deleted',
            'readOnly'      =>  true,
            'isGroup'       =>  true,
            'hasItems'      =>  false,
            'hasGroups'     =>  false,
            'sequence'      =>  0,
            'name'          =>  'alreadyDeleted'   
        );
        // create deleted

        // return deleted
        return $deleted;
        
    }    
    private function addSelectedItemToOpenGroups( ){

        // selection is set and selected item id is set
        if( isset( $this->selection ) && isset( $this->selection['selectedItemId'] ) &&
            $this->selection['selectedItemId'] != null ){
        
            // get row
            $partRow = SiteOptions::getOption( $this->database, $this->selection['selectedItemId'] );
        
            // panent id ! null
            if( $partRow->parent_id != null ){
                
                // add selected group to open groups
                $this->addSelectedPartToOpenGroups( $partRow->parent_id );
                
            }
            // group id ! null
            
        }
        // selection is set and selected item id is set
        
    }
    private function addSelectedPartToOpenGroups( $partId ){
 
        // default open groups
        isset( $this->selection['openGroups'] ) ? 
            $this->selection['openGroups'] : 
            $this->selection['openGroups'] = array();
        // default open groups

        // add group to open groups
        array_push( $this->selection['openGroups'], $partId );
        
        // get row
        $partRow = SiteOptions::getOption( $this->database, $partId );

        // panent id ! null
        if( $partRow->parent_id != null ){

            // add selected group to open groups
            $this->addSelectedPartToOpenGroups( $partRow->parent_id );

        }
        // group id ! null
            
    }
    
}
