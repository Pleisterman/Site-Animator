<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddSiteIndexTranslations.php
        function:   
                    
        Last revision: 10-03-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Admin;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Models\Translations;

class AddSiteIndexTranslations extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator site AddSiteIndexTranslations' );

        // get request action
        $action = $request->route()->getAction();
        
        // set database
        $database = $action['database'];
        
        // get index translations
        $translations = Translations::getTranslationsByType( $database, false, 'index' );

        // set translations
        $request->attributes->set( 'siteTranslations', $translations );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
