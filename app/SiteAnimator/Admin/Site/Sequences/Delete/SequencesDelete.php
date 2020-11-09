<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SequencesDelete.php
        function:   
                    
        Last revision: 05-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Sequences\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;

class SequencesDelete extends BaseClass {

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
        
        // delete sequence
        SiteOptionsDelete::deleteOption( $this->database, $selection['id'] );        
        
        // return ok
        return array( 'ok' );
        
    }
    
}
