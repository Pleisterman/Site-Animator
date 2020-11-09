<?php

/*
        @package    Pleisterman/Common
  
        file:       CleanTokens.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Models\Admin\Authentication\AdminTokens;

class CleanTokens extends BaseClass {
    
    protected $debugOn = true;
    private $database = 'none';
    private $user = null;
    private $appCode = null;
    private $dir = null;
    private $fileName = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin clean tokens' );

        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $this->database = $action['database'];
        
        // get app code
        $this->appCode = $action['appCode'];

        // get user
        $this->user = $request->attributes->get( 'adminUser' );
         
        // database / app code /  user ! exists
        if( !$this->database || !$this->appCode || !isset( $this->user ) ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->routeError( $request, 'values not set' );
            
        }
        // database / app code /  user ! exists
        
        // debug info
        $this->debug( 'user: ' . $this->user->name );

        // set dir
        $this->dir = env( $this->appCode . '_ADMIN_AUTHORISATION_KEYS_DIR' );
        
        // set file name
        $this->fileName = $this->user->id . env( $this->appCode . '_ADMIN_AUTHORISATION_KEYS_FILENAME_POSTFIX' );        
        
        // clean
        $this->clean();        
        
        // follow the flow
        return $next( $request );
        
    }
    private function clean( )
    {
        
        // debug
        $this->debug( 'clean ' );        

        // clean tokens
        $this->cleanTokens();  
        
        // clean keys
        $this->cleanKeys();          
        
    }
    private function cleanTokens(){
        
        // debug
        $this->debug( 'cleanTokens' );                
        
        // handle exceptions
        try {
        
            // create date time
            $now = new \DateTime( 'now' );

            // clean tokens
            AdminTokens::on( $this->database )
                         ->where( 'expires_at', '<', $now->format( 'Y-m-d H:i:s' ) )
                         ->where( 'user_id', $this->user->id )
                         ->delete();
            // clean tokens

            // clean page tokens
            AdminTokens::on( $this->database )
                         ->where( 'user_id', $this->user->id )
                         ->where( 'type', 'pageToken' )
                         ->whereNotNull( 'json_web_token_id' )
                         ->whereNotIn( 'json_web_token_id',
                                AdminTokens::on( $this->database )
                                ->select( 'id' )
                                ->where( 'type', 'jsonWebToken' )
                                ->get() )
                         ->delete();
            // clean page tokens
            
            
            // done without errors
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'cleanTokens error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
    private function cleanKeys(){
        
        // debug
        $this->debug( 'cleanKeys' );        
        
        // handle exceptions
        try {
        
            // create date time
            $now = new \DateTime( 'now' );

            // get json
            $json = json_decode( file_get_contents( storage_path() . $this->dir . $this->fileName ), true );

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

            // save keys
            file_put_contents( storage_path() . $this->dir . $this->fileName, $jsonString );
        
            // done without errors
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'cleanKeys error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }
    
}
