<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteOptions.php
        function:   
                    
        Last revision: 13-05-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteOptions extends Model
{
    
    static public function getPageOptions( $database, $routeId, $showNotPublic ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->whereNull( 'parent_id' )
                     ->where( 'site_routes_id', $routeId )
                     ->orderBy( 'sequence', 'ASC' );
        // create query

        // ! show not public
        if( !$showNotPublic ){
            
            // add public
            $query->where( 'public', true );
            
        } 
        // ! show not public
        
        // return execute
        return $query->get();              
            
    }
    static public function getPageParts( $database, $optionId, $showNotPublic ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'parent_id', $optionId )
                     ->orderBy( 'sequence', 'ASC' );
        // create query

        // ! show not public
        if( !$showNotPublic ){
            
            // add public
            $query->where( 'public', true );
            
        } 
        // ! show not public
        
        // return execute
        return $query->get();              
        
    }
    static public function getOption( $database, $optionId, $type = null ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'id', $optionId );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null
        
        // return execute
        return $query->first();              
        
    }
    static public function getUsedOptions( $database, $optionId ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'part_id', $optionId );
        // create query
        
        // return used options
        return $query->get();
        
    }
    static public function getRootOption( $database, $type, $optionId, $name ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'type', $type );        
        // create query
                
        // option id exists / else 
        if( $optionId ){
            
            // add option id
            $query->where( 'id', $optionId );
            
        }
        else {
            
            // add name
            $query->where( 'name', $name );
            
        }
        // option id exists / else        

        // execute
        $rootPart = $query->first();              
        
        // root part ! exists
        if( !$rootPart ){
        
            // get top level part
            $rootPart = DB::connection( $database )
                            ->table( 'site_options' )                
                            ->where( 'type', $type )
                            ->whereNull( 'parent_id' )
                            ->first();
            // get top level part
            
        }
        // root part ! exists
        
        // return result
        return $rootPart;
              
    }
    static public function getOptionOptions( $database, $optionId, $type = null, $order = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'parent_id', $optionId );
        // create query

        // order exists / else
        if( $order != null ){
            
            // add order
            $query->orderBy( $order['column'], $order['direction'] );
            
        }
        else {
            
            // add order
            $query->orderBy( 'sequence', 'ASC' );
            
        }
        // order exists / else
        
        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null
        
        // return execute
        return $query->get();              
        
    }
    static public function getOptionOptionCount( $database, $optionId, $type = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'parent_id', $optionId );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null
        
        // return execute count
        return $query->count();              
        
    }
    static public function getOptionParts( $database, $optionId ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'parent_id', $optionId )
                     ->whereNull( 'type' )
                     ->orderBy( 'sequence', 'ASC' );
        // create query

        // return execute
        return $query->get();              
        
    }
    static public function getOptionPartsCount( $database, $optionId ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->whereNull( 'type' )
                     ->where( 'parent_id', $optionId );
        // create query

        // return execute count
        return $query->count();              
        
    }
    static public function getOptionListOptionsFirst( $database, $optionArray, $orderBy = 'sequence', $type = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->whereIn( 'parent_id', $optionArray )
                     ->orderBy( $orderBy, 'ASC' );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null
        
        // return execute
        return $query->first();              
        
    }
    static public function getOptionListOptionsFirstExcept( $database, $optionArray, $optionId, $orderOptions, $type = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'id', '!=', $optionId )
                     ->whereIn( 'parent_id', $optionArray );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null
        
        // order options exists
        if( isset( $orderOptions ) ){

            // order options type exists and sequence
            if( isset( $orderOptions['type'] ) && $orderOptions['type'] == 'sequence' ){

                // add sequence
                $query->where( 'sequence', '<', $orderOptions['sequence'] );

                // add order
                $query->orderBy( 'sequence', 'ASC' );

            }            
            // order options type exists and sequence
        
            // order options type exists and created at
            if( isset( $orderOptions['type'] ) && $orderOptions['type'] == 'createdAt' ){

                // add sequence
                $query->where( 'created_at', '<', $orderOptions['createdAt'] );

                // add order
                $query->orderBy( 'created_at', 'ASC' );

            }            
            // order options type exists and created at
        
        }            
        // order options exists
        
        // return execute
        return $query->first();              
        
    }
    static public function getOptionListOptionsPrevious( $database, $optionArray, $optionId, $orderOptions, $type = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'id', '!=', $optionId )
                     ->whereIn( 'parent_id', $optionArray );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null

        // order options exists
        if( isset( $orderOptions ) ){

            // order options type exists and sequence
            if( isset( $orderOptions['type'] ) && $orderOptions['type'] == 'sequence' ){

                // add sequence
                $query->where( 'sequence', '<', $orderOptions['sequence'] );

                // add order
                $query->orderBy( 'sequence', 'DESC' );

            }            
            // order options type exists and sequence
        
            // order options type exists and created at
            if( isset( $orderOptions['type'] ) && $orderOptions['type'] == 'createdAt' ){

                // add sequence
                $query->where( 'created_at', '<', $orderOptions['createdAt'] );

                // add order
                $query->orderBy( 'created_at', 'DESC' );

            }            
            // order options type exists and created at
        
        }            
        // order options exists

        // return execute
        return $query->first();              
        
    }
    static public function getOptionListOptionsNext( $database, $optionArray, $optionId, $orderOptions, $type = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'id', '!=', $optionId )
                     ->whereIn( 'parent_id', $optionArray );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null

        // order options exists
        if( isset( $orderOptions ) ){

            // order options type exists and sequence
            if( isset( $orderOptions['type'] ) && $orderOptions['type'] == 'sequence' ){

                // add sequence
                $query->where( 'sequence', '>', $orderOptions['sequence'] );

                // add order
                $query->orderBy( 'sequence', 'DESC' );

            }            
            // order options type exists and sequence
        
            // order options type exists and created at
            if( isset( $orderOptions['type'] ) && $orderOptions['type'] == 'createdAt' ){

                // add sequence
                $query->where( 'created_at', '>', $orderOptions['createdAt'] );

                // add order
                $query->orderBy( 'created_at', 'DESC' );

            }            
            // order options type exists and created at
        
        }            
        // order options exists

        // return execute
        return $query->first();              
        
    }
    static public function getOptionListOptionsLast( $database, $optionArray, $orderBy = 'sequence', $type = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->whereIn( 'parent_id', $optionArray )
                     ->orderBy( $orderBy, 'DESC' );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null
        
        // return execute
        return $query->first();              
        
    }
    static public function getOptionListOptionsLastExcept( $database, $optionArray, $optionId, $orderOptions, $type = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'id', '!=', $optionId )
                     ->whereIn( 'parent_id', $optionArray );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null
        
        // order options exists
        if( isset( $orderOptions ) ){

            // order options type exists and sequence
            if( isset( $orderOptions['type'] ) && $orderOptions['type'] == 'sequence' ){

                // add sequence
                $query->where( 'sequence', '>', $orderOptions['sequence'] );

                // add order
                $query->orderBy( 'sequence', 'DESC' );

            }            
            // order options type exists and sequence
        
            // order options type exists and created at
            if( isset( $orderOptions['type'] ) && $orderOptions['type'] == 'createdAt' ){

                // add sequence
                $query->where( 'created_at', '>', $orderOptions['createdAt'] );

                // add order
                $query->orderBy( 'created_at', 'DESC' );

            }            
            // order options type and created at
        
        }            
        // order options exists
        
        // return execute
        return $query->first();              
        
    }
    static public function getOptionListOptionsLastList( $database, $optionArray, $number, $order, $type = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )
                     ->take( $number )
                     ->whereIn( 'parent_id', $optionArray )
                     ->orderBy( $order, 'DESC' );
        // create query

        // type ! null
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        // type ! null
                
        // return execute
        return $query->get();              
        
    }
    static public function getOptions( $database, $type ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'type', $type )
                     ->orderBy( 'sequence', 'ASC' );
        // create query

        // return execute
        return $query->get();              
        
    }
    static public function getGroupOptions( $database, $groupId, $type, $orderBy = null ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'type', $type );

        // order by is null / else
        if( $orderBy == null ){
            
            // add default order
            $query->orderBy( 'sequence', 'ASC' );
            
        }
        else {
            
            // add order by
            $query->orderBy( $orderBy['column'], $orderBy['direction'] );
            
        }
        // group id is null / else
        
        
        // group id is null / else
        if( $groupId == null ){
            
            // add group id null
            $query->whereNull( 'parent_id' );
            
        }
        else {
            
            // add group id
            $query->where( 'parent_id', $groupId );
            
        }
        // group id is null / else
        
        // return execute
        return $query->get();              
        
    }
    static public function getGroupCount( $database, $groupId, $type ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'type', $type );
        
        // group id is null / else
        if( $groupId == null ){
            
            // add group id null
            $query->whereNull( 'parent_id' );
            
        }
        else {
            
            // add group id
            $query->where( 'parent_id', $groupId );
            
        }
        // group id is null / else
        
        // return execute
        return $query->count(); 
        
    }
    static public function getOptionCount( $database, $groupId, $type ) {

        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'type', $type );
        
        // group id is null / else
        if( $groupId == null ){
            
            // add group id null
            $query->whereNull( 'parent_id' );
            
        }
        else {
            
            // add group id
            $query->where( 'parent_id', $groupId );
            
        }
        // group id is null / else
        
        // return execute
        return $query->count(); 
        
    }
    
}
