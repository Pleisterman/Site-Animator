<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       AnimationsRead.php
        function:   
                    
        Last revision: 10-08-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Animations\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Animations\Read\AnimationsReadList;
use App\SiteAnimator\Admin\Site\Animations\Read\AnimationsReadAnimationById;

class AnimationsRead extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read animaitons list
                $readlist = new AnimationsReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {

                // create animaiton by id
                $animaitonRow = new AnimationsReadAnimationById();

                // call animaiton by id
                return $animaitonRow->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Animations error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
