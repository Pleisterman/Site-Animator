<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsReadParentsPartHasChildTemplates.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 15-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Read\Parents;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Models\Site\SiteItemsChilden;

class PagePartsReadParentsPartHasChildTemplates extends BaseClass {

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
        
            // get page child templates
            return $this->pageHasChildTemplates( );
            
        }
        // part id is page
        
        // get part child templates 
        return $this->partHasChildTemplates( $part, $partId );
        
    }
    private function pageHasChildTemplates(){
        
        $this->debug( 'page has childtemplates function ' );
        
        // get page item
        $pageItem = SiteItems::getPageItem( $this->database );
        
        // item id is set
        if( isset( $this->selection['siteItemId'] ) ){

            $this->debug( 'child: ' . $this->selection['siteItemId'] );
            
            // item has children 
            $hasChildren = SiteItemsChilden::itemHasTemplatesWithChild( $this->database, 
                                                                $pageItem->id, 
                                                                $this->selection['siteItemId'] );
            
            $this->debug( 'pageitem: ' . $pageItem->id . ' childtemplates: ' . $hasChildren );
            return $hasChildren;
        }
        else {
            
            // item has children 
            $hasChildren = SiteItemsChilden::itemHasTemplates( $this->database, $pageItem->id );
            $this->debug( 'pageitem: ' . $pageItem->id . ' childtemplates: ' . $hasChildren );
            return $hasChildren;
            
        }
        // item id is set
        
    }
    private function partHasChildTemplates( $part, $partId ){
        
       $this->debug( 'part has childtemplates function ' );
        

        // is template / else
        if( $part['isTemplate'] == 1 ){
            
            // get template part
            $partPart = SiteOptions::getOption( $this->database, $part['id'] );
            
            // get template part
            $templatePart = SiteOptions::getOption( $this->database, $partPart->part_id );
            
            // get site item id
            $siteItem = SiteItems::getPartItemId( $this->database, $templatePart->id );

        }
        else {
            
            // get site item id
            $siteItem = SiteItems::getPartItemId( $this->database, $part['id'] );

        }
        // is template / else
        
        $this->debug( ' item id: ' . $siteItem->id );
        
        // item id is set
        if( isset( $this->selection['siteItemId'] ) ){

            // item has children 
            $hasChildren =  SiteItemsChilden::itemHasTemplatesWithChild( $this->database, 
                                                                $siteItem->id, 
                                                                $this->selection['siteItemId'] );
            // item has children 
        
            $this->debug( 'partItem: ' . $siteItem->id . ' childtemplates: ' . $hasChildren );
            return $hasChildren;
            }
        else {
            
            // item has children 
            $hasChildren =   SiteItemsChilden::itemHasTemplates( $this->database, $siteItem->id );
            $this->debug( 'partItem: ' . $siteItem->id . 'childtemplates: ' . $hasChildren );
            return $hasChildren;
            
        }
        // item id is set

    }
}
