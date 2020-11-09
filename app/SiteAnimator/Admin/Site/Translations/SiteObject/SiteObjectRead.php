<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteObjectRead.php
        function:   
                    
        Last revision: 29-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\SiteObject;

use App\Common\Base\BaseClass;
use App\Common\Models\Translations;
use App\SiteAnimator\Admin\Site\Translations\SiteObject\SiteObjectReadGroupPath;

class SiteObjectRead extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function __construct( $database ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
        
    }
    public function read( $siteObject ){

        // id is ! set or  null
        if( !isset( $siteObject['id'] ) &&
            $siteObject['id'] == null ){
            
            // done 
            return $siteObject;
            
        }
        // id is ! set or  null
        
        // get translation row
        $translationIdRow = Translations::getTranslationIdRow( $this->database, false, $siteObject['id'] );    
        
        // row not found
        if( !$translationIdRow ){
            
            // unset id
            $siteObject['id'] = null;
            
            // done 
            return $siteObject;
            
        }
        // row not found
        
        // set text
        $siteObject['text'] = 'replacing translation with id: ' . $translationIdRow->id;
        
        // create read group path
        $readGroupPath = new SiteObjectReadGroupPath( $this->database );
        
        // read group path
        $path = $readGroupPath->read( $translationIdRow->groupId );
        
        
        // set text
        $siteObject['text'] = $path . $translationIdRow->name;
        
        
        // return result
        return $siteObject;

    }
    
}
