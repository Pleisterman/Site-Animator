<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsUpdateSave.php
        function:   
                    
        Last revision: 01-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Update\Common;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionGroups;

class GroupsUpdateSave extends BaseClass {

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
    public function save( $selection, $data ){
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // update group
        SiteOptionGroups::updateGroup( $this->database,
                                       $selection,
                                       $data,
                                       $updatedAt );
        // update group
        
        // return updated at
        return array( 'updatedAt' => $updatedAt );
    }        
    
}
