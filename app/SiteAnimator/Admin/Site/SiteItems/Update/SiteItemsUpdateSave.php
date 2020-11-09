<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsUpdateSave.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Models\Site\SiteOptionsUpdate;

class SiteItemsUpdateSave extends BaseClass {

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

        // update site item
        SiteItems::updateSiteItem( $this->database,
                                   $selection,
                                   $data,
                                   $updatedAt );
        // update site item

        // create part data
        $partData = array(
            'options'   =>  isset( $data['partOptions'] ) ? $data['partOptions'] : array()       
        );
        // create part data
        
        // update site item part
        SiteOptionsUpdate::updateOption( $this->database,
                                         $selection['partId'],
                                         $partData,
                                         $updatedAt );
        // update site item part
        
        // return updated at
        return array( 'updatedAt' => $updatedAt );
        
    }        
    
}
