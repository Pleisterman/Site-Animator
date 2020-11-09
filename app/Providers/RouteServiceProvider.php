<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers//RouteServiceProvider.php
        function:   creates the api and web routes
  
 
        Last revision: 01-02-2019
 
*/

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    
    protected $namespace = 'App';
    protected $appName = '';
    public function boot( Router $router )
    {
        // call parent
        parent::boot($router);
        
    }
    public function map()
    {
        
        // get apps var
        $apps = explode( ',', ENV( "APPS" ) );

        // loop over apps
        for( $i = 0; $i < count( $apps ); $i++ ){
            
            // set app name
            $this->appName = $apps[$i];
            
            // create api routes
            $this->mapApiRoutes( );

            // create web routes
            $this->mapWebRoutes( );
            
        }
        // loop over apps
        
                
    }
    protected function mapWebRoutes( )
    {
        
        // create route group
        Route::group( 
            [ 'namespace' => $this->namespace, ], 
            function ( $router ) {
            
                require base_path('routes/' . $this->appName . '/web.php');
                
            } 
        );
        // create route group
        
    }
    protected function mapApiRoutes()
    {
        
        // create route group
        Route::group(
            [ 'namespace' => $this->namespace ], 
            function ( $router ) {
            
                require base_path('routes/' . $this->appName . '/api.php');
                
            }
        );
        // create route group
        
    }
    
}
