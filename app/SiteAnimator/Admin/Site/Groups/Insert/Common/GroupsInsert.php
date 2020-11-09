<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsInsert.php
        function:   
                    
        Last revision: 31-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Insert\Common;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Groups\Insert\Common\GroupsPrepareInsert;
use App\SiteAnimator\Admin\Site\Groups\Insert\Common\GroupsInsertSave;

class GroupsInsert extends BaseClass {

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
        $prepareInsert = new GroupsPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            return $prepareInsertResult;
            
        }
        // has result
        
        // construct insert save
        $insertSave = new GroupsInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data );
        
    }
    
}
