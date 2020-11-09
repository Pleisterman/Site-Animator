<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ColorsRead.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Colors\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Colors\Read\ColorsReadList;
use App\SiteAnimator\Admin\Site\Colors\Read\ColorsReadColorsById;

class ColorsRead extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read translations list
                $readlist = new ColorsReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {

                // create translations by id
                $translationsRow = new ColorsReadColorsById();

                // call translations by id
                return $translationsRow->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Colors error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
