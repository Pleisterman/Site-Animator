<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsRead.php
        function:   
                    
        Last revision: 15-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\PageParts\Read\PagePartsReadList;
use App\SiteAnimator\Admin\Site\PageParts\Read\PagePartsReadById;
use App\SiteAnimator\Admin\Site\PageParts\Read\Parents\PagePartsReadParents;
use App\SiteAnimator\Admin\Site\PageParts\Read\ChildParts\PagePartsReadChildParts;

class PagePartsRead extends BaseClass {

    protected $debugOn = true;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read page parts list
                $readlist = new PagePartsReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // parents
            case 'parents': {
                
                // create read parents
                $readParents = new PagePartsReadParents( $this->database, $selection );

                // return parents call
                return $readParents->read( );
                
            }
            // child parts
            case 'childParts': {
                
                // create read parent child parts
                $readChildParts = new PagePartsReadChildParts( $this->database, $selection );

                // return parent child parts call
                return $readChildParts->read( );
                
            }
            // byId
            case 'byId': {

                // create page parts by id
                $pageParts = new PagePartsReadById();

                // call page parts by id
                return $pageParts->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'PageParts error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
