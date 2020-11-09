<?php

/*
        @package    Pleisterman\Common
  
        file:       User.php
        function:   
  
 
        Last revision: 03-02-2020
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;
use App\Common\Models\Admin\Authentication\AdminUsers;

class User extends BaseClass  {

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
    public function read( $selection ){
        
        // choose what
        switch ( $selection['type'] ) {
                        
            //  main
            case 'main': {

                // create users
                $users = new AdminUsers();
                
                // call users
                return $users->getUserRowByUid( $this->database, $selection['uid'] );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( ' User read error get, what not found: ' . $selection['type'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
            
        }        
        // done choose what
        
    }
   
}