<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsReadChildParts.php
        function:   
                    
        Last revision: 28-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Read\ChildParts;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Models\Site\SiteItemsChilden;
use App\SiteAnimator\Admin\Site\SiteItems\Read\SiteItemsReadList;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesReadList;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadParents;

class PagePartsReadChildParts extends BaseClass {

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
        $this->debug( ' PagePartsReadChildParts' );
        
        // get group id
        $groupId = $this->selection['groupId'] == null ? 'page' : $this->selection['groupId']; 
        
        // debug info
        $this->debug( ' group id: ' . $groupId );

        // group id is page
        if( $groupId == 'page' ){
        
            // get page parts
            return $this->getPageParts( );
            
        }
        // group id is page
        
        // get part parts
        return $this->getPartParts( $this->selection['type'], $groupId );
        
    }
    private function getPageParts(){
        
        // debug info
        $this->debug( ' getPageParts' );
        
        // part id is null / else
        if( $this->selection['partId'] == null ){
            
            // add selected group to open groups
            $this->addFirstItem( );
            
        }
        else {
            
            // add selected item group to open groups
            $this->addSelectedItemGroupToOpenGroups();

        }
        // part id is null / else

        // get items
        $siteItemsReadList = new SiteItemsReadList( $this->database, $this->selection );
        
        // read items
        $itemsList = $siteItemsReadList->read( );

        // add items can be child
        $itemsList = $this->addItemsCanBeChild( $itemsList );
        
        // get templates
        $templatesReadList = new TemplatesReadList( $this->database, $this->selection );
        
        // read templates
        $templatesList = $templatesReadList->read( );

        // add template can be child
        $templatesList = $this->addTemplatesCanBeChild( $templatesList );

        // create result
        $result = array(
            'items'     => $itemsList,
            'templates' => $templatesList
        );
        // create result
       
        // return result
        return $result;
        
    }
    private function getPartParts( $type, $groupId ){
                
        // type is site item / else
        if( $type == 'siteItem' ){
            
            // read templates list
            return $this->readItemsList( $groupId );
                    
        }
        else {
            
            // read templates list
            return $this->readTemplatesList( $groupId );
            
        }
        // type is site item / else
        
    }
    private function readItemsList( $groupId ){
        
        // get items
        $siteItemsReadList = new SiteItemsReadList( $this->database, $this->selection );

        // read items
        $itemsList = $siteItemsReadList->read( $groupId );

        // add items can be child
        $itemsList = $this->addItemsCanBeChild( $itemsList );
                
        // return items list
        return $itemsList;
        
    }
    private function readTemplatesList( $groupId ){
        
        // get templates
        $templatesReadList = new TemplatesReadList( $this->database, $this->selection );

        // read templates
        $templatesList = $templatesReadList->read( $groupId );

        // add template can be child
        $templatesList = $this->addTemplatesCanBeChild( $templatesList );
        
        // return templates list
        return $templatesList;
        
    }
    private function addSelectedItemGroupToOpenGroups( ){

        // is template / else
        if( isset( $this->selection['isTemplate'] ) && 
            $this->selection['isTemplate'] == 'true' ){
            
            // get part
            $part = SiteOptions::getOption( $this->database, $this->selection['partId'] );

            // add group to open groups
            $this->addParentGroupsToOpenGroups( $part->parent_id );
            
        }
        else {
            
            // get part item
            $partSiteItem = SiteItems::getSiteItemPart( $this->database, $this->selection['partId'] ); 
            
            // add group to open groups
            $this->addParentGroupsToOpenGroups( $partSiteItem->group_id );
            
        }
        // is template / else
        
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
    private function addFirstItem( ){

        // part id is null
        if( $this->selection['partId'] != null ){
            
            // done
            return;
            
        }
        // part id is null
        
        // create read parents
        $firstItem = SiteItems::getFirstPart( $this->database );

        // create read parents
        $readParents = new GroupsReadParents( $this->database );
        
        // call read parents
        $parents = $readParents->read( $firstItem->group_id );
        
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
    private function addTemplatesCanBeChild( $templatesList ){
        
        // loop over templates list
        foreach ( $templatesList['groups'] as $index => $item ){
        
            // has groups
            if( $item['type'] == 'template' ){
                
                // get child site item id
                $childSiteItem = SiteItems::getSiteItemPart( $this->database, $item['partId'] );
                
                // get item has child 
                $hasChild = SiteItemsChilden::itemHasItemAsChild( $this->database, 
                                                                  $this->selection['parent']['siteItemId'],  
                                                                  $childSiteItem->id );
                // get item has child 

                // has child
                $templatesList['groups'][$index]['canBeChild'] = $hasChild;
                
            }
            // has groups
            
            // has groups
            if( isset( $item['groups'] ) ){
                
                // call recursive
                $templatesList['groups'][$index] = $this->addTemplatesCanBeChild( $item );
                
            }
            // has groups
            
        }
        // loop over templates list
        
        // return list
        return $templatesList;
        
    }
}
