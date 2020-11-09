<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddCss.php
        function:   
                    
        Last revision: 07-06-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class AddCss extends BaseClass {
    
    protected $debugOn = true;
    protected $database = array();
    protected $css = array();
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator site AddCss' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $this->database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get css
        $this->getCss( null, 'root', false );
  
        // set css
        $request->attributes->set( 'siteCss', $this->css );
        
        $this->debug( 'siteCss: ' . json_encode($this->css) );
        
        // follow the flow
        return $next( $request );
        
    }
    private function getCss( $groupId, $groupName, $isPublic ) {

        // create group
        $group = array(
            'name'      =>  $groupName,
            'isPublic'  =>  $isPublic,
            'items'     =>  array()
        );
        // create group
        
        // get item rows
        $itemRows = SiteOptions::getGroupOptions( $this->database, 
                                                  $groupId, 
                                                  'css', 
                                                  array( 'column' => 'name',
                                                         'direction' => 'ASC'
                                                  ));
        // get item rows

        // loop over item rows
        foreach( $itemRows as $index => $itemRow ){
            
            // group is public or item is public
            if( $group['isPublic'] == 1 || $itemRow->public == 1 ){
                
                // add item options
                array_push( $group['items'], json_decode( $itemRow->value ) );
                
            }
            // group is public or item is public
            
        }
        // loop over item rows
        
        // group is public or has items
        if( $group['isPublic'] == 1 || count( $group['items'] ) > 0 ){

            // add group
            $this->css[$group['name']] = $group['items'];
            
        }
        // group is public or has items
        
        // get group rows
        $groupRows = SiteOptions::getGroupOptions( $this->database, 
                                                   $groupId, 
                                                   'cssGroup', 
                                                    array( 'column' => 'sequence',
                                                           'direction' => 'ASC'
                                                    ));
        // get group rows
        
        // loop over group rows
        foreach( $groupRows as $index => $groupRow ){
            
            // call recursive
            $this->getCss( $groupRow->id, 
                           $group['name'] . '_' . $groupRow->name,
                           $groupRow->public );
            // call recursive
            
        }
        // loop over group rows
        
    }
    
}
