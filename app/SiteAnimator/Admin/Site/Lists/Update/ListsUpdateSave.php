<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsUpdateSave.php
        function:   
                    
        Last revision: 05-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionsUpdate;

class ListsUpdateSave extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function save( $selection, $data ){
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );

        // insert css
        SiteOptionsUpdate::updateOption( $this->database,
                                         $selection['id'],
                                         $data,
                                         $updatedAt );
        // insert css

        
        // return updated at
        return array( 'updatedAt' => $updatedAt );
        
    }        
    
}
