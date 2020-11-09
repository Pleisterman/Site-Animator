<?php

/*
        @package    Pleisterman\CodeAnalyser
  
        file:       app/Http/Middleware/Admin/Authentication/CreateLoginToken.php
        function:   Login tokens are created in the first fase off the login
                    on the webroute
                    in the prepareLogin step the token will be validated
                    in the middleware validateLoginToken
 
                    create token with type loginToken
                    add encrypted token to the request attributes for javascript
                    
        Last revision: 07-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\PublicToken;
use App\Common\Admin\Authentication\PublicCookie;

class PublicTokens extends BaseClass {
    
    protected $debugOn = true;
    public function createToken( $user )
    {
        
        // debug
        $this->debug( 'CodeAnalyser middleware Admin PublicTokens create token' );        

        // create public token
        $publicToken = new PublicToken();

        // create token
        $token = $publicToken->create( $user );
        
        // token created
        if( $token ){
            
            // create cookie
            $publicCookie = new PublicCookie();
            
            // create cookie
            $cookie = $publicCookie->create( $user );
            
            // cookie created
            if( $cookie ){
                
                // return token
                return $token;
                
            }
            // cookie created
            
        }
        // token created
        
        // no token created
        return false;
        
    }
    public function validate( $user, $token ) {
        
        // create public token
        $publicToken = new PublicToken();

        // valid token
        if( $publicToken->validate( $user, $token ) ){
            
            // create cookie
            $publicCookie = new PublicCookie();
            
            // valid cookie
            if( $publicCookie->validate( $user ) ){
                
                // return valid
                return true;
                
            }
            // valid cookie
            
        }        
        // valid 
       
        // return invalid
        return false;
        
    }
    
}
