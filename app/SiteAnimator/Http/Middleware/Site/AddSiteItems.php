<?php

/*
        @package    Pleisterman/Common
  
        file:       AddSiteItems.php
        function:   
                    
        Last revision: 30-06-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItemsFiles;

class AddSiteItems extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator Site AddSiteItems' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get site item files
        $itemsFiles = SiteItemsFiles::getUsedFiles( $database );
        
        // get site item template files
        $templatesFiles = SiteItemsFiles::getUsedTemplatesFiles( $database );
        
        // merge arrays
        $siteItemsFiles = array_merge( $itemsFiles, $templatesFiles );
        
        // set files
        $request->attributes->set( 'siteItemsFiles', $templatesFiles );

        // follow the flow
        return $next( $request );
        
    }
    
}
