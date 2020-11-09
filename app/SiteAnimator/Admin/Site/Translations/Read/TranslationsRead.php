<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TranslationsRead.php
        function:   
                    
        Last revision: 02-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Translations\Read\TranslationsReadList;
use App\SiteAnimator\Admin\Site\Translations\Read\TranslationsReadTranslationsById;

class TranslationsRead extends BaseClass {

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
                $readlist = new TranslationsReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {

                // create translations by id
                $translationsRow = new TranslationsReadTranslationsById();

                // call translations by id
                return $translationsRow->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Translations error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
