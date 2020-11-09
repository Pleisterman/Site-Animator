<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsRead.php
        function:   
                    
        Last revision: 18-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadList;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadById;

class GroupsRead extends BaseClass {

    protected $debugOn = true;
    public function read( $database, $selection ){

        // remmeber database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read groups list
                $readlist = new GroupsReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {
                
                // create read group by id
                $readById = new GroupsReadById( $this->database, $selection );

                // return by id call
                return $readById->read( );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Groups error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
