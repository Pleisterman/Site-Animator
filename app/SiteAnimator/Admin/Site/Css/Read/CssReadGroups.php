<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       CssReadGroups.php
        function:   reads the css rows for a group or with no group  
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Css\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class CssReadGroups extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    private $selection = null;
    private $result = null;
    public function __construct( $database, $selection ) {
        
        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;

        // call parent
        parent::__construct();
        
    }
    public function read( $groupId ){
        
        // get rows
        $rows = SiteOptions::getGroupOptions( $this->database, 
                                              $groupId, 
                                              'cssGroup', 
                                              array( 'column' => 'sequence',
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
            $this->result[$row->name] = $this->addGroupToResult( $row, count( $rows ) );
            
        }
        // loop over groups
        
    }
    private function addGroupToResult( $row, $groupCount ) {

        // create result
        $result = array(
            'id'            =>  $row->id,
            'subject'       =>  'siteCss',
            'editType'      =>  'css',
            'groupType'     =>  'group',
            'isGroup'       =>  true,
            'groupCount'    =>  $groupCount,
            'sequence'      =>  $row->sequence,
            'name'          =>  $row->name,
            'updatedAt'     =>  $row->updated_at
        );
        // create result

        // collapsed / else
        if( isset( $this->selection['openGroups'] ) && in_array( $row->id, $this->selection['openGroups'] ) ){
        
            // get items
            $groupItems = $this->getGroupItems( $row->id );

            // has groups items / else
            if( count( $groupItems ) > 0 ){
            
                // set has items
                $result['hasItems'] = true;
                
                // set groups
                $result['items'] = $groupItems;
                
            }
            // has groups
                        
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
            
        }
        else {

            // set collapsed
            $result['collapsed'] = false;
            
            // has groups
            $result['hasGroups'] = $this->groupHasGroups( $row->id );

            // has items
            $result['hasItems'] = $this->groupHasItems( $row->id );

        }
        // collapsed / else
        
        // return result
        return $result;
            
    }
    private function groupHasItems( $groupId ){

        // create group items
        $readGroupitems = new CssReadGroupItems( $this->database, $this->selection );
        
        // return group items call
        return $readGroupitems->hasItems( $groupId );
        
    }
    private function getGroupItems( $groupId ){

        // create group items
        $readGroupitems = new CssReadGroupItems( $this->database, $this->selection );
        
        // read items
        return $readGroupitems->read( $groupId );

    }
    private function groupHasGroups( $groupId ){

        // get count
        $count = SiteOptions::getGroupCount( $this->database, $groupId, 'cssGroup' );

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
        $readGroupGroups = new CssReadGroups( $this->database, $this->selection );
        
        // read groups
        return $readGroupGroups->read( $groupId );
        
    }
    
}
