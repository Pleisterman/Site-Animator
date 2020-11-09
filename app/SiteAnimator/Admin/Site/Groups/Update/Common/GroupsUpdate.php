<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsUpdate.php
        function:   
                    
        Last revision: 01-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Update\Common;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Groups\Update\Common\GroupsPrepareUpdate;
use App\SiteAnimator\Admin\Site\Groups\Update\Common\GroupsUpdateSave;

class GroupsUpdate extends BaseClass {

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
    public function update( $selection, $data ){
        
        // construct prepare update
        $prepareUpdate = new GroupsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct groups save
        $groupSave = new GroupsUpdateSave( $this->database, $this->appCode );

        // save group        
        return $groupSave->save( $selection, $data );
        
    }
    
}
