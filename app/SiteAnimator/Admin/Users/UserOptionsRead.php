<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       UserOptionsRead.php
        function:   
                    
        Last revision: 18-02-2020
 
*/

namespace App\SiteAnimator\Admin\Users;

use App\Common\Base\BaseClass;
use Illuminate\Support\Facades\DB;
use App\Common\Models\Admin\Authentication\AdminUsers;

class UserOptionsRead extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function read( $selection ){

        // create users
        $users = new AdminUsers();
        
        // get user
        $user = $users->getUserRowByUid( $this->database, $selection['uid'] );

        // type is main
        if( $selection['type'] == 'main' ){
            
            // return get main options
            return $this->getMainOptions( $user, $selection );
            
        }
        else {
            
            // return get options
            return $this->getOptions( $user, $selection );
            
        }
        // type is main
        
    }
    private function getMainOptions( $user, $selection ) {
        
        // create result
        $result = array(
            'user' => array (
                'name'       =>  $user->name,
                'loginName'  =>  $user->loginName,
                'email'      =>  $user->email,
                'updatedAt'  =>  $user->updatedAt,
            ),
            'options'        =>  $this->getOptions( $user, $selection )
        );
        // create result
       
        // return result
        return $result;
        
    }
    private function getOptions( $user, $selection ) {
    
        // create result
        $result = array();
        
        // get user options
        $userOptions = DB::connection( $this->database )
                           ->table(  'admin_user_options' )
                           ->select( 'id', 
                                     'name', 
                                     'value',
                                     'updated_at as updatedAt',
                                     'edit_options as editOptions' )
                            ->where( 'type', $selection['type'] )
                            ->where( 'user_id', $user->id )
                            ->orderBy( 'sequence' )
                            ->get(); 
        // get user options
        
        // loop over user options
        forEach( $userOptions as $index => $userOption ) {

            // create option
            $option = array(
                'id'            =>  $userOption->id,
                'name'          =>  $userOption->name,
                'updatedAt'     =>  $userOption->updatedAt
            );
            // create option
            
            // get edit settings
            $option['editOptions'] = json_decode( $userOption->editOptions, true );
        
            // parse value
            $option['value'] = $this->parseValue( $option['editOptions']['type'],
                                                  $userOption->value );
            // parse value
            
            // add option to result
            array_push( $result, $option );
        }
        // loop over user options
        
        // return result
        return $result;
        
    }
    private function parseValue( $type, $value ){
        
        // type is boolean
        if( $type == 'boolean' ){

            // get boolean value
            $value = $value == 'true' ? true : false;

        }
        // type is boolean
        
        // type is json
        if( $type == 'json' ){

            // get json value
            $value = json_decode( $value, true );

        }
        // type is json
        
        // return result
        return $value;
    }
    
}
