<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SequencesReadSequencesById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Sequences\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Translations\SiteObject\SiteObjectRead as ReadTranslation;

class SequencesReadSequencesById extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // debug info
        $this->debug( 'SequencesReadList sequence id: ' . $selection['id'] );
        
        // get sequence row
        $sequenceRow = SiteOptions::getOption( $database, $selection['id'] );    
        
        // row ! found
        if( !$sequenceRow ){
            
            // return not found
            return array( 'error' => 'sequence not found' );
            
        }
        // row ! found
        
        // create result
        return $this->createResult( $sequenceRow );
        
    }
    private function createResult( $sequenceRow ) {
        
        // create result
        return array(
            'id'            =>  $sequenceRow->id,
            'name'          =>  $sequenceRow->name,   
            'groupId'       =>  $sequenceRow->parent_id,   
            'options'       =>  $this->enhanceOptions( json_decode( $sequenceRow->value, true ) ),   
            'updatedAt'     =>  $sequenceRow->updated_at
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
