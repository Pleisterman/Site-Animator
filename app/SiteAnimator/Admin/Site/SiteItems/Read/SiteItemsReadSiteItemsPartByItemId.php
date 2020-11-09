<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsReadSiteItemsPartByItemId.php
        function:   
                    
        Last revision: 09-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Models\Site\SiteOptions;

class SiteItemsReadSiteItemsPartByItemId extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // set database
        $this->database = $database;
        
        // debug info
        $this->debug( 'SiteItemsReadSiteItemsPartByItemId id: ' . $selection['id'] );
        
        // get site item row
        $siteItemRow = SiteItems::getRow( $database, $selection['id'] );    

        // get part row
        $partRow = SiteOptions::getOption( $database, $siteItemRow->site_options_id );    

        // create result
        return $this->createResult( $partRow );
        
    }
    private function createResult( $partRow ) {
        
        // create result
        $result = array(
            'id'            =>  $partRow->id,
            'options'       =>  json_decode( $partRow->value, true ),   
            'updatedAt'     =>  $partRow->updated_at,
        );
        // create result

        // return result
        return $result;
        
    }
    
}
