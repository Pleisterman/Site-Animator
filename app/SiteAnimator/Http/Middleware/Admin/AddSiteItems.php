<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddSiteItems.php
        function:   
                    
        Last revision: 21-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Admin;

use Closure;
use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;

class AddSiteItems extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator admin AddSiteItems' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get site items
        $siteItemRows = SiteItems::getItems( $database );
  
        // create site items
        $siteItems = array();
        
        // loop over site items
        forEach( $siteItemRows as $siteItemRow ) {
        
            // add to font array
            $siteItems[$siteItemRow->type] = array(
                'partId'    =>  $siteItemRow->site_options_id,
                'options'   =>  json_decode( $siteItemRow->options, true )
            );
            // add to font array
            
        }
        // loop over site items

        // set site items
        $request->attributes->set( 'siteItems', $siteItems );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
