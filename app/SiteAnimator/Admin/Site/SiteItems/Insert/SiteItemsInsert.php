<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsInsert.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\SiteItems\Insert\SiteItemsPrepareInsert;
use App\SiteAnimator\Admin\Site\SiteItems\Insert\SiteItemsInsertSave;

class SiteItemsInsert extends BaseClass {

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
    public function insert( $data ){
        
        // construct prepare insert
        $prepareInsert = new SiteItemsPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            return $prepareInsertResult;
            
        }
        // has result
        
        // construct insert save
        $insertSave = new SiteItemsInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data );
        
    }
    
}
