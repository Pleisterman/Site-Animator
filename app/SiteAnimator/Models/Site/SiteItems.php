<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteItems.php
        function:   
                    
        Last revision: 04-03-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteItems extends Model
{
    
    static public function getFirstPart( $database ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_items' )
                     ->where( 'site_options_id', '<>', '' )
                     ->orderBy( 'type', 'ASC' );
        // create query

        // return first
        return $query->first();              
            
    }
    static public function getItems( $database ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_items' )
                     ->orderBy( 'type', 'ASC' );
        // create query

        // return execute
        return $query->get();              
            
    }
    static public function getGroupSiteItems( $database, $groupId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_items' )
                     ->where( 'group_id', $groupId );
        // create query
        
        // return execute
        return $query->get(); 
        
    }
    static public function getRow( $database, $itemId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_items' )                
                     ->where( 'id', $itemId );
        // create query

        // return execute
        return $query->first();              
            
    }
    static public function getPageItem( $database ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_items' )                
                     ->whereNull( 'site_options_id' )                
                     ->where( 'type', 'page' );
        // create query

        // return execute
        return $query->first();              
            
    }
    static public function getPartItemId( $database, $partId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table(       'site_items' )  
                     ->select(      'site_items.id',
                                    'site_items.group_id' )
                     ->join(        'site_options', 
                                    'site_options.part_id', 
                                    '=', 
                                    'site_items.site_options_id' )               
                     ->where(       'site_options.id', $partId );
        // create query

        // return execute
        return $query->first();              
            
    }
    static public function getSiteItemPart( $database, $partId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table(       'site_items' )  
                     ->select(      'site_items.id',
                                    'site_items.group_id' )
                     ->join(        'site_options', 
                                    'site_options.id', 
                                    '=', 
                                    'site_items.site_options_id' )               
                     ->where(       'site_options.id', $partId );
        // create query

        // return execute
        return $query->first();              
            
    }
    static public function deleteSiteItem( $database, $selection ) {
    
        // delete site item row
        DB::connection( $database )
            ->table( 'site_items' )
            ->where( 'id', $selection['id'] )
            ->delete();    
        // delete site item row

    }
    static public function siteItemWithGroupIdAndTypeExists( $database, $groupId, $type ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_items' )
                 ->where(  'site_items.type', $type );
        // create query

        // group id ! null / else
        if( $groupId != null ){
            
            // add site options id
            $query->where( 'group_id', $groupId );
            
        }
        else {
            
            // add site options id
            $query->whereNull( 'group_id' );
            
        }
        // group id ! null / else
        
        // get count
        $count = $query->count();
        
        if( $count > 0 ){
            
            // return exists
            return true;
            
        }
          
        // return ! exists
        return false;
        
    }
    static public function itemsWithoutIdWithGroupIdAndTypeExists( $database, $id, $groupId, $type ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_items' )
                 ->where(  'site_items.type', $type )
                 ->where(  'id', '!=', $id );
        // create query

        // group id ! null / else
        if( $groupId != null ){
            
            // add site options id
            $query->where( 'group_id', $groupId );
            
        }
        else {
            
            // add site options id
            $query->whereNull( 'group_id' );
            
        }
        // group id ! null / else
        
        // get count
        $count = $query->count();
        
        if( $count > 0 ){
            
            // return exists
            return true;
            
        }
          
        // return ! exists
        return false;
        
    }
    static public function insertSiteItem( $database, $data, $updatedAt ) {
              
        // insert site item row
        $id = DB::connection( $database )
                  ->table(    'site_items' )
                  ->insertGetId([
                    'type'              => $data['type'],
                    'group_id'          => $data['groupId'] ? $data['groupId'] : null,
                    'options'           => isset( $data['options'] ) ? json_encode( $data['options'] ) : '{}',              
                    'updated_at'        => $updatedAt,
                    'created_at'        => $updatedAt
                  ]);    
        // insert site item row
    
        // return id
        return $id;
        
    }
    static public function updateSiteItem( $database, $selection, $data, $updatedAt ) {
        
        // update site item row
        DB::connection( $database )
            ->table( 'site_items' )
            ->where( 'id', $selection['id'] )
            ->update([
                'type'          => $data['type'],
                'group_id'      => $data['groupId'] ? $data['groupId'] : null,
                'options'       => isset($data['options'] ) ? json_encode( $data['options'] ) : '{}',              
                'updated_at'    => $updatedAt
            ]);
        // update site item row
        
    }
    
}
