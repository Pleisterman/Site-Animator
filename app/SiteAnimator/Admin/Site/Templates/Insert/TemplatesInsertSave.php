<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesInsertSave.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionsInsert;
use App\SiteAnimator\Models\Site\SiteOptionsUpdate;

class TemplatesInsertSave extends BaseClass {

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
        
        // debug info
        $this->debug( 'group: ' . json_decode( $data['parentId'] ) );
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );

        // insert template
        $templateId = SiteOptionsInsert::insertOption( $this->database,
                                                       $data,
                                                       null,
                                                       $updatedAt );
        // insert template

        // create part update options
        $partUpdateOptions = array( 
            'options'   =>   isset( $data['partOptions'] ) ? $data['partOptions'] : null
        );
        // create part update options
        
        // update part options
        SiteOptionsUpdate::updateOption( $this->database, 
                                         $data['partId'], 
                                         $partUpdateOptions, 
                                         $updatedAt );
        // update part options
        
        // return template id
        return array( 'templateId' => $templateId );
        
    }        
    
}
