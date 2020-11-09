<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsRead.php
        function:   
                    
        Last revision: 09-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\SiteItems\Read\SiteItemsReadList;
use App\SiteAnimator\Admin\Site\SiteItems\Read\Parts\SiteItemsReadPartsList;
use App\SiteAnimator\Admin\Site\SiteItems\Read\Files\SiteItemsReadFileList;
use App\SiteAnimator\Admin\Site\SiteItems\Read\Parents\SiteItemsReadList as SiteItemsReadParentsList;
use App\SiteAnimator\Admin\Site\SiteItems\Read\SiteItemsReadSiteItemsById;

class SiteItemsRead extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read site items list
                $readlist = new SiteItemsReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // parts list
            case 'partsList': {
                
                // create read site items parts list
                $readlist = new SiteItemsReadPartsList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // file list
            case 'fileList': {
                
                // create read site items file list
                $readlist = new SiteItemsReadFileList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // parents list
            case 'parentsList': {
                
                // create read site parents list
                $parentsList = new SiteItemsReadParentsList( $this->database, $selection );

                // return list call
                return $parentsList->read( );
                
            }
            // item children
            case 'itemChildren': {
                
                // create read site items item children
                $readItemChildren = new SiteItemsReadItemChildren( $this->database, $selection );

                // return list call
                return $readItemChildren->read( );
                
            }
            // byId
            case 'byId': {

                // create site items by id
                $siteItemsById = new SiteItemsReadSiteItemsById();

                // call site items by id
                return $siteItemsById->read( $this->database, $selection );
                
            }
            // partOfItem
            case 'partOfItem': {

                // create site items part by item id
                $siteItemsPartByItemId = new SiteItemsReadSiteItemsPartByItemId();

                // call site items part by item id
                return $siteItemsPartByItemId->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'SiteItems error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
