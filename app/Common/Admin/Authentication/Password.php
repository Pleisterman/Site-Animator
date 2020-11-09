<?php

/*
        @package    Pleisterman\Common
  
        file:       Password.php
        function:   
  
 
        Last revision: 28-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Http\Base\BaseClass;
use App\Common\Admin\Authentication\Key;

class Password extends BaseClass  {

    protected $debugOn = true;
    private $appCode = 'none';
    private $database = 'none';
    private $user = null;
    private $cipher = 'none';
    private $length = null;
    private $expirationPeriod = null;
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // debug
        $this->debug( 'Admin Password construct App code: ' . $appCode );        
        
        // remember app name
        $this->appCode = $appCode;
        
        // remember database
        $this->database = $database;
        
        // remember user
        $this->user = $user;
        
        // set cipher
        $this->cipher = env( $this->appCode . '_ADMIN_AUTHORISATION_ENCRYPTION_CIPHER' );
        
        // set token length
        $this->length = env( $this->appCode . '_ADMIN_AUTHORISATION_PASSWORD_TOKEN_LENGTH' );
        
        // set expiration period
        $this->expirationPeriod = env( $this->appCode . '_ADMIN_AUTHORISATION_PASSWORD_EXPIRATION_PERIOD' );
        
    }
    public function validate( $request ) {
        
        // ! get user
        if( !$this->user ){ return false; }
        
        // get password
        $password = $request->input( 'password' );

        // handle exceptions
        try {
        
            // create adminKey
            $adminKey = new Key( $this->appCode, $this->user );

            // get key
            $key = $adminKey->getKey( 'password' );
            
            // ! key
            if( !$key ){ return false; }
            
            // encrypt password
            $encryptedPassword = base64_encode( 
                                    hash_hmac( env( $this->appCode . '_ADMIN_AUTHORISATION_PASSWORD_HASH' ), 
                                    $password . 
                                    $this->user->password_token, 
                                    $key, 
                                    true 
                                ) );
            // encrypt password

            // debug info
            $this->debug( 'encryptedPassword: ' . $encryptedPassword );
            
            // compare encrypted passwords
            if( !hash_equals( $encryptedPassword, $this->user->password ) ){

                // debug info
                $this->debug( 'encryptedPassword ! user password ' );
                // done invalid
                return false;

            }
            // compare encrypted passwords
            
            // debug info
            $this->debug( 'AdminPasswordHash valid ' );
                
            // valid
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminPasswordHash validate error: ' . $e->getMessage() );
            
            // done with error
            return false;
            
        }
        // handle exceptions        

    }
   
}