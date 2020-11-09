<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsInsertSave.php
        function:   
                    
        Last revision: 05-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptionGroups;
use App\SiteAnimator\Models\Site\SiteOptionsInsert;

class ListsInsertSave extends BaseClass {

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

        // create next sequence
        $nextSequence = null;
        
        // has parent
        if( $data['parentId'] != null ){
            
            // get next sequence
            $nextSequence = SiteOptionGroups::getNextSequence( $this->database,
                                                               $data['parentId'] );
            // get next sequence

        }
        // has parent
        
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
