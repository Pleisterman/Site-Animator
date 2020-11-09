<?php

/*
        @package    Pleisterman\CodeAnalyser
  
        file:       app/Http/Middleware/Admin/Authentication/CreateLoginToken.php
        function:   Login tokens are created in the first fase off the login
                    on the webroute
                    in the prepareLogin step the token will be validated
                    in the middleware validateLoginToken
 
                    create token with type loginToken
                    add encrypted token to the request attributes for javascript
                    
        Last revision: 07-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\RememberMeToken;
use App\Common\Admin\Authentication\RememberMeCookie;

class RememberMe extends BaseClass {
    
    protected $debugOn = true;
    private $appName = 'none';
    private $database = 'none';
    private $user = null;
    public function __construct( $appName, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin RememberMe construct App name: ' . $appName );        
        
        // remember app name
        $this->appName = $appName;
        
        // remember database
        $this->database = $database;
        
        // remember user
        $this->user = $user;
        
    }
    public function createToken( )
    {
        
        // debug
        $this->debug( 'Admin RememberMe create token' );        

        // create rememberMe token
        $rememberMeToken = new RememberMeToken( $this->appName, $this->database, $this->user );

        // create token
        $token = $rememberMeToken->create( );
        
        // token created
        if( $token ){
            
            // create cookie
            $rememberMeCookie = new RememberMeCookie( $this->appName, $this->database, $this->user );
            
            // create cookie
            $cookie = $rememberMeCookie->create( );
            
            // cookie created
            if( $cookie ){
                
                // return token
                return $token;
                
            }
            // cookie created
            
        }
        // token created
        
        // no token created
        return false;
        
    }
    public function validate( $user, $token ) {
        
        // create rememberMe token
        $rememberMeToken = new RememberMeToken();

        // valid token
        if( $rememberMeToken->validate( $user, $token ) ){
            
            // create cookie
            $rememberMeCookie = new RememberMeCookie();
            
            // valid cookie
            if( $rememberMeCookie->validate( $user ) ){
                
                // return valid
                return true;
                
            }
            // valid cookie
            
        }        
        // valid 
       
        // return invalid
        return false;
        
    }
    
}
