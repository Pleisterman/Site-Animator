<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddFonts.php
        function:   
                    
        Last revision: 12-02-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class AddFonts extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator site AddFonts' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get fonts
        $fonts = SiteOptions::getOptions( $database, 'font' );
  
        // create font array
        $fontArray = array();
        
        // loop over fonts
        forEach( $fonts as $font ) {
        
            // add to font array
            $fontArray[$font->name] = json_decode( $font->value, true );

        }
        // loop over fonts

        // set colors
        $request->attributes->set( 'siteFonts', $fontArray );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
