<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsUpdate.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Groups\Update\Common\GroupsUpdate as CommonGroupsUpdate;
use App\SiteAnimator\Admin\Site\Media\Groups\GroupsUpdate as MediaGroupsUpdate;

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
        
        // choose type 
        switch ( $data['type'] ) {
                        
            // route group
            case 'routeGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // site item group
            case 'siteItemGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // template group
            case 'templateGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // translation group
            case 'translationGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // list group
            case 'listGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // animation group
            case 'animationGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // sequence group
            case 'sequenceGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // media group
            case 'mediaGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new MediaGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // css group
            case 'cssGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // color group
            case 'colorGroup': {
                
                // create common groups update
                $commonGroupsUpdate = new CommonGroupsUpdate( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsUpdate->update( $selection, $data );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'GroupsUpdate error insert, type not found: ' . isset( $data['type'] ) ? $data['type'] : 'type not set' );
                
                // done with error
                return array( 'criticalError' => 'typeNotFound' );
                
            }
            
        }        
        // done choose type
        
    }    
}
