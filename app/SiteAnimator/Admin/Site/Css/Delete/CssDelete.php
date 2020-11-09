<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       CssDelete.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Css\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;

class CssDelete extends BaseClass {

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
        
        // delete css
        SiteOptionsDelete::deleteOption( $this->database, $selection['id'] );        
        
        // return ok
        return array( 'ok' );
        
    }
    
}
