<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaDirectoriesUpdate.php
        function:   
                    
        Last revision: 11-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Directories;

use App\Http\Base\BaseClass;

class MediaDirectoriesUpdate extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $mediaPath = '';
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function updateDirectory( $existingPath, $updatedPath ){

        // 
        
        // rename directory
        rename( $existingPath, $updatedPath ); 
        
    }
    
}
