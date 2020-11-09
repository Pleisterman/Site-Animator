<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       LanguagesInsertSave.php
        function:   
                    
        Last revision: 23-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Languages\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\LanguagesInsert;

class LanguagesInsertSave extends BaseClass {

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
                       
        // get next sequence
        $nextSequence = SiteOptionGroups::getNextSequence( $this->database,
                                                           $data['parentId'],
                                                           $data['type'] );
        // get next sequence
                
        // insert list item
        $listItemId = SiteOptionsInsert::insertOption( $this->database,
                                                       $data,
                                                       $nextSequence,
                                                       $updatedAt );
        // insert list item

        // return list item id
        return array( 'listItemId' => $listItemId );
        
    }        
    
}
