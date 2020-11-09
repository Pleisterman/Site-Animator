<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatePartReadParentList.php
        function:   
                    
        Last revision: 16-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Read\TemplateParts;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadParents;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesReadList;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Models\Site\SiteItemsChilden;

class TemplatePartReadParentList extends BaseClass {

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
        
        // add open groups
        $this->addOpenGroups();
        
        // create templates read list 
        $templatePartReadList = new TemplatesReadList( $this->database, $this->selection );
                
        // read template list
        $templateList = $templatePartReadList->read( );
     
        // create parents options
        $templateList['groups'] = $this->addChildOptions( $templateList['groups'] );
        
        // return result
        return $templateList;
        
    }
    private function addOpenGroups( ) {
        
        // get selected parent id
        $parentId = isset( $this->selection['parentId'] ) ? $this->selection['parentId'] : null; 
        
        // no selection
        if( $parentId == null ){
            
            // done
            return;
            
        }
        // no selection
        
        // create open groups
        $this->selection['openGroups'] = array();
        
        // add parent to open groups
        $this->addParentGroupToOpenGroups( $parentId );
            
    }
    private function addParentGroupToOpenGroups( $parentId ) {
        
        // create read parents
        $readParents = new GroupsReadParents( $this->database );
        
        // call read parents
        $this->selection['openGroups'] = $readParents->read( $parentId );
        
    }   
    private function addChildOptions( $groups ) {
        
        // loop over groups
        foreach( $groups as $index => $group ){

            // type is part
            if( $group['type'] == 'part' || $group['type'] == 'template' ){
                
                // 
                $this->debug( 'group: ' . json_encode($group) );
                
                // add site item id
                $groups[$index]['siteItemId'] = $this->getPartSiteItemId( $group['id'] );
                
                // add has children
                $groups[$index]['hasChildren'] = $this->partHasChildren( $groups[$index]['siteItemId'] );
                
            }
            // type is part
            
            // add child options
            if( isset( $group['groups'] ) ){
                
                // call recursive
                $groups[$index]['groups'] = $this->addChildOptions( $group['groups'] ); 
                
            }
            // add child options
            
        }
        // loop over groups
        
        // return result
        return $groups;
        
    }
    private function getPartSiteItemId( $partId ) {
        
        // 
        $this->debug( 'part id: ' . $partId );
                
        // get site item id
        $siteItem = SiteItems::getPartItemId( $this->database, $partId );

        // return id
        return $siteItem->id;
        
    }
    private function partHasChildren( $siteItemId ) {
        
        // item has children 
        $hasChildren = SiteItemsChilden::itemHasChildren( $this->database, $siteItemId );

        $this->debug( 'partItem: ' . $siteItemId . ' hasChildren: ' . $hasChildren );
        
        // return result
        return $hasChildren;
        
    }
    
}
