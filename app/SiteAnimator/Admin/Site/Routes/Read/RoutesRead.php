<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesRead.php
        function:   
                    
        Last revision: 03-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Routes\Read\RoutesReadList;
use App\SiteAnimator\Admin\Site\Routes\Read\RouteReadParentList;
use App\SiteAnimator\Admin\Site\Routes\Read\RoutesReadRoutesById;

class RoutesRead extends BaseClass {

    protected $debugOn = true;
    public function read( $database, $selection ){

        // remmeber database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read routes list
                $readlist = new RoutesReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // parent list
            case 'parentList': {
                
                // create read parent list
                $readlist = new RouteReadParentList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {

                // create routes by id
                $routesRow = new RoutesReadRoutesById();

                // call routes by id
                return $routesRow->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Routes error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
