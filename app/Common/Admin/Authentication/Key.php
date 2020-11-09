<?php

/*
        @package    Pleisterman\Common
  
        file:       Key.php
        function:   
  
 
        Last revision: 28-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;

class Key extends BaseClass  {

    protected $debugOn = true;
    private $dir = null;
    private $fileName = null;
    private $keyId = null;
    private $key = null;
    private $expiresAt = null;
    private $length = null;
    public function __construct( $appName, $user ){
        
        // set dir
        $this->dir = env( $appName . '_ADMIN_AUTHORISATION_KEYS_DIR' );
        
        // set file name
        $this->fileName = $user->id . env( $appName . '_ADMIN_AUTHORISATION_KEYS_FILENAME_POSTFIX' );
        
        // set length
        $this->length = env( $appName . '_ADMIN_AUTHORISATION_KEY_LENGTH' );
        
        // call parent
        parent::__construct();
        
    }
    public function create( $expiresAt ){

        // handle exceptions
        try {
        
            // create key
            $this->key = str_random( $this->length );

            // create expiration date
            $this->expiresAt = $expiresAt;

            // ! validate key length
            if( !$this->validateKeyLength( ) ){ return false; }
        
            // return key
            return $this->key;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'Key create key error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
    public function get() {
        
        // return key
        return $this->key;
        
    }
    public function save( $keyId ){
        
        // handle exceptions
        try {

            // ! validate key length
            if( !$this->validateKeyLength( $this->length ) ){ return false; }
            
            // get json
            $json = json_decode( file_get_contents( storage_path() . $this->dir . $this->fileName ), true );

            // create key
            $json[$keyId] = array( 
                'key'           => $this->key,
                'expiresAt'     => $this->expiresAt->format( 'Y-m-d H:i:s' ) 
            );
            // create key

            // create string
            $jsonString = json_encode( $json );

            // debug info
            $this->debug( 'jsonString: ' . $jsonString );

            // save keys
            file_put_contents( storage_path() . $this->dir . $this->fileName, $jsonString );
        
            // done without errors
            return true;

        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminLoginKey save key error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
    public function getKey( $keyId ) {
        
        // ! read key
        if( !$this->readKey( $keyId ) ){ return false; }
        // ! validate key length
        if( !$this->validateKeyLength( ) ){ return false; }
        // ! validate expiration
        if( !$this->validateExpirationDate( ) ){ return false; }
        
        // return key
        return $this->key;
        
    }
    public function removeKey( $keyId ) {
        
        // handle exceptions
        try {
        
            // get keys
            $keys = json_decode( file_get_contents( storage_path() . $this->dir . $this->fileName ), true );
            
            // key ! exists
            if( !isset( $keys[$keyId] ) ){
                
                // debug info
                $this->debug( 'AdminLoginKey remove key error key not found ' . $keyId );
                
                // done
                return;
                
            }
            // key ! exists
            
            // remove key
            unset( $keys[$keyId] );
            
            // create string
            $jsonString = json_encode( $keys );

            // save keys
            file_put_contents( storage_path() . $this->dir . $this->fileName, $jsonString );
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminKey get key error: ' . $e->getMessage() );
            
        }
        // handle exceptions
        
    }
    private function readKey( $keyId ) {
        
        // handle exceptions
        try {
        
            // get keys
            $keys = json_decode( file_get_contents( storage_path() . $this->dir . $this->fileName ), true );
            
            // key ! exists
            if( !isset( $keys[$keyId] ) ){
                
                // debug info
                $this->debug( 'AdminLoginKey get key error key not found ' . $keyId );
                
                // done with error
                return false;
                
            }
            // key ! exists
            
            // set key 
            $this->keyId = $keyId;
            // set key 
            $this->key = $keys[$keyId]['key'];
            // set expiresAt
            $this->expiresAt = $keys[$keyId]['expiresAt'];
            
            // done 
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminKey get key error: ' . $e->getMessage() );
            
            // done with error
            return false;
            
        }
        // handle exceptions
        
        // done with error
        return false;
    }
    private function validateKeyLength( ) {
        
        // key ! exists
        if( !$this->key ){
            
            // debug info
            $this->debug( 'AdminKey validateKeyLength key null' );
            
            // done invalid
            return false;
            
        }
        // key ! exists 
        
        // key < minimum key length
        if( strlen( $this->key ) < $this->length ){
            
            // debug info
            $this->debug( 'AdminKey validateKeyLength key length invalid' );
            
            // done invalid
            return false;
            
        }
        // key < minimum key length
        
        // done valid
        return true;

    }
    private function validateExpirationDate( ) {
        
        // create date time
        $now = new \DateTime( 'now' );
        // create expires at date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->expiresAt ); 
        
        // expired
        if( $date < $now ){
            
            // debug info
            $this->debug( 'AdminKey key expired. ' );
            
            // done invalid
            return false;
            
        }
        // expired
        
        // done valid
        return true;
        
    }
    
}