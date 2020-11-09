<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsDelete.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Admin\Site\SiteItems\Delete\SiteItemsDelete;

class GroupsDelete extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $siteItemsDelete = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
        // create site item delete
        $this->siteItemsDelete = new SiteItemsDelete( $this->database, $this->appCode );
        
    }
    public function delete( $selection ){
        
        // find groups
        $this->findGroupGroups( $selection['id'] );
        
        // delete group
        $this->deleteGroup( $selection['id'] );

        // return ok
        return array( 'ok' );
        
    }
    private function findGroupGroups( $groupId ){
        
        // get groups
        $groups = SiteOptions::getOptionOptions( $this->database, $groupId );
        
        // loop over groups
        foreach( $groups as $index => $group ){
            
            // delete group recursive
            $this->findGroupGroups( $group->id );

            // delete group
            $this->deleteGroup( $group->id );
        
        }
        // loop over groups
        
    }
    private function deleteGroup( $groupId ) {
        
        // debug info
        $this->debug( 'group: ' . $groupId );

        // get site items
        $siteItems = SiteItems::getGroupSiteItems( $this->database, $groupId );
        
        // loop over site items
        foreach( $siteItems as $index => $siteItem ){
            
            // remove site item
            $this->siteItemsDelete->delete( array( 'id' => $siteItem->id ) );
            
        }
        // loop over  site items
        
        // delete group
        SiteOptionsDelete::deleteOption( $this->database, $groupId );        
        
    }
    
}
