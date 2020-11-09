<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RouteReadParentList.php
        function:   
                    
        Last revision: 24-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Routes;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadParents;
use App\SiteAnimator\Admin\Site\Routes\Read\RoutesReadList;

class RouteReadParentList extends BaseClass {

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
        
        // create routes read list 
        $routesReadList = new RoutesReadList( $this->database, $this->selection );
                
        // read routes list
        $routeList = $routesReadList->read( );
     
        // return result
        return $routeList;
        
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

        // get parent route row
        $parentRow = Routes::getRouteById( $this->database, $parentId );    
        
        // create read parents
        $readParents = new GroupsReadParents( $this->database );
        
        // no parent group
        if( $parentRow->site_options_id == null ){
            
            // done
            return;
            
        }
        // no parent group
        
        // call read parents
        $this->selection['openGroups'] = $readParents->read( $parentRow->site_options_id );
        
    }   
    
}
