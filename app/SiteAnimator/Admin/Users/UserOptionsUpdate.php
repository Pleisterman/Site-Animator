<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       UserOptionsUpdate.php
        function:   
                    
        Last revision: 17-02-2020
 
*/

namespace App\SiteAnimator\Admin\Users;

use App\Common\Base\BaseClass;
use App\Common\Models\Admin\Authentication\AdminUsers;
use App\SiteAnimator\Admin\Users\UserPrepareUpdate;
use App\SiteAnimator\Admin\Users\UserOptionsPrepareUpdate;
use App\SiteAnimator\Admin\Users\UserSave;
use App\SiteAnimator\Admin\Users\UserOptionsSave;

class UserOptionsUpdate extends BaseClass {

    protected $debugOn = true;
    private $error = 'somethingWentWrong';
    private $errorObject = null;
    private $appCode = null;
    private $database = null;
    private $userRow = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function update( $selection, $data ){

        // get user
        $user = AdminUsers::getUserByUid( $this->database, $selection['uid'] );

        // user ! found
        if( !$user ){
            
            // return error
            return array(
                'error'     =>   'userNotFound'
            );
            // return error
            
        }
        // user ! found
        
        // is main
        if( isset( $selection['type'] ) && $selection['type'] == 'main' ){

            // update main
            return $this->updateMain( $user, $data );
            
        }
        // is main
        
        // update options
        return $this->updateOptions( $user, $data );

    }
    private function updateMain ( $user, $data ) {
        
        // create user update
        $userPrepareUpdate = new UserPrepareUpdate( $this->database, $this->appCode );

        // prepare update user
        $userPrepareUpdateResult = $userPrepareUpdate->prepareUpdate( $user, $data['user'] );
        
        // result exists
        if( $userPrepareUpdateResult ){

            // done 
            return $userPrepareUpdateResult;

        }
        // result exists
        
        // options exists
        if( isset( $data['options'] ) ){
        
            // create user options prepare update
            $userOptionsPrepareUpdate = new UserOptionsPrepareUpdate( $this->database, $this->appCode );

            // prepare update user options
            $userOptionsPrepareUpdateResult = $userOptionsPrepareUpdate->prepareUpdate( $data['options'] );

            // result exists
            if( $userOptionsPrepareUpdateResult ){

                // done 
                return $userOptionsPrepareUpdateResult;

            }
            // result exists

        }
        // options exists
        
        // create result
        $result = array(
            'user'     => $this->saveUser( $user, $data['user'] )
        );
        // create result

        // options exists
        if( isset( $data['options'] ) ){
        
            // save options
            $result['options'] = $this->saveOptions( $data['options'] );

        }
        // options exists
        
        // return result
        return $result;
        
    }
    private function updateOptions ( $user, $data ) {
        
        // create user options prepare update
        $userOptionsPrepareUpdate = new UserOptionsPrepareUpdate( $this->database, $this->appCode );

        // prepare update user options
        $userOptionsPrepareUpdateResult = $userOptionsPrepareUpdate->prepareUpdate( $data );
        
        // result exists
        if( $userOptionsPrepareUpdateResult ){

            // done 
            return $userOptionsPrepareUpdateResult;

        }
        // result exists
        
        // create result
        $result = array(
            'optionsUpdatedAt'  => $this->saveOptions( $data ),
            
        );
        // create result
        
        // return result
        return $result;
        
    }
    private function saveUser ( $user, $data ) {
        
        // create user save
        $userUpdate = new UserSave( $this->database, $this->appCode );

        // save user options
        return $userUpdate->save( $user, $data );
        
    }
    private function saveOptions ( $data ) {
        
        // create user options save
        $userOptionsUpdate = new UserOptionsSave( $this->database, $this->appCode );

        // save user options
        return $userOptionsUpdate->save( $data );
        
    }
    
}
