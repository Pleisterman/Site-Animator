<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       CssReadCssById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Css\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class CssReadCssById extends BaseClass {

    protected $debugOn = true;
    public function read( $database, $selection ){

        // debug info
        $this->debug( 'CssReadList css id: ' . $selection['id'] );
        
        // get css row
        $cssRow = SiteOptions::getOption( $database, $selection['id'] );    
        
        // row ! found
        if( !$cssRow ){
            
            // return not found
            return array( 'error' => 'css not found' );
            
        }
        // row ! found
        
        // create result
        return $this->createResult( $cssRow );
        
    }
    private function createResult( $cssRow ) {
        
        // create result
        return array(
            'id'            =>  $cssRow->id,
            'name'          =>  $cssRow->name,   
            'groupId'       =>  $cssRow->parent_id,   
            'isPublic'      =>  $cssRow->public == 1 ? true : false,   
            'options'       =>  $this->enhanceOptions( json_decode( $cssRow->value, true ) ),   
            'updatedAt'     =>  $cssRow->updated_at
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
        
        // return result
        return $options;
        
    }
  
}
