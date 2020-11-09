<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsReadFileList.php
        function:   
                    
        Last revision: 01-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Read\Files;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItemsFiles;

class SiteItemsReadFileList extends BaseClass {

    protected $debugOn = true;
    private $selection = null;
    private $database = null;
    public function __construct( $database, $selection ) {
        
        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;

        // call parent
        parent::__construct();
        
    }
    public function read( ){
        
        // debug info
        $this->debug( 'SiteItemsReadFileList itemId: ' . $this->selection['id'] );
                
        // get files
        $files = SiteItemsFiles::getItemFiles( $this->database, $this->selection['id'] );
        
        // create result
        $result = array();

        // loop over files
        foreach ( $files as $index => $file ){
            
            // add source
            array_push( $result, $file->source );
            
        }
        // loop over files
        
        // return result
        return $result;
        
    }
    
}
