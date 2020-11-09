<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsReadById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 29-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Admin\Site\Translations\SiteObject\SiteObjectRead as ReadTranslation;
use App\SiteAnimator\Admin\Site\Lists\SiteObject\SiteObjectReadGroup as ReadListGroup;
use App\SiteAnimator\Admin\Site\Animations\SiteObject\SiteObjectRead as ReadAnimation;
use App\SiteAnimator\Admin\Site\Sequences\SiteObject\SiteObjectRead as ReadSequence;
use App\SiteAnimator\Admin\Site\Css\SiteObject\SiteObjectRead as ReadCss;
use App\SiteAnimator\Admin\Site\Colors\SiteObject\SiteObjectRead as ReadColor;
use App\SiteAnimator\Admin\Site\Media\SiteObject\SiteObjectRead as ReadMedia;

class PagePartsReadById extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;
        
        // debug info
        $this->debug( 'PageParts Id: ' . $selection['id'] );
        
        // get page parts row
        $pagePartsRow = SiteOptions::getOption( $database, $selection['id'] );    
        
        // create result
        return $this->createResult( $pagePartsRow );
        
    }
    private function createResult( $pagePartsRow ) {
        
        // get row
        $pagePartPartRow = SiteOptions::getOption( $this->database, $pagePartsRow->part_id );

        // get type
        $type = $pagePartPartRow->type;
            
        // create result
        return array(
            'id'            =>  $pagePartsRow->id,
            'name'          =>  $pagePartsRow->name,   
            'type'          =>  $type,   
            'isPublic'      =>  $this->decodeBoolean( $pagePartsRow->public ),   
            'isTemplate'    =>  $this->decodeBoolean( $pagePartsRow->is_template ),   
            'partId'        =>  $pagePartsRow->part_id,   
            'parentId'      =>  $pagePartsRow->parent_id,   
            'siteItemId'    =>  $this->getSiteItemId( $pagePartsRow, $pagePartPartRow ),   
            'options'       =>  $this->enhanceOptions( json_decode( $pagePartsRow->value, true ) ),   
            'updatedAt'     =>  $pagePartsRow->updated_at,
        );
        // create result
        
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
        
        // is color
        if( isset( $options['color'] ) ){
        
            // create read
            $readColor = new ReadColor( $this->database );
            
            // read color
            $options = $readColor->read( $options );
            
        }
        // is color
        
        // is css
        if( isset( $options['css'] ) ){
        
            // create read
            $readCss = new ReadCss( $this->database );
            
            // read css
            $options = $readCss->read( $options );
            
        }
        // is css
        
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
        
        // is animation
        if( isset( $options['animation'] ) ){
        
            // create read
            $readAnimation = new ReadAnimation( $this->database );
            
            // read animation
            $options = $readAnimation->read( $options );
            
        }
        // is animation        
        
        // return result
        return $options;
        
    }
    private function getSiteItemId( $pagePartsRow, $pagePart ){
        
        // create result 
        $result = null;
        
        // ! is template
        if( $pagePartsRow->is_template == 0 ){
        
            // get site item
            $siteItem = SiteItems::getSiteItemPart( $this->database, $pagePart->id );

            // set result
            $result = $siteItem->id;
            
        }
        // ! is template
        
        // return result;
        return $result;
        
    }
    
}
