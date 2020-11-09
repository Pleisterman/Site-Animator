<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatePartsUpdateSave.php
        function:   
                    
        Last revision: 22-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionsUpdate;

class TemplatePartsUpdateSave extends BaseClass {

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

        // unset type
        $data['type'] = null;
        
        // update template
        SiteOptionsUpdate::updateOption( $this->database,
                                         $selection['id'],
                                         $data,
                                         $updatedAt );
        // update template

        
        // return updated at
        return array( 'updatedAt' => $updatedAt );
    }        
    
}
