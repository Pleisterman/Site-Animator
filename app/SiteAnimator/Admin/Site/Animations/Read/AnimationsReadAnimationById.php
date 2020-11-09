<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       AnimationsReadAnimationById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 14-08-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Animations\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class AnimationsReadAnimationById extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // debug info
        $this->debug( 'AnimationsReadAnimationById animation id: ' . $selection['id'] );
        
        // get animation row
        $animationRow = SiteOptions::getOption( $database, $selection['id'] );    
        
        // row ! found
        if( !$animationRow ){
            
            // return not found
            return array( 'error' => 'animation not found' );
            
        }
        // row ! found
        
        // create result
        return $this->createResult( $animationRow );
        
    }
    private function createResult( $animationRow ) {
        
        // create result
        return array(
            'id'            =>  $animationRow->id,
            'name'          =>  $animationRow->name,   
            'groupId'       =>  $animationRow->parent_id,   
            'options'       =>  json_decode( $animationRow->value, true ),   
            'updatedAt'     =>  $animationRow->updated_at
        );
        // create result
        
    }
}
