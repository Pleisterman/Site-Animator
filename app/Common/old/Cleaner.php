<?php

/*
        @package    Pleisterman\CodeAnalyser
  
        file:       Cleaner.php
        function:   remove tokens of a user that have expired from the database
                    remove keys of a user that have expired from keys json file 
 
                    deletes expired user tokens and keys
 
        Last revision: 07-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;
use App\Common\Models\Admin\AdminTokens;

class Cleaner extends BaseClass {
    
    protected $debugOn = false;
    private $database = 'none';
    private $user = null;
    private $dir = null;
    private $fileName = null;
    public function __construct( $appName, $database, $user ){
        
        // debug
        $this->debug( 'Admin Cleaner create App name: ' . $appName );        
        
        // remember database
        $this->database = $database;
        
        // remember user
        $this->user = $user;
        
        // set dir
        $this->dir = env( $appName . '_ADMIN_AUTHORISATION_KEYS_DIR' );
        
        // set file name
        $this->fileName = $user->id . env( $appName . '_ADMIN_AUTHORISATION_KEYS_FILENAME_POSTFIX' );
        
        // call parent
        parent::__construct();
        
    }
    public function clean( )
    {
        
        // debug
        $this->debug( 'Admin Cleaner clean ' );        

        // clean tokens
        $this->cleanTokens();  
        
        // clean keys
        $this->cleanKeys();          
        
    }
    private function cleanTokens(){
        
        // debug
        $this->debug( 'Admin Cleaner cleanTokens' );                
        
        // handle exceptions
        try {
        
            // create date time
            $now = new \DateTime( 'now' );

            // clean tokens
            AdminTokens::on( $this->database )
                         ->where( 'expires_at', '<', $now->format( 'Y-m-d H:i:s' ) )
                         ->where( 'user_id', $this->user->id )
                         ->delete();
        
            // done without errors
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'Admin Cleaner cleanTokens error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
    private function cleanKeys(){
        
        // debug
        $this->debug( 'Admin Cleaner cleanKeys' );        
        
        // handle exceptions
        try {
        
            // create date time
            $now = new \DateTime( 'now' );

            // get json
            $json = json_decode( file_get_contents( storage_path() . $this->dir . $this->fileName ), true );

            // debug info
//            $this->debug( 'jsonString: ' . json_encode( $json, JSON_PRETTY_PRINT  ) );

            // create refreshed json
            $refreshedJson = array();

            // loop over json 
            foreach( $json as $id => $value ){

                // create expires at date
                $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $value['expiresAt'] ); 

                // not expired
                if( $date > $now ){

                    // add to refreshed value
                    $refreshedJson[$id] = $value;

                }
                // not expired

            }
            // loop over json 

            // create string
            $jsonString = json_encode( $refreshedJson );

            // debug info
//            $this->debug( 'refreshed jsonString: ' . json_encode( $refreshedJson, JSON_PRETTY_PRINT  ) );

            // save keys
            file_put_contents( storage_path() . $this->dir . $this->fileName, $jsonString );
        
            // done without errors
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'Admin Cleaner cleanKeys error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
}
