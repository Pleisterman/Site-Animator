<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       CssUpdate.php
        function:   
                    
        Last revision: 13-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Css\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Css\Update\CssPrepareUpdate;
use App\SiteAnimator\Admin\Site\Css\Update\CssUpdateSave;

class CssUpdate extends BaseClass {

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
    public function update( $selection, $data ){
                        
        // construct prepare update
        $prepareUpdate = new CssPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct css save
        $cssSave = new CssUpdateSave( $this->database, $this->appCode );

        // save css        
        return $cssSave->save( $selection, $data );
        
    }
    
}
