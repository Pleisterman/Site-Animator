<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddAnimationSequences.php
        function:   
                    
        Last revision: 10-03-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class AddAnimationSequences extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator site AddAnimationSequences' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get animation sequences
        $sequences = SiteOptions::getOptions( $database, 'animationSequence' );
  
        // create sequence array
        $sequenceArray = array();
        
        // loop over sequences
        forEach( $sequences as $sequence ) {
        
            // add to sequence array
            $sequenceArray[$sequence->name] = json_decode( $sequence->value );

        }
        // loop over sequences

        // set animation sequences
        $request->attributes->set( 'animationSequences', $sequenceArray );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
