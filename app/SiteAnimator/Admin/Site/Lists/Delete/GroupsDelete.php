<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsDelete.php
        function:   
                    
        Last revision: 18-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;
use App\SiteAnimator\Models\Site\SiteListsOrder;
use App\SiteAnimator\Admin\Site\Lists\Delete\ListsDelete;

class GroupsDelete extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $listsDelete = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
        // create lists delete
        $this->listsDelete = new ListsDelete( $this->database, $this->appCode );
        
    }
    public function delete( $selection ){
        
        // find groups
        $this->findGroupGroups( $selection['id'] );
        
        // delete group
        $this->deleteGroup( $selection['id'] );

        // reorder
        SiteListsOrder::reOrder( $this->database, $selection['parentId'] );
        
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

        // get csss
        $children = SiteOptions::getOptionOptions( $this->database, $groupId );
        
        // loop over children
        foreach( $children as $index => $child ){
            
            // remove children
            $this->listsDelete->delete( array( 'id' => $child->id ) );
            
        }
        // loop over children
        
        // delete group
        SiteOptionsDelete::deleteOption( $this->database, $groupId );        
        
    }
    
}
