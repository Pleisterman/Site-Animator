<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       UserSave.php
        function:   
                    
        Last revision: 18-02-2020
 
*/

namespace App\SiteAnimator\Admin\Users;

use Illuminate\Support\Facades\DB;
use App\Common\Base\BaseClass;

class UserSave extends BaseClass {

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
    public function save( $user, $data ){
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // update user
        DB::connection( $this->database )
            ->table(  'admin_users' )            
            ->where(  'id', $user->id )    
            ->update( [ 'name'              => $data['name'], 
                        'login_name'        => $data['loginName'], 
                        'email'             => $data['email'], 
                        'updated_at'        => $updatedAt] );
        // update user
        
        // return updated at
        return array( 'updatedAt' => $updatedAt );
        
    }
    
}
