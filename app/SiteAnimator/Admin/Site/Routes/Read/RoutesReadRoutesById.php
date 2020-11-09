<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesReadRoutesById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 03-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Routes;
use App\SiteAnimator\Admin\Site\Translations\SiteObject\SiteObjectRead as ReadTranslation;
use App\SiteAnimator\Admin\Site\Lists\SiteObject\SiteObjectReadGroup as ReadListGroup;
use App\SiteAnimator\Admin\Site\Sequences\SiteObject\SiteObjectRead as ReadSequence;
use App\SiteAnimator\Admin\Site\Colors\SiteObject\SiteObjectRead as ReadColor;
use App\SiteAnimator\Admin\Site\Media\SiteObject\SiteObjectRead as ReadMedia;

class RoutesReadRoutesById extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;
        
        // debug info
        // debug info
        $this->debug( 'RoutesReadRoutesById routes Id: ' . $selection['id'] );
        
        // get route row
        $routeRow = Routes::getRouteById( $database, $selection['id'] );    
        
        // row ! found
        if( !$routeRow ){
            
            // return already deleted
            return array( 'error' => 'alreadyDeleted' );
            
        }
        // row ! found
        
        // create result
        return $this->createResult( $routeRow );
        
    }
    private function createResult( $routeRow ) {
        
        // create result
        return array(
            'id'                =>  $routeRow->id,
            'name'              =>  $routeRow->name,   
            'route'             =>  $routeRow->route,   
            'groupId'           =>  $routeRow->site_options_id,   
            'parentName'        =>  $this->getParentName( $routeRow->parent_id ),   
            'parentId'          =>  $routeRow->parent_id,   
            'languageId'        =>  $routeRow->language_id,   
            'isPublic'          =>  $this->decodeBoolean( $routeRow->is_public ),   
            'isMobile'          =>  $this->decodeBoolean( $routeRow->is_mobile ),   
            'isNotFoundPage'    =>  $this->decodeBoolean( $routeRow->is_not_found_page ),   
            'isErrorPage'       =>  $this->decodeBoolean( $routeRow->is_error_page ),   
            'isMaintenancePage' =>  $this->decodeBoolean( $routeRow->is_maintenance_page ),   
            'options'           =>  $this->enhanceOptions( json_decode( $routeRow->options, true ) ),   
            'updatedAt'         =>  $routeRow->updated_at
        );
        // create result
        
    }
    private function getParentName( $parentId ){
        
        // create parent name
        $parentName = null;
        
        // parent is null
        if( $parentId == null ){
            
            // done
            return $parentName;
            
        }
        // parent is null
        
        // get route row
        $routeRow = Routes::getRouteById( $this->database, $parentId );    
        
        // set parent name
        $parentName = $routeRow->name;


        // done
        return $parentName;
        
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
