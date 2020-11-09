<?php

/*
        @package    Pleisterman\CodeAnalyser
  
        file:       LoginToken.php
        function:   
                    create Login token
                    
        Last revision: 28-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\Token;

class LoginToken extends BaseClass {
    
    protected $debugOn = true;
    private $type = 'prepareLoginToken';
    private $appCode = 'none';
    private $database = 'none';
    private $user = null;
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin LoginToken construct App code: ' . $appCode );        
        
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
        $this->debug( 'Admin LoginToken create' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // return token
        return $token->create( $request,
                               $this->type, 
                               env( $this->appCode . '_ADMIN_AUTHORISATION_LOGIN_TOKEN_LENGTH' ), 
                               env( $this->appCode . '_ADMIN_AUTHORISATION_LOGIN_EXPIRATION_PERIOD' ) );
        // return token

    }
    public function validate( $request, $encryptedToken ) {
        
        // debug
        $this->debug( 'Admin LoginToken validate' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // validate
        return $token->validate( $request, $this->type, $encryptedToken );
        
    }
}
