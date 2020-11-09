<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       AnimationsUpdate.php
        function:   
                    
        Last revision: 10-08-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Animations\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Animations\Update\AnimationsPrepareUpdate;
use App\SiteAnimator\Admin\Site\Animations\Update\AnimationsUpdateSave;

class AnimationsUpdate extends BaseClass {

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
        $prepareUpdate = new AnimationsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct animaitons save
        $animaitonsSave = new AnimationsUpdateSave( $this->database, $this->appCode );

        // save animaitons        
        return $animaitonsSave->save( $selection, $data );
        
    }
    
}
