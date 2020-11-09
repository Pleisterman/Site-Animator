<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SequencesInsert.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Sequences\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Sequences\Insert\SequencesPrepareInsert;
use App\SiteAnimator\Admin\Site\Sequences\Insert\SequencesInsertSave;

class SequencesInsert extends BaseClass {

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
        $prepareInsert = new SequencesPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            return $prepareInsertResult;
            
        }
        // has result
        
        // construct insert save
        $insertSave = new SequencesInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data );
        
    }
    
}
