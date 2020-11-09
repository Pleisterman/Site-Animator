<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SequencesInsertSave.php
        function:   
                    
        Last revision: 27-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Sequences\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionsInsert;

class SequencesInsertSave extends BaseClass {

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
    public function save( $data ){
        
        $this->debug( 'group: ' . json_decode( $data['parentId'] ) );
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
                       
        // insert sequence
        $sequenceId = SiteOptionsInsert::insertOption( $this->database,
                                                       $data,
                                                       null,
                                                       $updatedAt );
        // insert sequence

        // return sequence id
        return array( 'sequenceId' => $sequenceId );
        
    }        
    
}
