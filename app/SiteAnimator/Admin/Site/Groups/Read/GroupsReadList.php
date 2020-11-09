<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadListByType;

class GroupsReadList extends BaseClass {

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
        
        // get group id
        $groupId = $this->getGroupId( );
        
        // debug info
        $this->debug( 'GroupsReadList groupId: ' . $groupId );
        
        // choose what
        switch ( $this->selection['type'] ) {
            
            // routes
            case 'routes': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'routeGroup', 'name' );
                
            }
            // site items
            case 'siteItems': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'siteItemGroup', 'name' );
                
            }
            // templates
            case 'templates': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'templateGroup', 'name' );
                
            }
            // translations
            case 'translations': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'translationGroup', 'name' );
                
            }
            // lists
            case 'lists': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'listGroup', 'sequence' );
                
            }
            // animations
            case 'animations': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'animationGroup', 'name' );
                
            }
            // sequences
            case 'sequences': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'sequenceGroup', 'name' );
                
            }
            // media
            case 'media': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'mediaGroup', 'name' );
                
            }
            // css
            case 'css': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'cssGroup', 'name' );
                
            }
            // colors
            case 'colors': {
                
                // create list groups
                $listGroups = new GroupsReadListByType( $this->database, $this->selection );
                
                // get groups 
                return $listGroups->read( $groupId, 'colorGroup', 'name' );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( ' Site Groups error get, type not found: ' . $this->selection['type'] );
                
                // done with error
                return array( 'criticalError' => 'typeNotFound' );
                
            }
                    
        }        
        // done choose what
        
    }
    private function getGroupId( ){

        // create group id
        $groupId = null;
        
        // selection is set and group id is set
        if( isset( $this->selection ) && isset( $this->selection['groupId'] ) ){
            
            // set group id
            $groupId = $this->selection['groupId'];
            
        }
        // selection is set and group id is set
        
        // return result
        return $groupId;
        
    }
    
}
