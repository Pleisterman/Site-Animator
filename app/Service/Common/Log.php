<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Service/Common/Log.php
        function:   logs debug information to the database
 
        Last revision: 01-02-2019
 
*/

namespace App\Service\Common;

use App\Http\Base\BaseClass;
use App\Models\Admin\AdminLog;

class Log extends BaseClass {
    
    protected $debugOn = false;
    private $logTable = null;
    public function __construct()
    {
        
    }
    
    public function log( $type, $message ){
       
        // create log table
        $this->logTable = new AdminLog();
        // set columns
        $this->logTable->type = $type;
        $this->logTable->message = $message;
        // save
        $this->logTable->save();
        
    }
}