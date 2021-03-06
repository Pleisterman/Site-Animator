<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsReadPageParts.php
        function:   reads the site options rows for a group or with no group  
                    
        Last revision: 19-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\PageParts\Read\PagePartsReadParts;
use App\SiteAnimator\Models\Site\SiteOptions;

class PagePartsReadPageParts extends BaseClass {

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
    public function read( $pageId ){
        
        // get rows
        $rows = SiteOptions::getPageOptions( $this->database, $pageId, true );

        // create result
        $this->createResult( $rows );

        // return result
        return $this->result;
        
    }
    private function createResult( $rows ){
        
        // create empty result
        $this->result = array(
            'groups' => array()
        );
        
        // loop over rows
        forEach( $rows as $row ) {

            // create group
            array_push( $this->result['groups'], $this->addPagePartToResult( $row, count( $rows ) ) );
            
        }
        // loop over groups
        
    }
    private function addPagePartToResult( $row, $groupCount ) {

        // create result
        $result = array(
            'id'            =>  $row->id,
            'subject'       =>  'sitePageParts',
            'editType'      =>  'pageParts',
            'groupType'     =>  'pageParts',
            'groupCount'    =>  $groupCount,
            'isGroup'       =>  true,
            'isTemplate'    =>  $this->decodeBoolean( $row->is_template ),
            'hasItems'      =>  false,
            'name'          =>  $row->name,
            'sequence'      =>  $row->sequence,
            'updatedAt'     =>  $row->updated_at
            
        );
        // create result

        // is template / else
        if( $row->is_template == 1 ){
            
            // set group type
            $result['groupType'] = 'templates';
            
        }        
        // is template / else
        
        // collapsed / else
        if( isset( $this->selection['openGroups'] ) && in_array( $row->id, $this->selection['openGroups'] ) ){
        
            // is template
            if( $row->is_template == 1 ){

                $this->debug( 'template found' );
                
                // add template parts
                $parts = $this->getPartParts( $row->part_id );

            } 
            else {

                // get parts
                $parts = $this->getPartParts( $row->id );

            }
            // is template
 
            // has parts
            if( count( $parts['groups'] ) > 0 ){

                // set has groups
                $result['hasGroups'] = true;

                // set groups
                $result['groups'] = $parts['groups'];

            }
            else {

                // set ! has groups
                $result['hasGroups'] = false;

            }
            // has parts


        }
        else {

            // set collapsed
            $result['collapsed'] = false;
            
            // has groups
            $result['hasGroups'] = $this->partHasParts( $row->id );

        }
        // collapsed / else
        
        // return result
        return $result;
            
    }
    private function partHasParts( $partId ){

        // get count
        $count = SiteOptions::getOptionOptionCount( $this->database, $partId );

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
    private function getPartParts( $partId ){

        // create parts
        $readParts = new PagePartsReadParts( $this->database, $this->selection );
        
        // read parts
        return $readParts->read( $partId );
        
    }
    private function decodeBoolean( $value ){
        
        // is 0 or false
        if( $value == 0 || $value == false ){
            
            // return result
            return false;
            
        }
        // is 0 or false
        
        // return result
        return true;
        
    }
        
}
