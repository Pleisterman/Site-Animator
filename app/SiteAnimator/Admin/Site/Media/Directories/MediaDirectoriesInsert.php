<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaDirectoriesInsert.php
        function:   
                    
        Last revision: 11-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Directories;

use App\Http\Base\BaseClass;

class MediaDirectoriesInsert extends BaseClass {

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
    public function createDirectory( $path ){
        
        // debug info
        $this->debug( 'MediaDirectoriesInsertMedia createDirectory: ' . $path );
        
        // create dir
        @mkdir( $path ); 
        
    }
    
}
