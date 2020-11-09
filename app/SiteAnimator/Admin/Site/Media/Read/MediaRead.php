<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaRead.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Media\Read\MediaReadList;
use App\SiteAnimator\Admin\Site\Media\Read\MediaReadMediaById;

class MediaRead extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    public function read( $appCode, $database, $selection ){

        // remember app code
        $this->appCode = $appCode;

        // remember database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read media list
                $readlist = new MediaReadList( $this->appCode, $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {

                // create translations by id
                $translationsRow = new MediaReadMediaById();

                // call translations by id
                return $translationsRow->read( $this->appCode, $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Media error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
