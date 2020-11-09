<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       CssRead.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Css\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Css\Read\CssReadList;
use App\SiteAnimator\Admin\Site\Css\Read\CssReadCssById;

class CssRead extends BaseClass {

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
                $readlist = new CssReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {

                // create translations by id
                $translationsRow = new CssReadCssById();

                // call translations by id
                return $translationsRow->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Css error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
