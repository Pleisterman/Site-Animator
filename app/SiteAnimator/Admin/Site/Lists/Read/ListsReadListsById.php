<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsReadListsById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 05-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Admin\Site\Routes\SiteObject\SiteObjectRead as ReadRoute;
use App\SiteAnimator\Admin\Site\Translations\SiteObject\SiteObjectRead as ReadTranslation;
use App\SiteAnimator\Admin\Site\Sequences\SiteObject\SiteObjectRead as ReadSequence;
use App\SiteAnimator\Admin\Site\Css\SiteObject\SiteObjectRead as ReadCss;
use App\SiteAnimator\Admin\Site\Colors\SiteObject\SiteObjectRead as ReadColor;
use App\SiteAnimator\Admin\Site\Media\SiteObject\SiteObjectRead as ReadMedia;

class ListsReadListsById extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // debug info
        $this->debug( 'ListsReadList list item Id: ' . $selection['id'] );
        
        // remember database
        $this->database = $database;
            
        // get row
        $listItemRow = SiteOptions::getOption( $database, $selection['id'] );
        
        // row ! found
        if( !$listItemRow ){
            
            // return already deleted
            return array( 'error' => 'alreadyDeleted' );
            
        }
        // row ! found
        
        // create result
        return $this->createResult( $listItemRow );
        
    }
    private function createResult( $listItemRow ) {
        
        // create result
        return array(
            'id'            =>  $listItemRow->id,
            'name'          =>  $listItemRow->name,   
            'isPublic'      =>  $this->decodeBoolean( $listItemRow->public ),   
            'groupId'       =>  $listItemRow->parent_id,   
            'options'       =>  $this->enhanceOptions( json_decode( $listItemRow->value, true ) ),   
            'updatedAt'     =>  $listItemRow->updated_at
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
        
        // is route
        if( isset( $options['route'] ) ){
        
            // create read
            $readRoute = new ReadRoute( $this->database );
            
            // read route
            $options = $readRoute->read( $options );
            
        }
        // is route
        
        // is translation
        if( isset( $options['translation'] ) ){
        
            // create read
            $readTranslation = new ReadTranslation( $this->database );
            
            // read translation
            $options = $readTranslation->read( $options );
            
        }
        // is translation

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
