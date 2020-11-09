<?php

/*
        @package    Pleisterman\Common
  
        file:       PrepareLoginToken.php
        function:   
                    create prepareLogin token
                    
        Last revision: 05-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\Token;

class PrepareLoginToken extends BaseClass {
    
    protected $debugOn = true;
    private $type = 'prepareLoginToken';
    private $appCode = 'none';
    private $database = 'none';
    private $user = null;
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin PrepareLoginToken construct App code: ' . $appCode );        
        
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
        $this->debug( 'Admin PrepareLoginToken create' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // return token
        return $token->create( $request,
                               $this->type, 
                               env( $this->appCode . '_ADMIN_AUTHORISATION_PREPARE_LOGIN_TOKEN_LENGTH' ), 
                               env( $this->appCode . '_ADMIN_AUTHORISATION_PREPARE_LOGIN_EXPIRATION_PERIOD' ) );
        // return token

    }
    public function validate( $request, $encryptedToken ) {
        
        // debug
        $this->debug( 'Admin PrepareLoginToken validate' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // validate
        return $token->validate( $request, $this->type, $encryptedToken );
        
    }
}
