<?php

/*
        @package    Pleisterman/Common
  
        file:       AddSettings.php
        function:   
                    
        Last revision: 10-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\Settings;

class AddSettings extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator Site AddSettings' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get settings
        $settings = Settings::getSettings( $database );
        
        // set settings
        $request->attributes->set( 'siteSettings', $settings );

        // follow the flow
        return $next( $request );
        
    }
    
}
