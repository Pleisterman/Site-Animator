<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsInsert.php
        function:   
                    
        Last revision: 30-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Groups\Insert\Common\GroupsInsert as CommonGroupsInsert;
use App\SiteAnimator\Admin\Site\Groups\Insert\Sequenced\GroupsInsert as SequencedGroupsInsert;
use App\SiteAnimator\Admin\Site\Media\Groups\GroupsInsert as MediaGroupsInsert;

class GroupsInsert extends BaseClass {

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
    public function insert( $data ){
        
        // choose type 
        switch ( $data['type'] ) {
                        
            // route group
            case 'routeGroup': {
                
                // create common groups insert
                $commonGroupsInsert = new CommonGroupsInsert( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsInsert->insert( $data );
                
            }
            // template group
            case 'templateGroup': {
                
                // create common groups insert
                $commonGroupsInsert = new CommonGroupsInsert( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsInsert->insert( $data );
                
            }
            // site item group
            case 'siteItemGroup': {
                
                // create common groups insert
                $commonGroupsInsert = new CommonGroupsInsert( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsInsert->insert( $data );
                
            }
            // translation group
            case 'translationGroup': {
                
                // create common groups insert
                $commonGroupsInsert = new CommonGroupsInsert( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsInsert->insert( $data );
                
            }
            // list group
            case 'listGroup': {
                
                // create sequenced groups insert
                $sequencedGroupsInsert = new SequencedGroupsInsert( $this->database, $this->appCode );
                
                // return sequenced groups call
                return $sequencedGroupsInsert->insert( $data );
                
            }
            // animation group
            case 'animationGroup': {
                
                // create common groups insert
                $commonGroupsInsert = new CommonGroupsInsert( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsInsert->insert( $data );
                
            }
            // sequence group
            case 'sequenceGroup': {
                
                // create common groups insert
                $commonGroupsInsert = new CommonGroupsInsert( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsInsert->insert( $data );
                
            }
            // media group
            case 'mediaGroup': {
                
                // create media groups insert
                $mediaGroupsInsert = new MediaGroupsInsert( $this->database, $this->appCode );
                
                // return media groups call
                return $mediaGroupsInsert->insert( $data );
                
            }
            // css group
            case 'cssGroup': {
                
                // create common groups insert
                $commonGroupsInsert = new CommonGroupsInsert( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsInsert->insert( $data );
                
            }
            // color group
            case 'colorGroup': {
                
                // create common groups insert
                $commonGroupsInsert = new CommonGroupsInsert( $this->database, $this->appCode );
                
                // return common groups call
                return $commonGroupsInsert->insert( $data );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'GroupsInsert error insert, type not found: ' . isset( $data['type'] ) ? $data['type'] : 'type not set' );
                
                // done with error
                return array( 'criticalError' => 'typeNotFound' );
                
            }
            
        }        
        // done choose type
                
    }
    
}
