<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddSettings.php
        function:   
                    
        Last revision: 22-01-2020
 
*/

namespace App\Common\Http\Middleware;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Models\Admin\Settings as AdminSettings;
use App\Common\Models\Site\Settings as SiteSettings;

class AddSettings extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common AddSettings' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // add admin / site
        $isAdmin = isset( $action['isAdmin'] ) && $action['isAdmin'] ? true : false;
        
        // is admin / else
        if( $isAdmin ){
            
            // get settings
            $settings = AdminSettings::getSettings( $database );
            
        }
        else {
            
            // get settings
            $settings = SiteSettings::getSettings( $database );
            
        }
        // is admin / else
        
        
        // add admin / site
        $prefix = $isAdmin ? 'admin' : 'site';
        
        // set colors
        $request->attributes->set( $prefix . 'Settings', $settings );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
