<?php

/*
        @package    Pleisterman\CodeAnalyser
  
        file:       LoginName.php
        function:   
  
 
        Last revision: 28-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Http\Base\BaseClass;
use App\Http\Middleware\Admin\Authentication\AdminUserKey;

class LoginName extends BaseClass  {

    protected $debugOn = true;
    private $appCode = 'none';
    private $database = 'none';
    private $user = null;
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin LoginName construct App code: ' . $appCode );        
        
        // remember app name
        $this->appCode = $appCode;
        
        // remember database
        $this->database = $database;
        
        // remember user
        $this->user = $user;        
        
    }
    public function validate( $request ) {
        
        // get login name
        $name = $request->input( 'name' );
        
        // name ! user login name
        if( !$name == $this->user->login_name ){
            
            // ! valid
            return false;
            
        }
        // name ! user login name
        
        // valid
        return true;

    }
   
}