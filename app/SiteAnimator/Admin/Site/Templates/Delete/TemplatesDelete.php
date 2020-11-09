<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesDelete.php
        function:   
                    
        Last revision: 21-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;

class TemplatesDelete extends BaseClass {

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
    public function delete( $selection ){

        // selection id ! set
        if( !isset( $selection['id'] ) || 
            $selection['id'] == null ){
            
            // error
            return array( 'criticalError' => 'id not set' );
            
        }
        // selection id ! set
        
        // delete children
        $this->deleteChildren( $selection['id'] );
        
        // is template
        if( $selection['type'] == 'template' ){
            
            // delete used templates
            $this->deleteUsedTemplateParts( $selection['id'] );
        }
        // is template
        
        
        // delete template
        SiteOptionsDelete::deleteOption( $this->database, $selection['id'] );        
        
        // return ok
        return array( 'ok' );
        
    }
    private function deleteChildren( $optionId ){
        
        // get children
        $children = SiteOptions::getOptionOptions( $this->database, $optionId );
    
        // loop over children
        foreach( $children as $index => $child ){
            
            // delete children recursive
            $this->deleteChildren( $child->id );

            // delete child
            $this->deleteChild( $child->id );
        
        }
        // loop over children
        
    }
    private function deleteChild( $childId ) {
        
        // debug info
        $this->debug( 'child: ' . $childId );
        
        // delete child
        SiteOptionsDelete::deleteOption( $this->database, $childId );        
        
    }
    private function deleteUsedTemplateParts( $templateId ){
     
        // get parts
        $parts = SiteOptions::getUsedOptions( $this->database, $templateId );
        
        // loop over part
        foreach( $parts as $index => $part ){
            
            // delete part
            SiteOptionsDelete::deleteOption( $this->database, $part->id );        
        
        }
        // loop over parts
        
        
    }    
}
