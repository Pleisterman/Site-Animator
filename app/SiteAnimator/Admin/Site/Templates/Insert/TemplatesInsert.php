<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesInsert.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Templates\Insert\TemplatesPrepareInsert;
use App\SiteAnimator\Admin\Site\Templates\Insert\TemplatesInsertSave;
use App\SiteAnimator\Admin\Site\Templates\Insert\TemplatePartsPrepareInsert;
use App\SiteAnimator\Admin\Site\Templates\Insert\TemplatePartsInsertSave;

class TemplatesInsert extends BaseClass {

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
        
        // type is template / else
        if( $data['type'] == 'template' ){

            // insert template
            return $this->insertTemplate( $data );
            
        }
        else {
            
            // insert template part
            return $this->insertTemplatePart( $data );
            
        }
        // type is template / else
        
    }
    private function insertTemplate( $data ) {

        // construct prepare insert
        $prepareInsert = new TemplatesPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            return $prepareInsertResult;
            
        }
        // has result
        
        // construct insert save
        $insertSave = new TemplatesInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data );
        
    }
    private function insertTemplatePart( $data ) {

        // construct prepare insert
        $prepareInsert = new TemplatePartsPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            return $prepareInsertResult;
            
        }
        // has result
        
        // construct insert save
        $insertSave = new TemplatePartsInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data );
        
    }
    
}
