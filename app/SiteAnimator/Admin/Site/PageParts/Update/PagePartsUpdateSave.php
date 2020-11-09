<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsUpdateSave.php
        function:   
                    
        Last revision: 22-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\PageParts;
use App\SiteAnimator\Models\Site\PagePartsOrder;
use App\SiteAnimator\Models\Site\SiteItems;

class PagePartsUpdateSave extends BaseClass {

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

        // child is template / else
        if( isset( $data['child']['isTemplate'] ) && 
            $data['child']['isTemplate'] == 'true' ){
            
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

        // debug
        $this->debug( 'data is public: ' . $data['isPublic'] );
        
        $public = false;
        
        // public exists
        if( isset( $data['isPublic'] ) ){
            
            $public = $data['isPublic'] === 'true' ? true : false;
            
        }
        
        // debug
        $this->debug( 'hier is public: ' . $public );


        
        // parent id is current parent id / else
        if( $data['currentParentId'] == $data['parentId'] ){
        
            // update page part
            $this->updatePagePart( $selection, $data, $updatedAt );
            
        }
        else {
            
            // update page part and parent
            $this->updatePagePartAndParent( $selection, $data, $updatedAt );
            
        }
        // parent id is current parent id / else
        
        // return updated at
        return array( 'updatedAt' => $updatedAt );
        
    }        
    public function updatePagePart( $selection, $data, $updatedAt ){
        
        // update page part
        PageParts::updatePagePart( $this->database, $selection['id'], $data, $updatedAt );
        
    }    
    public function updatePagePartAndParent( $selection, $data, $updatedAt ){
        
        // get next sequence
        $nextSequence = PageParts::getNextSequence( $this->database, $data['routeId'], $data['parentId'] );
        
        // add sequence to data
        $data['sequence'] = $nextSequence;
        
        // update page part
        PageParts::updatePagePart( $this->database, $selection['id'], $data, $updatedAt );
        
        // re order options
        PagePartsOrder::reOrder( $this->database, $data['routeId'], $data['currentParentId'] );
                
    }    
}
