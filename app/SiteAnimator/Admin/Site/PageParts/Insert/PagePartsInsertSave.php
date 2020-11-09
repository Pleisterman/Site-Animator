<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsInsertSave.php
        function:   
                    
        Last revision: 22-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\PageParts;
use App\SiteAnimator\Models\Site\SiteItems;

class PagePartsInsertSave extends BaseClass {

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
     
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );

        // get next sequence
        $nextSequence = PageParts::getNextSequence( $this->database,
                                                    $data['routeId'],
                                                    $data['parentId'] );
        // get next sequence
        
        // child is template / else
        if( $data['child']['isTemplate'] == 'true' ){
            
            // set part id
            $data['partId'] = $data['child']['templateId'];
            $data['isTemplate'] = true;
        }
        else {
            
            // get site item
            $siteItem = SiteItems::getRow( $this->database, 
                                           $data['child']['itemId'] );
            // get site item
            
            // set part id
            $data['partId'] = $siteItem->site_options_id;
            $data['isTemplate'] = false;   
            
        }
        // child is template / else
        
        // insert page part
        $pagePartId = PageParts::insertPagePart( $this->database,
                                                 $data,
                                                 $nextSequence,
                                                 $updatedAt );
        // insert page part

        // return page part id
        return array( 'pagePartId' => $pagePartId );
        
    }        
    
}
