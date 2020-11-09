<?php

/*
        @package    Pleisterman\Common
  
        file:       JsonWebToken.php
        function:   
                    create and validate json Web Token token
                    
        Last revision: 29-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use Cookie;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\Token;

class JsonWebToken extends BaseClass {
    
    protected $debugOn = true;
    private $type = 'jsonWebToken';
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin JsonWebToken construct App code: ' . $appCode );        
        
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
        $this->debug( 'Admin JsonWebToken create' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // return token
        $encryptedToken = $token->create( $request, 
                                          $this->type, 
                                          env( $this->appCode . '_ADMIN_AUTHORISATION_JWT_TOKEN_LENGTH' ), 
                                          env( $this->appCode . '_ADMIN_AUTHORISATION_JWT_EXPIRATION_PERIOD' ) );
        // return token

        // get user options
        $userOptions = $request->attributes->get( 'adminUserOptions' );
        
        // create remember me
        $rememberMe = $userOptions['rememberMe'] == 'true' ? true : false;
        
        // create expiration period
        $expirationPeriod = null;
        
        // remember me
        if( $rememberMe ){

            // get expiration period
            $expirationPeriod = env( $this->appCode . '_ADMIN_AUTHORISATION_JWT_EXPIRATION_PERIOD' );

            // callculate minutes
            $expirationPeriod /= 60;
            
        }
        // remember me

        // add cookie to queue
        Cookie::queue( Cookie::make( $this->getCookieName(), 
                                     $encryptedToken, 
                                     $expirationPeriod, 
                                     env( $this->appCode . '_ADMIN_AUTHORISATION_COOKIE_PATH' ), 
                                     null, false, true ) );
        // add cookie to queue
        
        // return token id
        return $token->getId();
        
    }
    public function validate( $request ) {
        
        // debug
        $this->debug( 'Admin JsonWebToken validate' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // get token
        $encryptedToken = Cookie::get( $this->getCookieName() );
        
        // no token
        if( !$encryptedToken ){
        
            // debug
            $this->debug( 'Admin JsonWebToken no cookie' );        

            // return invalid
            return false;
            
        }
        // no token
        
        // ! validate token
        if( !$token->validate( $request, $this->type, $encryptedToken ) ){

            // ! valid
            return false;
            
        }
        // ! validate token
        
        // valid
        return $token->getId();
        
    }
    public function refresh( $request ) {
        
        // debug
        $this->debug( 'Admin JsonWebToken refresh' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // get token
        $encryptedToken = Cookie::get( $this->getCookieName() );
        
        // no token
        if( !$encryptedToken ){
        
            // debug
            $this->debug( 'Admin JsonWebToken no cookie' );        

        }
        // no token
        
        // create new token
        return $this->create( $request );
        
    }
    private function getCookieName() {
        
        // return cookie name
        return env( $this->appCode . '_ADMIN_AUTHORISATION_JWT_NAME' ) . '_' . $this->user->uid;
            
    }
    
}
