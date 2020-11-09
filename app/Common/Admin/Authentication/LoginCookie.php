<?php

/*
        @package    Pleisterman\Common
  
        file:       LoginCookie.php
        function:   login cookies are created
  
                    create token with type login
                    save encrypted token as a cookie
                    
        Last revision: 28-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use Cookie;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\Token;

class LoginCookie extends BaseClass {
    
    protected $debugOn = true;
    private $type = 'LoginCookie';
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin LoginCookie construct App code: ' . $appCode );        
        
        // remember app name
        $this->appCode = $appCode;
        
        // remember database
        $this->database = $database;
        
        // remember user
        $this->user = $user;
        
    }
    public function create( $request )
    {
        
        // debug
        $this->debug( 'admin LoginCookie create' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // create cookie token
        $cookieToken = $token->create( $request,
                                       $this->type, 
                                       env( $this->appCode . '_ADMIN_AUTHORISATION_LOGIN_COOKIE_TOKEN_LENGTH' ), 
                                       env( $this->appCode . '_ADMIN_AUTHORISATION_LOGIN_EXPIRATION_PERIOD' ) );
        // create cookie token

        // cookie token created
        if( $cookieToken ){
        
            // debug
            $this->debug( 'middleware admin Login Cookie save ' );        
            $this->debug( 'token: ' . $cookieToken );        

            // get expiration period
            $expirationPeriod = env( $this->appCode . '_ADMIN_AUTHORISATION_LOGIN_EXPIRATION_PERIOD' );
            
            // callculate minutes
            $expirationPeriod /= 60;
            
            // add cookie to queue
            Cookie::queue( Cookie::make( $this->getCookieName(), 
                                         $cookieToken, 
                                         $expirationPeriod, 
                                         env( $this->appCode . '_ADMIN_AUTHORISATION_COOKIE_PATH' ), 
                                         null, false, true ) );
            // add cookie to queue
            
            // return result
            return $cookieToken;
            
            
        // cookie token created
        }

        // return with error
        return false;
        
    }
    public function validate( $request ) {
        
        // debug
        $this->debug( 'middleware Admin Login cookie validate' );        
        
        // get token
        $encryptedToken = Cookie::get( $this->getCookieName() );

        $this->debug( 'user: ' . $this->user->id );
        $this->debug( 'type: ' . $this->type );
        $this->debug( 'token: ' . $encryptedToken );
        
        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // validate
        return $token->validate( $request, $this->type, $encryptedToken );
        
    }
    private function getCookieName() {
        
        // return cookie name
        return env( $this->appCode . '_ADMIN_AUTHORISATION_COOKIE_NAME' ) . '_' . $this->user->uid;
            
    }
}
