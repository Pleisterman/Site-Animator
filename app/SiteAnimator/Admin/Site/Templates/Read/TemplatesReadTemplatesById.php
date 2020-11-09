<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesReadTemplatesById.php
        function:   reads the template rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Admin\Site\Translations\SiteObject\SiteObjectRead as ReadTranslation;
use App\SiteAnimator\Admin\Site\Lists\SiteObject\SiteObjectReadGroup as ReadListGroup;
use App\SiteAnimator\Admin\Site\Sequences\SiteObject\SiteObjectRead as ReadSequence;
use App\SiteAnimator\Admin\Site\Css\SiteObject\SiteObjectRead as ReadCss;
use App\SiteAnimator\Admin\Site\Colors\SiteObject\SiteObjectRead as ReadColor;
use App\SiteAnimator\Admin\Site\Media\SiteObject\SiteObjectRead as ReadMedia;

class TemplatesReadTemplatesById extends BaseClass {

    protected $debugOn = true;
    protected $database = true;
    public function read( $database, $selection ){

        // debug info
        $this->debug( 'TemplatesReadList template id: ' . $selection['id'] );
        
        // remember database
        $this->database = $database;
        
        // get row
        $row = SiteOptions::getOption( $this->database, $selection['id'] );    
        
        $this->debug( 'id: ' . $row->id . ' part:' . $row->part_id );
        
        // get item row
        $itemRow = SiteItems::getSiteItemPart( $database, $row->part_id );
        
        // create result
        return $this->createResult( $row, $itemRow );
            
    }
    private function createResult( $templateRow, $itemRow ) {
        
        // create result
        return array(
            'id'                =>  $templateRow->id,
            'name'              =>  $templateRow->name,   
            'groupId'           =>  $templateRow->parent_id,   
            'partId'            =>  $templateRow->part_id,   
            'siteItemId'        =>  $itemRow->id,   
            'siteItemGroupId'   =>  $itemRow->group_id,   
            'options'           =>  $this->enhanceOptions( json_decode( $templateRow->value, true ) ),   
            'updatedAt'         =>  $templateRow->updated_at
        );
        // create result
        
    }
    private function enhanceOptions( $options ){
                
        // loop over options
        foreach( $options as $key => $value ) {
 
            // site object exists
            if( isset( $value['siteObject'] ) ) {
                
                // get site object
                $options[$key] = $this->getSiteObject( $value );
                
            }
            // site object exists
            
            
            // is array
            if ( is_array( $value ) ) {
                
                // call recursive
                $options[$key] = $this->enhanceOptions( $options[$key] );
                
            }
            // is array
            
        }
        // loop over options        
        
        // return result       
        return $options;        
        
    }
    private function getSiteObject( $options ){
        
        // is translation
        if( isset( $options['translation'] ) ){
        
            // create read
            $readTranslation = new ReadTranslation( $this->database );
            
            // read translation
            $options = $readTranslation->read( $options );
            
        }
        // is translation

        // is list group
        if( isset( $options['listGroup'] ) ){
        
            // create read
            $readListGroup = new ReadListGroup( $this->database );
            
            // read list group
            $options = $readListGroup->read( $options );
            
        }
        // is list group
        
        // is css
        if( isset( $options['css'] ) ){
        
            // create read
            $readCss = new ReadCss( $this->database );
            
            // read css
            $options = $readCss->read( $options );
            
        }
        // is css
        
        // is color
        if( isset( $options['color'] ) ){
        
            // create read
            $readColor = new ReadColor( $this->database );
            
            // read translation
            $options = $readColor->read( $options );
            
        }
        // is color
        
        // is media
        if( isset( $options['media'] ) ){
        
            // create read
            $readMedia = new ReadMedia( $this->database );
            
            // read media
            $options = $readMedia->read( $options );
            
        }
        // is media
        
        // is sequence
        if( isset( $options['sequence'] ) ){
        
            // create read
            $readSequence = new ReadSequence( $this->database );
            
            // read sequence
            $options = $readSequence->read( $options );
            
        }
        // is sequence
        
        
        // return result
        return $options;
        
    }
    
}
