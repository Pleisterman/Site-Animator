<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatePartReadChildParts.php
        function:   
                    
        Last revision: 19-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Read\ChildParts;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Models\Site\SiteItemsChilden;
use App\SiteAnimator\Admin\Site\SiteItems\Read\SiteItemsReadGroups;
use App\SiteAnimator\Admin\Site\SiteItems\Read\SiteItemsReadGroupItems;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadParents;

class TemplatePartReadChildParts extends BaseClass {

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

        // debug info
        $this->debug( ' TemplatePartReadChildParts' );

        // part id exists
        if( isset( $this->selection['partId'] ) ){
        
            // debug info
            $this->debug( ' Part: ' . $this->selection['partId'] );

            // add selected item to open groups
            $this->addSelectedItemGroupToOpenGroups();
            
        }
        // part id exists
        
        // get group id
        $groupId = isset( $this->selection['groupId'] ) ? $this->selection['groupId'] : null; 
        
        // debug info
        $this->debug( ' group id: ' . $groupId );

        // create site items read groups 
        $siteItemsReadGroups = new SiteItemsReadGroups( $this->database, $this->selection );
        
        // create site items read group items
        $siteItemsReadGroupItems = new SiteItemsReadGroupItems( $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $siteItemsReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $siteItemsReadGroups->read( $groupId );
        
        // add 
        $result = $this->addItemsCanBeChild( $result );
        
        // return result
        return $result;
        
    }
    private function addSelectedItemGroupToOpenGroups( ){

        // debug info
        $this->debug( 'addSelectedItemGroupToOpenGroups Part: ' . $this->selection['partId'] );
            
        // get part item
        $partSiteItem = SiteItems::getSiteItemPart( $this->database, $this->selection['partId'] ); 

        // add group to open groups
        $this->addParentGroupsToOpenGroups( $partSiteItem->group_id );
            
    }
    private function addParentGroupsToOpenGroups( $groupId ){
        
        // group id is null
        if( $groupId == null ){
            
            // done
            return;
            
        }
        // group id is null
        
        // create read parents
        $readParents = new GroupsReadParents( $this->database );

        // call read parents
        $parents = $readParents->read( $groupId );
        
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
    private function addItemsCanBeChild( $itemsList ){
        
        // has items
        if( isset( $itemsList['items'] ) ){
            
            // loop over items list items
            foreach ( $itemsList['items'] as $index => $item ){

                // get item has child 
                $hasChild = SiteItemsChilden::itemHasItemAsChild( $this->database, 
                                                                  $this->selection['parent']['siteItemId'],  
                                                                  $item['id'] );
                // get item has child 

                $itemsList['items'][$index]['canBeChild'] = $hasChild;                
            }
            // loop over items list items
        
        }
        // has items
                
        // has groups
        if( isset( $itemsList['groups'] ) ){
            
            // loop over items list groups
            foreach( $itemsList['groups'] as $index => $group ){

                // call recursive
                $itemsList['groups'][$index] = $this->addItemsCanBeChild( $group );

            }
            // loop over items list groups
        
        }
        // has groups
                
        // return list
        return $itemsList;
        
    }
}
