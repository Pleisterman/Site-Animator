<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddColors.php
        function:   
                    
        Last revision: 11-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class AddColors extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator site AddColors' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get colors
        $colors = SiteOptions::getOptions( $database, 'color' );
  
        // create color array
        $colorArray = array();
        
        // loop over colors
        forEach( $colors as $color ) {
        
            // add to color array
            $colorArray[$color->name] = $color->value;

        }
        // loop over colors

        // set colors
        $request->attributes->set( 'siteColors', $colorArray );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
