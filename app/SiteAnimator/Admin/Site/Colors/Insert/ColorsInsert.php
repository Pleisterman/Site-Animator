<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ColorsInsert.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Colors\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Colors\Insert\ColorsPrepareInsert;
use App\SiteAnimator\Admin\Site\Colors\Insert\ColorsInsertSave;

class ColorsInsert extends BaseClass {

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
        $prepareInsert = new ColorsPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            return $prepareInsertResult;
            
        }
        // has result
        
        // construct insert save
        $insertSave = new ColorsInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data );
        
    }
    
}
