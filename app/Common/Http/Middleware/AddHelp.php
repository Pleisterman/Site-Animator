<?php

/*
        @package    Pleisterman/Common
  
        file:       AddHelp.php
        function:   
                    
        Last revision: 22-01-2020
 
*/

namespace App\Common\Http\Middleware;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Models\Help;

class AddHelp extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common AddHelp' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // add admin / site
        $isAdmin = isset( $action['isAdmin'] ) && $action['isAdmin'] ? true : false;
        
        // get user options
        $userOptions = $request->attributes->get( 'userOptions' );
         
        // get help subjects
        $helpSubjects = Help::getSubjects( $database, $isAdmin, $userOptions['languageId'] );

        // add admin / site
        $prefix = $isAdmin ? 'admin' : 'site';
        
        // set help subjects
        $request->attributes->set( $prefix . 'HelpSubjects', $helpSubjects );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
