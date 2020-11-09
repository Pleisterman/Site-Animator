<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatePartReadParentGroups.php
        function:   
                    
        Last revision: 16-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Read\TemplateParts;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class TemplatePartReadParentGroups extends BaseClass {

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
    public function read( $groupId ){
        
        // get template group rows
        $templateGroupRows = $this->getRows( $groupId, 'templateGroup' );

        // get template rows
        $templateRows = $this->getRows( $groupId, 'template' );
        
        // return result
        return array_merge( $templateRows, $templateGroupRows );
        
    }
     private function getRows( $groupId, $type ) {
       
        // get rows
        $rows = SiteOptions::getGroupOptions( $this->database, 
                                              $groupId, 
                                              $type, 
                                              array( 'column' => 'name',
                                                     'direction' => 'ASC'
                                                    ));
        // get rows
        
        // create result
        $this->createResult( $rows );

        // return result
        return $this->result;
        
    }
    private function createResult( $rows ){
        
        // create empty result
        $this->result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // create group
            $this->result[$row->name] = $this->addGroupToResult( $row );
            
        }
        // loop over groups
        
    }
    private function addGroupToResult( $row ) {

        // create result
        $result = array(
            'id'            =>  $row->id,
            'subject'       =>  'siteTemplates',
            'editType'      =>  'templates',
            'isGroup'       =>  true,
            'name'          =>  $row->name,
            'type'          =>  $row->type == 'templateGroup' ? 'group' : 'template' 
        );
        // create result

        // set group type 
        $result['groupType'] = $row->type == 'templateGroup' ? 'group' : 'template';
        
        // is template
        if( $result['groupType'] == 'template' ){
        
            // add part id
            $result['partId'] = $row->part_id;
            
        }
        // is template
        
        // collapsed / else
        if( isset( $this->selection['openGroups'] ) && in_array( $row->id, $this->selection['openGroups'] ) ){
        
            // get groups
            $groupGroups = $this->getGroupGroups( $row->id );

            // has groups
            if( count( $groupGroups ) > 0 ){
            
                // set has groups
                $result['hasGroups'] = true;

                // set groups
                $result['groups'] = $groupGroups;
                
            }
            // has groups
            
            // set collapsed
            $result['collapsed'] = false;
            
        }
        else {

            // has groups
            $result['hasGroups'] = $this->groupHasGroups( $row->id );

        }
        // collapsed / else
        
        // return result
        return $result;
            
    }
    private function groupHasGroups( $groupId ){

        // get count
        $count = SiteOptions::getGroupCount( $this->database, $groupId, 'templateGroup' );

        // get count
        $count += SiteOptions::getGroupCount( $this->database, $groupId, 'template' );
        
        // count > 0 / else
        if( $count > 0 ){
           
            // return has groups
            return true;
            
        }
        else {
            
            // return ! has groups
            return false;
            
        }
        // count > 0 / else
        
    }
    private function getGroupGroups( $groupId ){

        // create group groups
        $readGroupGroups = new TemplatePartReadParentGroups( $this->database, $this->selection );
        
        // read groups
        return $readGroupGroups->read( $groupId );
        
    }
    
}
