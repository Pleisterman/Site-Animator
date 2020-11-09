<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesReadGroupItems.php
        function:   reads the template rows for a group or group is null 
                    checks if a group has items
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class TemplatesReadGroupItems extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    private $selection = null;
    private $groupId = null;
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

        // remember group id
        $this->groupId = $groupId; 
        
        // get item rows
        $rows = SiteOptions::getOptionParts( $this->database, 
                                             $groupId );
        // get item rows

        // create result
        $this->createResult( $rows );

        // return result
        return $this->result;
        
    }
    public function hasItems( $groupId ){
        
        // get count
        $count = SiteOptions::getOptionPartsCount( $this->database, $groupId );
        
        // count > 0
        if( $count > 0 ){
            
            // has groups
            return true;
            
        }
        // count > 0
        
        // no groups                       
        return false;
        
    }
    private function createResult( $rows ){
        
        // create empty result
        $this->result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // add item
            $this->addItemToResult( $row, count( $rows ) );
            
        }
        // loop over rows

    }
    private function addItemToResult( $row, $groupCount ){
        
        // create item array
        $item = array(
            'id'                =>   $row->id,
            'subject'           =>  'siteTemplates',
            'editType'          =>   'templates',
            'groupType'         =>   $row->type == 'template' ? 'templates' : 'pageParts',
            'isGroup'           =>   true,
            'name'              =>   $row->name,
            'title'             =>   $this->getItemTitle( $row ),
            'groupId'           =>   $this->groupId,
            'partId'            =>   $row->part_id,
            'type'              =>   'part',
            'sequence'          =>  $row->sequence,
            'groupCount'        =>  $groupCount,
            'updatedAt'         =>  $row->updated_at,
        );
        // create item array
            
        // collapsed / else
        if( isset( $this->selection['openGroups'] ) && in_array( $row->id, $this->selection['openGroups'] ) ){
        
            // get items
            $items = $this->getItems( $row->id );

            // has items / else
            if( count( $items ) > 0 ){
            
                // set has groups
                $item['hasGroups'] = true;
                
                // set groups
                $item['groups'] = $items;
                
            }
            // has items
                        
            // set collapsed
            $item['collapsed'] = false;
            
        }  
        else {

            // has groups
            $item['hasGroups'] = $this->itemHasItems( $row->id );

        }
        // collapsed / else
            
        // add item to result
        $this->result[$item['name']] = $item;
            
    }
    private function getItemTitle( $row ){
        
        // create title
        $title = '<nobr>' . $row->name . '</nobr>';

        // return title
        return $title;
            
    }
    private function itemHasItems( $itemId ){

        // create group items
        $readGroupitems = new TemplatesReadGroupItems( $this->database, $this->selection );
        
        // return group items call
        return $readGroupitems->hasItems( $itemId );
        
    }
    private function getItems( $itemId ){

        // create group items
        $readGroupitems = new TemplatesReadGroupItems( $this->database, $this->selection );
        
        // read items
        return $readGroupitems->read( $itemId );

    }
    
}
