<?php

/*
        @package    Pleisterman/Common
  
        file:       Routes.php
        function:   
                    
        Last revision: 12-01-2020
 
*/

namespace App\Common\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Routes extends Model
{
    
    static public function findPage( $database, $languageId, $route, $mobile, $loggenIn ) {
        
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
                
        // ! logged in
        if( !$loggenIn ){
            
            // add public
            $query->where( 'public', 1 );
            
        } 
        // ! logged in
        
        // return execute
        return $query->first();
        
    }    
    static public function findParentPage( $database, $parentId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table(  'site_routes' )
                     ->where(  'id', $parentId );
        
        // return execute
        return $query->first();
        
    }    
    static public function findNotFoundPage( $database, $languageId, $loggenIn ) {
        
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
                
        // ! logged in
        if( !$loggenIn ){
            
            // add public
            $query->where( 'public', 1 );
            
        } 
        // ! logged in
        
        // return execute
        return $query->first();
        
    }    
    static public function findErrorPage( $database, $languageId, $loggenIn ) {
        
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
                
        // ! logged in
        if( !$loggenIn ){
            
            // add public
            $query->where( 'public', 1 );
            
        } 
        // ! logged in
        
        // return execute
        return $query->first();
        
    }    
    static public function getlanguageRoutes( $database, $siteLanguages, $route ) {
        
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
                                    'site_language_id', 
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
        forEach( $siteLanguages as $index => $language ) {
            
            // loop over children
            forEach( $children as $child ) {
            
                if( $child->language_id == $language['id'] ){
                    
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
    static public function getRouteTranslation( $database, $siteLanguageId, $route ) {
        
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
                          ->table(       'site_routes' )
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
                     ->where(  'language_id', $siteLanguageId )
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
