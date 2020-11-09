<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsInsertSave.php
        function:   
                    
        Last revision: 01-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Insert\Common;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionGroups;

class GroupsInsertSave extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function save( $data ){
        
        $this->debug( 'group: ' . json_decode( $data['name'] ) );
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // insert group
        $groupId = SiteOptionGroups::insertGroup( $this->database,
                                                  $data,
                                                  $updatedAt );
        // insert group

        // return group id
        return array( 'groupId' => $groupId );
        
    }        
    
}
