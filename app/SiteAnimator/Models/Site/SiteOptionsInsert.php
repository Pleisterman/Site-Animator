<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteOptionsInsert.php
        function:   
                    
        Last revision: 07-04-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteOptionsInsert extends Model
{
    
    static public function optionsWithParentIdAndTypeAndNameExists( $database, $parentId, $type, $name ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'type', $type )        
                     ->where( 'name', $name );        
        // create query
                
        // parent id is null / else 
        if( $parentId == null ){
            
            // add parent id
            $query->whereNull( 'parent_id' );
            
        }
        else {
            
            // add parent id
            $query->where( 'parent_id', $parentId );
            
        }
        // parent id exists / else        
        
        // get count
        $count = $query->count();

        // type ! null
        if( $count > 0 ){
            
            // return is used
            return true;
            
        }
        // type ! null
        
        // return ! used
        return false;
        
    }
    static public function optionsWithParentIdAndNameExists( $database, $parentId, $name ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'parent_id', $parentId )                
                     ->where( 'name', $name );        
        // create query
                
        // get count
        $count = $query->count();

        // type ! null
        if( $count > 0 ){
            
            // return is used
            return true;
            
        }
        // type ! null
        
        // return ! used
        return false;
        
    }
    static public function insertOption( $database, $data, $sequence, $updatedAt ) {

        // insert site options row
        $id = DB::connection( $database )
                  ->table( 'site_options' )
                  ->insertGetId([
                    'name'           => $data['name'],
                    'public'         => isset( $data['isPublic'] ) && $data['isPublic'] ? 
                                        true : false,
                    'is_template'    => isset( $data['isTemplate'] ) && $data['isTemplate'] ? 
                                        $data['isTemplate'] : false,
                    'parent_id'      => $data['parentId'] ? $data['parentId'] : null,
                    'part_id'        => isset( $data['partId'] ) ? $data['partId'] : null,
                    'type'           => isset( $data['type'] ) ? $data['type'] : null,
                    'sequence'       => $sequence ? $sequence : null,
                    'value'          => isset( $data['options'] ) && $data['options'] != null ? json_encode( $data['options'] ) : '{}',
                    'updated_at'     => $updatedAt,
                    'created_at'     => $updatedAt
                  ]);    
        // insert site options row
    
        // return id
        return $id;
        
    }
    
}
