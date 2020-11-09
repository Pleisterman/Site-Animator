<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsReadParents.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 15-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Read\Parents;

use App\Http\Base\BaseClass;
use App\Common\Models\Site\Routes;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Admin\Site\PageParts\Read\PagePartsReadList;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadParents;

class PagePartsReadParents extends BaseClass {

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

        // page id exists and selected parent exists
        if( isset( $this->selection['pageId'] ) && $this->selection['selectedParentId'] != null ) {

            // add selected group to open groups
            $this->addSelectedGroupToOpenGroups();
            
        }
        // page id exists and selected parent exists

        // add part item
        $this->addPartItem();
        
        // create read page parts list
        $readlist = new PagePartsReadList( $this->database, $this->selection );

        // return list call
        $pagePartList = $readlist->read( );

        // create parts
        $parts = array();
        
        // page id exists
        if( isset( $this->selection['pageId'] ) ) {
        
            // set id
            $pagePartList['id'] = null;
            
            // get route
            $route = Routes::getRoute( $this->database, $this->selection['pageId'] );
            
            // set name
            $pagePartList['name'] = 'Page: ' . $route->name;
            
            // set part id
            $pagePartList['partId'] = 'page';
            
            // add children
            $part = $this->addParts( $pagePartList );

            // add page to parts
            array_push( $parts, $part );
            
        }
        else {
        
            // loop over parts
            foreach( $pagePartList['groups'] as $index => $groupGroup ){
            
                // not a tempate
                if( $groupGroup['isTemplate'] != 1 ){
                    
                    // add parts
                    $part = $this->addParts( $groupGroup );

                    // add page to parts
                    array_push( $parts, $part );

                }
                
            }
            // loop over parts
            
        }
        // page id exists
            
        // return result
        return $parts;
        
    }
    private function addParts( $part ) {
        
        //
        $this->debug( 'addPart: ' . $part['id'] );
            
        // create part
        $result = array(
            'id'            =>  $part['id'],
            'type'          =>  'text',
            'name'          =>  $part['name'],
            'canSelect'     =>  true,
            'parts'         =>  array()
        );
        // create part
                   

        // part id is null / else
        if( $part['id'] == null ){
            
            // get page item
            $pageItem = SiteItems::getPageItem( $this->database ); 
            
            // set item id
            $result['siteItemId'] = $pageItem->id;
            
        }
        else {
            
            // get part item id
            $partSiteItemId = SiteItems::getPartItemId( $this->database, $part['id'] ); 
            
            // set item id
            $result['siteItemId'] = $partSiteItemId->id;
            
        }
        // part id is null / else
        
        // page has parts
        if( $part['hasGroups'] ){
            
            // set can collapse
            $result['canCollapse'] = true;
            
        }
        // page has parts
        
        // get children
        $readChildren = new PagePartsReadParentsPartHasChildren( $this->database, $this->selection );
        
        // read
        $hasChildren = $readChildren->read( $part );
        
        // has children
        if( $hasChildren ){
            
            // set has children
            $result['hasChildren'] = true;
            
        }
        else {
            
            // set has children
            $result['hasChildren'] = false;
            
        }
        // has children
        
        // page has parts and parts exists
        if( $part['hasGroups'] && isset( $part['groups'] ) ){
            
            // set collapsed
            $result['collapsed'] = false;
            
            // loop over route part page parts
            foreach( $part['groups'] as $index => $partPart ){

                // not a template
                if( $partPart['isTemplate'] != 1 ){
                    
                    // get part with children
                    $newPart = $this->addParts( $partPart );

                    // add page to parts
                    array_push( $result['parts'], $newPart );

                }
                // not a tempate
                
            } 
            // loop over route part page parts
        
        }
        // page has parts and parts exists
        
        // return result
        return $result;
        
    }
    private function addPartItem( ) {
        
        // item part id exists
        if( isset( $this->selection['itemId'] ) && $this->selection['itemId'] ){
            
            // get part
            $part = SiteOptions::getOption( $this->database, $this->selection['itemId'] );
            
            if( $part->is_template == 1 ){
                
                // get part item
                $siteItem = SiteItems::getPartItemId( $this->database, $part->part_id );
                
            }
            else {
                
                // get part item
                $siteItem = SiteItems::getPartItemId( $this->database, $this->selection['itemId'] );
            }
            
            // add item id to selection
            $this->selection['siteItemId'] = $siteItem->id;
            
        }
        // item part id exists
        
    }
    private function addSelectedGroupToOpenGroups( ) {
        
        // create read parents
        $readParents = new GroupsReadParents( $this->database );
        
        // call read parents
        $parents = $readParents->read( $this->selection['selectedParentId'] );
        
        // default open groups
        isset( $this->selection['openGroups'] ) ? 
            $this->selection['openGroups'] : 
            $this->selection['openGroups'] = array();
        // default open groups
        
        // loop over parents
        for( $i = 0; $i < count( $parents ); $i++ ){

            // not in open groups
            if( !in_array( $parents[$i], $this->selection['openGroups'] ) ){
                
                // add to open groups
                array_push( $this->selection['openGroups'], $parents[$i] );
                
            } 
            // not in open groups
            
        }
        // loop over groups
        
        // debug info
        $this->debug( 'openGroups: ' . json_encode( $this->selection['openGroups'] ) );
        
    }
    
}
