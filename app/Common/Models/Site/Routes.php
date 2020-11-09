<?php

/*
        @package    Pleisterman/Common
  
        file:       Routes.php
        function:   
                    
        Last revision: 01-01-2020
 
*/

namespace App\Common\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Routes extends Model
{
    
    static public function getRoutes( $database ) {
        
        // get routes
        $routes = DB::connection( $database )
                      ->table(  'site_routes' )
                      ->select( 'id', 
                                'game_id', 
                                'language_id', 
                                'name', 
                                'route', 
                                'is_public' )
                      ->get();
        // get routes
        
        // create result
        $result = array();
        
        // loop over routes
        forEach( $routes as $route ) {
        
            // add to color to result
            $result[$route->name] = array( 
                'id'          =>  $route->id,
                'gameId'      =>  $route->game_id,
                'languageId'  =>  $route->language_id,
                'name'        =>  $route->name,
                'route'       =>  $route->route,
                'public'      =>  $route->is_public
            );

        }
        // loop over routes        
     
        // return result
        return $result;
        
    }
    static public function getRoute( $database, $id ) {
        
        // get route
        $route = DB::connection( $database )
                     ->table(  'site_routes' )
                     ->where( 'id', $id )
                     ->first();
        // get route
        
        // return route
        return $route;
        
    }
    static public function findRoute( $database, $languageId, $route, $mobile, $showNotPublic ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table(  'site_routes' )
                     ->where( 'route', $route );
        
        // mobile / else
        if( $mobile ){

             // add mobile 
            $query->where( 'is_mobile', 1 ); 
            
        }
        else {
            
             // add ! mobile 
            $query->where( 'is_mobile', 0 ); 
            
        }
        // mobile  / else
                
        // language id / else
        if( $languageId ){

             // add language 
            $query->where( 'language_id', $languageId ); 
            
        }
        else {
            
             // add language 
            $query->whereNull( 'language_id' );
            
        }
        // language id  / else
                
        // ! show not public
        if( !$showNotPublic ){
            
            // add public
            $query->where( 'is_public', true );
            
        } 
        // ! show not public
        
        // return execute
        return $query->first();
        
    }    
    static public function findParentRoute( $database, $parentId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table(  'site_routes' )
                     ->where(  'id', $parentId );
        
        // return execute
        return $query->first();
        
    }    
    static public function findNotFoundRoute( $database, $languageId, $showNotPublic ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table(  'site_routes' )
                     ->where(  'is_not_found_page', 1 );
        
        // language id / else
        if( $languageId ){

             // add language 
            $query->where( 'language_id', $languageId ); 
            
        }
        else {
            
             // add language 
            $query->whereNull( 'language_id' );
            
        }
        // language id  / else
                
        // ! show not public
        if( !$showNotPublic ){
            
            // add public
            $query->where( 'is_public', true );
            
        } 
        // ! show not public
        
        // return execute
        return $query->first();
        
    }    
    static public function findErrorRoute( $database, $languageId, $showNotPublic ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table(  'site_routes' )
                     ->where(  'is_error_page', 1 );
        
        // language id / else
        if( $languageId ){

             // add language 
            $query->where( 'language_id', $languageId ); 
            
        }
        else {
            
             // add language 
            $query->whereNull( 'language_id' );
            
        }
        // language id  / else
                
        // ! show not public
        if( !$showNotPublic ){
            
            // add public
            $query->where( 'is_public', true );
            
        } 
        // ! show not public
        
        // return execute
        return $query->first();
        
    }    
    static public function getlanguageRoutes( $database, $languages, $route ) {
        
        // get page
        $page = DB::connection( $database )
                    ->table(  'site_routes' )
                    ->select( 'id', 
                              'parent_id', 
                              'language_id', 
                              'route' )
                    ->where(  'route', $route )
                    ->first();
        // get page
        
        // page exists and has parent / else
        if( $page && $page->parent_id ){
            
            // get parent
            $parent = DB::connection( $database )
                          ->table(  'site_routes' )
                          ->select( 'id', 
                                    'language_id', 
                                    'route' )
                          ->where(  'id', $page->parent_id )
                          ->first();
            // get page
            
        }
        else {
            
            // set parent
            $parent = $page;
            
        }
        // page exists and has parent / else
        
        // get children
        $children = DB::connection( $database )
                        ->table(  'site_routes' )
                        ->select( 'id', 
                                  'language_id', 
                                  'route' )
                        ->where(  'parent_id', $parent->id )
                        ->get();
        // get children
        
        // create language routes 
        $languageRoutes = array();
        
        // loop over languages
        forEach( $languages as $index => $language ) {
            
            // loop over children
            forEach( $children as $child ) {
            
                if( $child->language_id == $index ){
                    
                    // add to translation to array
                    $languageRoutes[$index] = $child->route;
                    
                }
                
            }
            // loop over children
            
            // not found in children
            if( !isset( $languageRoutes[$index] ) ){
                
                // set route
                $languageRoutes[$index] = $parent->route;
                
            }
            // not found in children
            
        }
        // loop over languages
        
        // return language routes
        return $languageRoutes;
        
    }
    static public function getRouteTranslation( $database, $languageId, $route ) {
        
        // get page
        $page = DB::connection( $database )
                    ->table(  'site_routes' )
                    ->select( 'id', 
                              'parent_id', 
                              'language_id', 
                              'route' )
                    ->where(  'route', $route )
                    ->first();
        // get page
        
        // page exists and has parent / else
        if( $page && $page->parent_id ){
            
            // get parent
            $parent = DB::connection( $database )
                          ->table(     'site_routes' )
                          ->select(    'id', 
                                       'language_id', 
                                       'route' )
                          ->where(     'id', $page->parent_id )
                          ->whereNull( 'language_id' )
                          ->first();
            // get page
            
        }
        else {
            
            // set parent
            $parent = $page;
            
        }
        // page exists and has parent / else
        
        // get child
        $child = DB::connection( $database )
                     ->table(  'site_routes' )
                     ->select( 'id', 
                               'language_id', 
                               'route' )
                     ->where(  'parent_id', $parent->id )
                     ->where(  'language_id', $languageId )
                     ->first();
        // get child
        
        // child exists
        if( $child ){
            
            // return child route
            return $child->route;
            
        }
        // child exists
    
        // parent exists
        if( $parent ){
            
            // return parent route
            return $parent->route;
            
        }
        // parent exists
    
        // page exists
        if( $page ){
            
            // return page route
            return $page->route;
            
        }
        // page exists
    
        // no translation found
        return $route;
        
    }
    
}
