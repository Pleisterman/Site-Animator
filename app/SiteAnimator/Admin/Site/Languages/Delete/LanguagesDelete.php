<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       LanguagesDelete.php
        function:   
                    
        Last revision: 23-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Languages\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\LanguagesDelete;

class LanguagesDelete extends BaseClass {

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
        
        // delete list item
        SiteOptionsDelete::deleteOption( $this->database, $selection['id'] );        
        
        // return ok
        return array( 'ok' );
        
    }
    
}
