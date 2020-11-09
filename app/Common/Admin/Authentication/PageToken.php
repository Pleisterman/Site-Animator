<?php

/*
        @package    Pleisterman\CodeAnalyser
  
        file:       PageToken.php
        function:   
                    create page token
                    
        Last revision: 28-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\Token;

class PageToken extends BaseClass {
    
    protected $debugOn = true;
    private $type = 'pageToken';
    private $appCode = 'none';
    private $database = 'none';
    private $user = null;
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin PageToken construct App code: ' . $appCode );        
        
        // remember app name
        $this->appCode = $appCode;
        
        // remember database
        $this->database = $database;
        
        // remember user
        $this->user = $user;
        
    }
    public function createToken( $request, $jsonWebTokenId )
    {
        
        // debug
        $this->debug( 'Admin PageToken create' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // return token
        return $token->create( $request,
                               $this->type, 
                               env( $this->appCode . '_ADMIN_AUTHORISATION_PAGE_TOKEN_LENGTH' ), 
                               env( $this->appCode . '_ADMIN_AUTHORISATION_PAGE_TOKEN_EXPIRATION_PERIOD' ),
                               $jsonWebTokenId );
        // return token

    }
    public function validate( $request, $jsonWebTokenId ) {
        
        // debug
        $this->debug( 'Admin PageToken validate' );        

        // create token
        $token = new Token( $this->appCode, $this->database, $this->user );
        
        // get token
        $encryptedToken = $request->input( 'adminToken' );
        
        // validate
        return $token->validate( $request, $this->type, $encryptedToken, $jsonWebTokenId );
        
    }
    
}
