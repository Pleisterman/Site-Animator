<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatePartsInsertSave.php
        function:   
                    
        Last revision: 22-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionGroups;
use App\SiteAnimator\Models\Site\SiteOptionsInsert;

class TemplatePartsInsertSave extends BaseClass {

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
        
        $this->debug( 'TemplatesPartInsertSave parentId: ' . json_decode( $data['parentId'] ) );
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );

        // get next sequence
        $nextSequence = SiteOptionGroups::getNextSequence( $this->database,
                                                           $data['parentId'] );
        // get next sequence
        
        // unset type
        $data['type'] = null;
        
        // insert part
        $partId = SiteOptionsInsert::insertOption( $this->database,
                                                   $data,
                                                   $nextSequence,
                                                   $updatedAt );
        // insert part

        // return part id
        return array( 'partId' => $partId );
        
    }        
    
}
