<?php

/*
        @package    Pleisterman/MbAdmin
  
        file:       AdminUsers.php
        function:   
                    
        Last revision: 04-12-2019
 
*/

namespace App\Common\Models\Admin\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminUsers extends Model
{
    
    static public function getUserByUid( $database, $uid ) {
        
        // get options
        $user = DB::connection( $database )
                    ->table( 'admin_users' )
                    ->select( 'id', 
                              'uid', 
                              'name', 
                              'login_name', 
                              'email', 
                              'updated_at'  )
                    ->where( 'uid', $uid )
                    ->first();
        // get options

        // return user
        return $user;
        
    }
    static public function getUserRowByUid( $database, $uid ) {
        
        // get options
        $user = DB::connection( $database )
                    ->table( 'admin_users' )
                    ->select( 'id', 
                              'uid', 
                              'name', 
                              'login_name as loginName', 
                              'email', 
                              'route', 
                              'updated_at as updatedAt', 
                              'password_expires_at as passwordExpiresAt' )
                    ->where( 'uid', $uid )
                    ->first();
        // get options

        // return user
        return $user;
        
    }
    static public function getOptions( $database, $userId ) {
        
        // create result
        $result = array();

        // get options
        $options = DB::connection( $database )
                       ->table( 'admin_user_options' )
                       ->select( 'name', 'value' )
                       ->where( 'user_id', $userId )
                       ->get();
        // get options

        // loop over options
        forEach( $options as $option ) {
        
            // get value
            $value = $option->value;

            // convert boolean true
            if( $value === 'true' ){
              
                // set value
                $value = true;
                
            }
            // convert boolean true
            
            // convert boolean false
            if( $value === 'false' ){
              
                // set value
                $value = false;
                
            }
            // convert boolean false
            
            // convert boolean null
            if( $value === 'null' ){
              
                // set value
                $value = null;
                
            }
            // convert boolean null
            
            // add to option to result
            $result[$option->name] = $value;

        }
        // loop over options        
     
        // return result
        return $result;
        
    }
    
}
