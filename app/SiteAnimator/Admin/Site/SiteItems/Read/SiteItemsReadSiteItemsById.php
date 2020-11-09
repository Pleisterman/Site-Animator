<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsReadSiteItemsById.php
        function:   
                    
        Last revision: 09-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Models\Site\SiteOptions;

class SiteItemsReadSiteItemsById extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // set database
        $this->database = $database;
        
        // debug info
        $this->debug( 'SiteItemsReadSiteItemsById id: ' . $selection['id'] );
        
        // get site item row
        $siteItemRow = SiteItems::getRow( $database, $selection['id'] );    

        // create result
        return $this->createResult( $siteItemRow );
        
    }
    private function createResult( $siteItemRow ) {
        
        // create result
        $result = array(
            'id'            =>  $siteItemRow->id,
            'type'          =>  $siteItemRow->type,   
            'groupId'       =>  $siteItemRow->group_id,   
            'partId'        =>  $siteItemRow->site_options_id,   
            'options'       =>  json_decode( $siteItemRow->options, true ),   
            'updatedAt'     =>  $siteItemRow->updated_at,
        );
        // create result

        // has part
        if( $siteItemRow->site_options_id != null ){
            
            // get site item part row
            $siteItemPartRow = SiteOptions::getOption( $this->database, $siteItemRow->site_options_id );    

            // row found
            if( $siteItemPartRow ){
                
                // add is part options
                $result['isPart'] = true;
                
                // add part options
                $result['partOptions'] = json_decode( $siteItemPartRow->value, true );
                        
            }
            // part options found
            
        }
        // has part
        
        // return result
        return $result;
        
    }
    
}
