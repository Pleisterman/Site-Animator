<?php

/*
        @package    Pleisterman\Common
  
        file:       Token.php
        function:   
  
 
        Last revision: 03-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use Illuminate\Encryption\Encrypter;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\Key;
use App\Common\Models\Admin\Authentication\AdminTokens;
use App\Common\Models\Admin\Authentication\AdminIps;

class Token extends BaseClass  {

    protected $debugOn = true;
    private $cipher = null;
    private $encryptedToken = null;
    private $appCode = null;
    private $database = null;
    private $user = null;
    private $type = null;
    private $length = null;
    private $expirationPeriod = null;
    private $expiresAt = null;
    private $tokenRow = null;
    public function __construct( $appCode, $database, $user ){
        
        // call parent
        parent::__construct();
        
        // remember app name
        $this->appCode = $appCode;
        
        // remember database
        $this->database = $database;
        
        // remember user
        $this->user = $user;
        
        // set cipher
        $this->cipher = env( $this->appCode . '_ADMIN_AUTHORISATION_ENCRYPTION_CIPHER' );
            
    }
    public function create( $request, $type, $length, $expirationPeriod, $jsonWebTokenId = null ){

        // get valid encryption ciphers
        $validCiphers = explode( ',', env( 'AUTHORISATION_ADMIN_VALID_ENCRYPTION_CIPHERS' ) );
        
        // invalid cipher
        if( !in_array( $this->cipher, $validCiphers ) ){
            
            // debug info
            $this->debug( 'Admin Token Invalid cipher: ' . $this->cipher );     
            
            // return with error
            return false;
            
        }
        // invalid cipher
        
        // remember type
        $this->type = $type;

        // remember length
        $this->length = $length;

        // remember expiration period
        $this->expirationPeriod = $expirationPeriod;
        
        // create token
        if( $this->createToken( $request, $jsonWebTokenId ) ){
            
            // return encrypted token
            return $this->encryptedToken; 
            
        }
        // create token
            
        // return with error 
        return false;
        
    }   
    public function getId( ){
        
        // ! token row
        if( !$this->tokenRow ) { 
            
            // debug info
            $this->debug( 'Admin Token getId no row found.' );     
            
            // done
            return null; 
            
        }
        // ! token row
        
        // return row id
        return $this->tokenRow->id;
        
    }
    public function remove( $request, $tokenType, $encryptedToken ){

        // remember type
        $this->type = $tokenType;
        
        // remember token length
        $this->encryptedToken = $encryptedToken;

        // handle exceptions
        try {
        
            // ! get token row
            if( !$this->getTokenRow( $request ) ) { return; }
        
            // create key
            $adminKey = new Key( $this->appCode, $this->user );

            // get key
            $key = $adminKey->getKey( $this->tokenRow->id );
            
            // ! key
            if( !$key ){ return; }
            
            // remove key
            $adminKey->removeKey( $this->tokenRow->id );
            
            // remove row
            $this->tokenRow->delete();
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminUserToken remove token error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }   
    private function removeChildren() {
        
        // get children
        $childTokens = AdminTokens::on( $this->database )
                                    ->where( 'json_web_token_id', $this->tokenRow->id )
                                    ->get();
        // get children
            
        // create key
        $adminKey = new Key( $this->appCode, $this->user );

        // loop over children
        forEach( $childTokens as $childToken ){
            
            // remove key
            $adminKey->removeKey( $childToken->id );

            // remove token
            $childToken->delete();
            
        }
        // loop over children
        
    }
    private function createToken( $request, $jsonWebTokenId ){
        
        // handle exceptions
        try {
        
            // create key
            $key = new Key( $this->appCode, $this->user );
            
            // set expiration date
            if( !$this->setExpirationDate() ){ return false; }
        
            // key ! creatad
            if( !$key->create( $this->expiresAt ) ){ 
                
                // done with error
                return false; 
                
            }
            // key ! creatad
            
            // create token
            $this->token = str_random( $this->length );
            
            // create encryptor
            $encryptor = new Encrypter( $key->get(), $this->cipher );

            // create encrypted token
            $this->encryptedToken = $encryptor->encrypt( $this->token );        
            
            // ! save
            if( !$this->save( $request, $jsonWebTokenId ) ){ return false; }
            
            // save key
            if( !$key->save( $this->tokenRow->id ) ){ return false; }
            
            // return ok
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminUserToken create token error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
    private function setExpirationDate(){
        
        // handle exceptions
        try {
        
            // create expiration date
            $this->expiresAt = new \DateTime( 'now' );

            // calculate expiration
            $this->expiresAt->add( new \DateInterval( 'PT' . $this->expirationPeriod . 'S' ) );

            // debug info
            $this->debug( $this->expiresAt->format( 'Y-m-d H:i:s' ) );
        
            // done without errors
            return true;
        
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminUserToken set expiration date error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
    public function validate( $request, $tokenType, $encryptedToken ) {
        
        // remember type
        $this->type = $tokenType;
        
        // remember token length
        $this->encryptedToken = $encryptedToken;
        
        // validate token
        return $this->validateToken( $request );
        
    }
    private function validateExpirationDate(){
        
        // create date time
        $now = new \DateTime( 'now' );
        // create expires at date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->tokenRow['expires_at'] ); 
        
        // expired
        if( $date < $now ){
            
            // debug info
            $this->debug( 'AdminUserToken token expired ' );
            
            // done with error
            return false;
        }
        // expired
        
        // done without errors
        return true;
            
    }
    private function save( $request, $jsonWebTokenId ){
        
        // handle exceptions
        try {
            
            // ! validate encrypted token length
            if( !$this->validateEncryptedTokenLength() ){ return false; }
        
            // create token row
            $this->tokenRow = new AdminTokens();
            
            // set connection
            $this->tokenRow->setConnection( $this->database );
            
            // get user agent
            $userAgent = $request->attributes->get( 'userAgent' );
            
            // get ip
            $ip = $request->attributes->get( 'adminIp' );
            
            // set row values
            $this->tokenRow->user_id = $this->user->id;
            $this->tokenRow->ip_id = $ip->id;
            $this->tokenRow->user_agent = md5( $userAgent['userAgent'] );
            $this->tokenRow->type = $this->type;
            $this->tokenRow->expires_at = $this->expiresAt->format( 'Y-m-d H:i:s' );
            $this->tokenRow->token = $this->token;
            $this->tokenRow->encrypted_token = $this->encryptedToken;
            $this->tokenRow->json_web_token_id = $jsonWebTokenId;
            // set row values

            // save token row
            $this->tokenRow->save( );

            // debug info
            $this->debug( 'AdminToken save token type: ' . $this->type );
            $this->debug( 'AdminToken save token enc: ' . $this->encryptedToken );


            // done without errors
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminToken save token error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
    private function validateToken( $request ) {

        // ! get token row
        if( !$this->getTokenRow( $request ) ) { return false; }
        
        // ! validate ip
        if( !$this->validateIp( $request ) ) { return false; }
        
        // ! validate user agent
        if( !$this->validateUserAgent( $request ) ) { return false; }
        
        // ! validate expiration
        if( !$this->validateExpirationDate( ) ) { return false; }
        
        // handle exceptions
        try {
        
            // create adminKey
            $adminKey = new Key( $this->appCode, $this->user );

            // get key
            $key = $adminKey->getKey( $this->tokenRow->id );
            
            // ! key
            if( !$key ){ return false; }
            
            // create encryptor
            $encryptor = new Encrypter( $key, $this->cipher );

            // create decrypted token
            $decryptedToken = $encryptor->decrypt( $this->encryptedToken );
        
            // debug info
            $this->debug( 'decrypted token: ' . $decryptedToken );

            // compare tokens
            if( $decryptedToken !== $this->tokenRow['token'] ){

                // debug info
                $this->debug( 'AdminToken decrypted token not db token ' );

                // done invalid
                return false;
            
            }
            // compare tokens
            
            // debug info
            $this->debug( 'AdminUserToken decrypted token valid ' );
                
            // valid
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminUserToken create token error: ' . $e->getMessage() );
            
            // done with error
            return false;
            
        }
        // handle exceptions        

    }
    private function validateEncryptedTokenLength( ) {
        
        // encrypted token ! exists
        if( !$this->encryptedToken ){
            
            // debug info
            $this->debug( 'AdminUserToken validateEncryptedTokenLength encrypted token null' );
            
            // done invalid
            return false;
            
        }
        // encrypted token ! exists 
        
        // encrypted token < minimum encrypted token length
        if( strlen( $this->encryptedToken ) < env( 'AUTHORISATION_ADMIN_MINIMUM_TOKEN_LENGTH' ) ){
            
            // debug info
            $this->debug( 'AdminUserToken validateKeyLength encrypted token length invalid' );
            
            // done invalid
            return false;
            
        }
        // encrypted token < minimum encrypted token length
        
        // done valid
        return true;

    }
    private function getTokenRow( $request ) {
        
        // handle exceptions
        try {
        
            // get row with encrypted token
            $tokenRow = AdminTokens::on( $this->database )
                                     ->where( 'encrypted_token', $this->encryptedToken )
                                     ->where( 'user_id', '=', $this->user->id )
                                     ->where( 'type', '=', $this->type )
                                     ->first(); 
            // get row with encrypted token
    
            // row ! found
            if( !$tokenRow ){
                
                // debug info
                $this->debug( 'AdminUserToken getTokenRow token not found in database' );

                // type ! json web token
                if( $this->type !== 'jsonWebToken' ){
                    // block ip
                    $this->blockIp( $request );
                }
                // type ! json web token
                
                // debug info
                $this->debug( 'token: ' . $this->encryptedToken );
                
                // done with error
                return false;
                
            }
            // row ! found

            // set token row
            $this->tokenRow = $tokenRow;
            
            // done 
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminUserToken getTokenRow error: ' . $e->getMessage() );
            
            // done with error
            return false;
            
        }
        // handle exceptions
        
    }        
    private function validateIp( $request ){
        
        // get ip
        $ip = $request->attributes->get( 'adminIp' );
            
        // ! same user agent hash
        if( $this->tokenRow->ip_id != $ip->id ){
            
            // debug info
            $this->debug( 'ip ! the same. ' );
            
            // invalid
            return false;
            
        }
        // ! same user agent hash

        // debug info
        $this->debug( 'ip valid. ' );
            
        // valid
        return true;
            
    }
    private function validateUserAgent( $request ){
        
        // get user agent
        $userAgent = $request->attributes->get( 'userAgent' );
            
        // ! same user agent hash
        if( $this->tokenRow->user_agent != md5( $userAgent['userAgent'] ) ){
            
            // debug info
            $this->debug( 'user agent ! the same. ' );
            
            // invalid
            return false;
            
        }
        // ! same user agent hash

        // debug info
        $this->debug( 'user agent valid. ' );
        
        // valid
        return true;
        
    }
    private function blockIp( $request ){
        
        // get ip
        $ip = $request->attributes->get( 'adminIp' );
        
        // get ip
        $ipRow = AdminIps::on( $this->database )
                           ->where( 'id', $ip->id )
                           ->first();
        // get ip

        // ip row found
        if( $ipRow ){
        
            // block ip
            $ipRow->blocked = true;
            
            // get date time
            $now = new \DateTime( 'now' );            

            // create update at
            $updatedAt = $now->format( 'Y-m-d H:i:s' );

            // set updated at
            $ipRow->updated_at = $updatedAt;

            // save ip
            $ipRow->save();
            
        }
        // ip found
        
    }
   
}