<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsInsertSave.php
        function:   
                    
        Last revision: 09-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;

class SiteItemsInsertSave extends BaseClass {

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
    public function save( $data ){
        
        $this->debug( 'group: ' . json_decode( $data['groupId'] ) );
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // insert site item
        $siteItemId = SiteItems::insertSiteItem( $this->database,
                                                 $data,
                                                 $updatedAt );
        // insert site item

        // return site item id
        return array( 'siteItemId' => $siteItemId );
        
    }        
    
}
