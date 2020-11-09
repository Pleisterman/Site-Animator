<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TranslationsDelete.php
        function:   
                    
        Last revision: 05-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Translations;

class TranslationsDelete extends BaseClass {

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
        
        // delete route
        Translations::deleteTranslation( $this->database, $selection );        
        
        // return ok
        return array( 'ok' );
        
    }
    
}
