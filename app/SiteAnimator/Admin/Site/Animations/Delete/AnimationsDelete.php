<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       AnimationsDelete.php
        function:   
                    
        Last revision: 10-08-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Animations\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;

class AnimationsDelete extends BaseClass {

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
        
        // delete animaiton
        SiteOptionsDelete::deleteOption( $this->database, $selection['id'] );        
        
        // return ok
        return array( 'ok' );
        
    }
    
}
