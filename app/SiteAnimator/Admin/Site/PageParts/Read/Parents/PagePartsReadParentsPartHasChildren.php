<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsReadParentsPartHasChildren.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 15-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Read\Parents;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Models\Site\SiteItemsChilden;

class PagePartsReadParentsPartHasChildren extends BaseClass {

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
    public function read( $part ){

        $partId = isset( $part['partId'] ) ? $part['partId'] : null;
        
        // part id is page
        if( $partId == 'page' ){
        
            // get page children
            return $this->pageHasChildren( );
            
        }
        // part id is page
        
        // get page children
        return $this->partHasChildren( $part );
        
    }
    private function pageHasChildren(){
        
        $this->debug( 'page has children function ' );
        
        // get page item
        $pageItem = SiteItems::getPageItem( $this->database );
        
        // item has children 
        $hasChildren = SiteItemsChilden::itemHasChildren( $this->database, $pageItem->id );
        $this->debug( 'pageitem: ' . $pageItem->id . ' hasChildren: ' . $hasChildren );
        return $hasChildren;
            
        
    }
    private function partHasChildren( $part ){
        
        $this->debug( 'partHasChildren function ' );
        
        // get site item id
        $siteItem = SiteItems::getPartItemId( $this->database, $part['id'] );

        // item has children 
        $hasChildren = SiteItemsChilden::itemHasChildren( $this->database, $siteItem->id );

        $this->debug( 'partItem: ' . $siteItem->id . ' hasChildren: ' . $hasChildren );
        return $hasChildren;
            
    }
    
}
