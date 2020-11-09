<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsRead.php
        function:   
                    
        Last revision: 05-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Lists\Read\ListsReadList;
use App\SiteAnimator\Admin\Site\Lists\Read\ListsReadListsById;

class ListsRead extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read list items list
                $readlist = new ListsReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {

                // create list item by id
                $listItemRow = new ListsReadListsById();

                // call list item by id
                return $listItemRow->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Lists error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
