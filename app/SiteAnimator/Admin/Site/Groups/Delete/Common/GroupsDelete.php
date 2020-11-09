<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsDelete.php
        function:   
                    
        Last revision: 07-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Delete\Common;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class GroupsDelete extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $type = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function delete( $selection ){
        
        // set type
        $this->type = $selection['type'];
        
        // find groups
        $this->findGroupGroups( $selection['id'] );
        
        // delete group
        $this->deleteGroup( $selection['id'] );

        // return ok
        return array( 'ok' );
        
    }
    private function findGroupGroups( $groupId ){
        
        // get groups
        $groups = SiteOptions::getOptionOptions( $this->database, $groupId, $this->type );
        
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

        // get groups
        $groups = SiteOptions::getOptionOptions( $this->database, $groupId, $this->type );
        
        // loop over groups
        foreach( $groups as $index => $group ){
            
            // delete group recursive
            $this->findGroupGroups( $group->id );

            // delete group
            $this->deleteGroup( $group->id );
        
        }
        // loop over children
        
        // delete items 
        
        
        
    }
}
