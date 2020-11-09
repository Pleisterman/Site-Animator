<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       Routes.php
        function:   
                    
        Last revision: 02-04-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Routes extends Model
{
    
    static public function getRouteById( $database, $id ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_routes' )
                     ->where( 'id', $id );
        // create query
        
        // return execute
        return $query->first(); 
        
    }
    static public function routeWithGroupIdAndNameExists( $database, $groupId, $name ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_routes' )
                 ->where(  'name', $name );
        // create query

        // group id ! null / else
        if( $groupId != null ){
            
            // add site options id
            $query->where( 'site_options_id', $groupId );
            
        }
        else {
            
            // add site options id
            $query->whereNull( 'site_options_id' );
            
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
    static public function routeWithoutIdWithGroupIdAndNameExists( $database, $id, $groupId, $name ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_routes' )
                 ->where(  'name', $name )
                 ->where(  'id', '!=', $id );
        // create query

        // group id ! null / else
        if( $groupId != null ){
            
            // add site options id
            $query->where( 'site_options_id', $groupId );
            
        }
        else {
            
            // add site options id
            $query->whereNull( 'site_options_id' );
            
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
    static public function getGroupRoutes( $database, $groupId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_routes' )
                     ->where( 'site_options_id', $groupId )
                     ->orderBy( 'name', 'ASC' );
        // create query
        
        // return execute
        return $query->get(); 
        
    }
    static public function getGroupRoutesCount( $database, $groupId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_routes' )
                     ->where( 'site_options_id', $groupId );
        // create query
        
        // return count
        return $query->count(); 
        
    }
    static public function insertRoute( $database, $data, $updatedAt ) {
        
        // insert route row
        $id = DB::connection( $database )
                  ->table(    'site_routes' )
                  ->insertGetId([
                    'name'                  => $data['name'],
                    'route'                 => $data['route'],
                    'parent_id'             => $data['parentId'] ? $data['parentId'] : null,
                    'site_options_id'       => $data['groupId'] ? $data['groupId'] : null,
                    'language_id'           => $data['languageId'] ? $data['languageId'] : null,
                    'is_public'             => $data['isPublic'] == 'true' ? 1 : 0,
                    'is_mobile'             => $data['isMobile'] == 'true' ? 1 : 0,
                    'is_not_found_page'     => $data['isNotFoundPage'] == 'true' ? 1 : 0,
                    'is_error_page'         => $data['isErrorPage'] == 'true' ? 1 : 0,
                    'is_maintenance_page'   => $data['isMaintenancePage'] == 'true' ? 1 : 0,
                    'options'               => isset( $data['options'] ) && $data['options'] != null ? json_encode( $data['options'] ) : '{}',              
                    'updated_at'            => $updatedAt,
                    'created_at'            => $updatedAt
                  ]);    
        // insert route row
    
        // return id
        return $id;
        
    }
    static public function updateRoute(  $database, $selection, $data, $updatedAt ) {
        
        $options = '{}';
        
        // options exists
        if( isset( $data['options'] ) ){
            
            // options ! null
            if( $data['options'] != null ){
                
                // set value json
                $options = json_encode( $data['options'] ) ? json_encode( $data['options'] ) : '{}';
            
            }
            // options ! null
            
        }
        // options exists
        
        // update route row
        DB::connection( $database )
            ->table(    'site_routes' )
            ->where( 'id', $selection['id'] )
            ->update([
                'name'                  => $data['name'],
                'route'                 => $data['route'],
                'parent_id'             => $data['parentId'] ? $data['parentId'] : null,
                'site_options_id'       => $data['groupId'] ? $data['groupId'] : null,
                'language_id'           => $data['languageId'] ? $data['languageId'] : null,
                'is_public'             => $data['isPublic'] == 'true' ? 1 : 0,
                'is_mobile'             => $data['isMobile'] == 'true' ? 1 : 0,
                'is_not_found_page'     => $data['isNotFoundPage'] == 'true' ? 1 : 0,
                'is_error_page'         => $data['isErrorPage'] == 'true' ? 1 : 0,
                'is_maintenance_page'   => $data['isMaintenancePage'] == 'true' ? 1 : 0,
                'options'               => $options,              
                'updated_at'            => $updatedAt,
            ]);
        // update route row
        
    }
    static public function deleteRoute( $database, $selection ) {
    
        // delete route row
        DB::connection( $database )
            ->table(    'site_routes' )
            ->where( 'id', $selection['id'] )
            ->delete();    
        // delete route row
        
    }
    
}
