<?php

/*
        @package    Pleisterman\Common
  
        file:       RememberMeToken.php
        function:   
                    create rememberMe token
                    
        Last revision: 05-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\Token;

class RememberMeToken extends BaseClass {
    
    protected $debugOn = true;
    private $type = 'rememberMeToken';
    private $appCode = 'none';
    private $database = 'none';
    private $user = null;
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin RememberMeToken construct App code: ' . $appCode );        
        
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
        $this->debug( 'Admin RememberMeToken create' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // return token
        return $token->create( $request,
                               $this->type, 
                               env( $this->appCode . '_ADMIN_AUTHORISATION_REMEMBERME_TOKEN_LENGTH' ), 
                               env( $this->appCode . '_ADMIN_AUTHORISATION_REMEMBERME_EXPIRATION_PERIOD' ) );
        // return token

    }
    public function validate( $request, $encryptedToken ) {
        
        // debug
        $this->debug( 'Admin RememberMeToken validate' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // validate
        return $token->validate( $request, $this->type, $encryptedToken );
        
    }
}
