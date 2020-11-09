<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       UserPrepareUpdate.php
        function:   
                    
        Last revision: 17-02-2020
 
*/

namespace App\SiteAnimator\Admin\Users;

use App\Http\Base\BaseClass;
use Illuminate\Support\Facades\DB;

class UserPrepareUpdate extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $hasError = null;
    private $error = null;
    private $errorObject = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function prepareUpdate( $user, $data ){
        
        // create has error
        $hasError = false;

        // validate updated at
        if( !$hasError && !$this->validateUpdatedAt( $user, $data['updatedAt'] ) ){

            // remember has error
            $hasError = true;
            
        }
        // validate name
        
        // validate name
        if( !$hasError && !$this->validateName( $user, $data['name'] ) ){

            // remember has error
            $hasError = true;
            
        }
        // validate name
                
        // validate login name
        if( !$hasError && !$this->validateLoginName( $user, $data['loginName'] ) ){

            // remember has error
            $hasError = true;
            
        }
        // validate login name
                
        // validate email
        if( !$hasError && !$this->validateEmail( $user, $data['email'] ) ){

            // remember has error
            $hasError = true;
            
        }
        // validate email

        // has error
        if( $hasError ){
            
            // create error
            $error = array(
                'error'         =>   $this->error,
                'errorObject'   =>   $this->errorObject
            );

            // return error
            return $error;
            
        }
        // has error
        
    }    
    private function validateUpdatedAt( $user, $updatedAt ){
        
        // debug info
        $this->debug( 'validateUpdatedAt: ' . $updatedAt );

        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $user->updated_at ); 

        $dataDate = \DateTime::createFromFormat( 'Y-m-d H:i:s', $updatedAt ); 

        // updated at ! updated at
        if( $date != $dataDate ){

            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'dataOutOfDate';

            // return invalid
            return false;

        }
        // updated at ! updated at

        // valid
        return true;
        
    }
    private function validateName( $user, $name ){
        
        // get user with name and different id
        $otherUser = DB::connection( $this->database )
                         ->table( 'admin_users' )
                         ->where( 'id', '!=' , $user->id )
                         ->where( 'name', $name )
                         ->first();        
        // get user with name and different id
        
        // other user exists
        if( $otherUser ){
        
            $this->debug( 'user found userId: ' . $otherUser->id );
        
            // set error
            $this->error = 'UserNameExists';
            
            // set error object
            $this->errorObject = 'name';
            
            // done with error
            return false;
            
        }
        // other user exists
        
        // valid
        return true;
        
    }
    private function validateLoginName( $user, $loginName ){

        // get user with login name and different id
        $otherUser = DB::connection( $this->database )
                    ->table( 'admin_users' )
                    ->where( 'id', '!=' , $user->id )
                    ->where( 'login_name', $loginName )
                    ->first();        
        // get user with login name and different id
        
        // other user exists
        if( $otherUser ){
        
            // set error
            $this->error = 'UserLoginNameExists';
            
            // set error object
            $this->errorObject = 'loginName';
            
            // done with error
            return false;
            
        }
        // other user exists
        
        // valid
        return true;
        
    }
    private function validateEmail( $user, $email ){
        
        // valid
        return true;
        
    }
}
