<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TranslationsReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 03-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\Read;

use App\Http\Base\BaseClass;
use App\Common\Models\Translations;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadParents;
use App\SiteAnimator\Admin\Site\Translations\Read\TranslationsReadGroups;
use App\SiteAnimator\Admin\Site\Translations\Read\TranslationsReadGroupItems;

class TranslationsReadList extends BaseClass {

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
        $this->debug( 'TranslationsReadList groupId: ' . $groupId );
                
        // add selected item group to open groups
        $this->addSelectedItemToOpenGroups();
        
        // create translations read groups 
        $translationsReadGroups = new TranslationsReadGroups( $this->database, $this->selection );
        
        // create translations read group items
        $translationsReadGroupItems = new TranslationsReadGroupItems( $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $translationsReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $translationsReadGroups->read( $groupId );
        
        // return result
        return $result;
        
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
    private function addSelectedItemToOpenGroups( ){

        // selection is set and selected item id is set
        if( isset( $this->selection ) && isset( $this->selection['selectedItemId'] ) &&
            $this->selection['selectedItemId'] != null ){
        
            // get translation row
            $translationIdRow = Translations::getTranslationIdRow( $this->database, 
                                                                   false, 
                                                                   $this->selection['selectedItemId'] );    
            // get translation row
            
            // group id ! null
            if( $translationIdRow->groupId != null ){
                
                // add selected group to open groups
                $this->addSelectedGroupToOpenGroups( $translationIdRow->groupId );
                
            }
            // group id ! null
            
        }
        // selection is set and selected item id is set
        
    }
    private function addSelectedGroupToOpenGroups( $groupId ){
 
        // default open groups
        isset( $this->selection['openGroups'] ) ? 
            $this->selection['openGroups'] : 
            $this->selection['openGroups'] = array();
        // default open groups

        // add group to open groups
        array_push( $this->selection['openGroups'], $groupId );
        
        // create read parents
        $readParents = new GroupsReadParents( $this->database );
        
        // call read parents
        $parents = $readParents->read( $groupId );
        
        // loop over parents
        for( $i = 0; $i < count( $parents ); $i++ ){

            // not in open groups
            if( !in_array( $parents[$i], $this->selection['openGroups'] ) ){
                
                // add to open groups
                array_push( $this->selection['openGroups'], $parents[$i] );
                
            } 
            // not in open groups
            
        }
        // loop over groups
        
    }
    
}
