<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsPrepareUpdate.php
        function:   
                    
        Last revision: 23-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\PageParts\Update\PagePartsValidate;

class PagePartsPrepareUpdate extends BaseClass {

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
    public function prepareUpdate( $selection, $data ){
        
        // create validate
        $validate = new PagePartsValidate( $this->database, $this->appCode );
        
        // validate updated at
        $validateUdpatedAt = $validate->validateUpdatedAt( $selection, $data );
        
        // has error
        if( isset( $validateUdpatedAt['error'] ) ){
            
            // validate updated at
            return $validateUdpatedAt;

        }
        // has error
        
        // validate name
        $validateNameResult = $validate->validateName( $selection, $data );
        
        // has error
        if( isset( $validateNameResult['error'] ) ){
            
            // validate name
            return $validateNameResult;

        }
        // has error
        
    }
    
}
