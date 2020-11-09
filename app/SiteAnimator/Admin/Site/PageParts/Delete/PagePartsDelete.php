<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsDelete.php
        function:   
                    
        Last revision: 22-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;
use App\SiteAnimator\Models\Site\PagePartsOrder;

class PagePartsDelete extends BaseClass {

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
                
        // find children
        $this->findPartChildren( $selection['id'] );
        
        // delete route
        SiteOptionsDelete::deleteOption( $this->database, $selection['id'] );
        
        // re order options
        PagePartsOrder::reOrder( $this->database, $selection['routeId'], $selection['parentId'] );
        
        // return ok
        return array( 'ok' );
        
    }
    private function findPartChildren( $partId ){
        
        // get children
        $children = SiteOptions::getOptionOptions( $this->database, $partId );
        
        // loop over children
        foreach( $children as $index => $child ){
            
            // delete children recursive
            $this->findPartChildren( $child->id );

            // delete child
            $this->deleteChild( $child->id );
        
        }
        // loop over children
        
    }
    private function deleteChild( $childId ) {
        
        // debug info
        $this->debug( 'child: ' . $childId );
        
        // delete group
        SiteOptionsDelete::deleteOption( $this->database, $childId );        
        
    }
    
}
