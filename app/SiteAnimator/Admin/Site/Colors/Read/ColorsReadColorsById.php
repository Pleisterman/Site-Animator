<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ColorsReadColorsById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Colors\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class ColorsReadColorsById extends BaseClass {

    protected $debugOn = true;
    public function read( $database, $selection ){

        // debug info
        $this->debug( 'ColorsReadList color id: ' . $selection['id'] );
        
        // get color row
        $colorRow = SiteOptions::getOption( $database, $selection['id'] );    
        
        // row ! found
        if( !$colorRow ){
            
            // return not found
            return array( 'error' => 'color not found' );
            
        }
        // row ! found
        
        // create result
        return $this->createResult( $colorRow );
        
    }
    private function createResult( $colorRow ) {
        
        // create result
        return array(
            'id'            =>  $colorRow->id,
            'name'          =>  $colorRow->name,   
            'groupId'       =>  $colorRow->parent_id,   
            'options'       =>  $this->enhanceOptions( json_decode( $colorRow->value, true ) ),   
            'updatedAt'     =>  $colorRow->updated_at
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
