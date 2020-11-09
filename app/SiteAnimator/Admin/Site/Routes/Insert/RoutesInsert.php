<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesInsert.php
        function:   
                    
        Last revision: 04-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Routes\Insert\RoutesPrepareInsert;
use App\SiteAnimator\Admin\Site\Routes\Insert\RoutesInsertSave;

class RoutesInsert extends BaseClass {

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
        $prepareInsert = new RoutesPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            return $prepareInsertResult;
            
        }
        // has result
        
        // construct insert save
        $insertSave = new RoutesInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data );
        
    }
    
}
