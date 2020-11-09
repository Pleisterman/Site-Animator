<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       PageParts.php
        function:   
                    
        Last revision: 22-04-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PageParts extends Model
{
    
    static public function nameExists( $database, $pageId, $name, $parentId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )
                     ->where( 'site_routes_id', $pageId )
                     ->where(  'name', $name );
        // create query

        // parent id ! null / else
        if( $parentId != null ){
            
            // add parent id
            $query->where( 'parent_id', $parentId );
            
        }
        else {
            
            // add parent id
            $query->whereNull( 'parent_id' );
            
        }
        // parent id ! null / else
        
        // return execute
        return $query->first(); 
        
    }
    static public function nameExistsExcept( $database, $routeId, $pagePartId, $name, $parentId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )
                     ->where( 'site_routes_id', $routeId )
                     ->where(  'name', $name )
                     ->where(  'id', '!=', $pagePartId );
        // create query
        
        // parent id ! null / else
        if( $parentId != null ){
            
            // add parent id
            $query->where( 'parent_id', $parentId );
            
        }
        else {
            
            // add parent id
            $query->whereNull( 'parent_id' );
            
        }
        // parent id ! null / else
        
        // return execute
        return $query->first(); 
        
    }
    static public function getNextSequence( $database, $routeId, $parentId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )
                     ->where( 'site_routes_id', $routeId )
                     ->orderBy( 'sequence', 'DESC' );
        // create query
        
        // parent id ! null / else
        if( $parentId != null ){
            
            // add parent id
            $query->where( 'parent_id', $parentId );
            
        }
        else {
            
            // add parent id
            $query->whereNull( 'parent_id' );
            
        }
        // parent id ! null / else
        
        // return execute
        $row = $query->first();
        
        // row exists
        if( $row ){
            
            // return sequence
            return $row->sequence + 1;
            
        }
        // row exists
        
        // return 0
        return 0;
        
    }
    static public function insertPagePart(  $database, $data, $sequence, $updatedAt ) {

        // insert site options row
        $id = DB::connection( $database )
                  ->table( 'site_options' )
                  ->insertGetId([
                    'name'           => $data['name'],
                    'public'         => isset( $data['isPublic'] ) && $data['isPublic'] ? 
                                        true : false,
                    'is_template'    => isset( $data['isTemplate'] )  && $data['isTemplate'] ? 
                                        $data['isTemplate'] : false,
                    'site_routes_id' => $data['routeId'],
                    'parent_id'      => $data['parentId'] ? $data['parentId'] : null,
                    'part_id'        => $data['partId'],
                    'sequence'       => $sequence,
                    'value'          => isset( $data['options'] ) && $data['options'] != null ? json_encode( $data['options'] ) : '{}',
                    'updated_at'     => $updatedAt,
                    'created_at'     => $updatedAt
                  ]);    
        // insert site options row
    
        // return id
        return $id;
        
    }
    static public function updatePagePart( $database, $id, $data, $updatedAt  ) {

        // create update array
        $updateArray = array(
            'site_routes_id'    => $data['routeId'],
            'updated_at'        => $updatedAt
        );
        
        // name exists
        isset( $data['name'] ) ? $updateArray['name'] = $data['name'] : null; 
        
        // parent id exists
        isset( $data['parentId'] ) ? $updateArray['parent_id'] = $data['parentId'] ? 
            $data['parentId'] : null  : null; 
        
        // part id exists
        isset( $data['partId'] ) ? $updateArray['part_id'] = $data['partId'] : null; 
        
        // public exists
        isset( $data['isPublic'] ) ? $updateArray['public'] = isset( $data['isPublic'] ) && 
            $data['isPublic'] == 'true' ? true : false : null; 
        
        // sequence exists
        isset( $data['sequence'] ) ? $updateArray['sequence'] = $data['sequence'] : null; 
        
        // is template exists
        isset( $data['isTemplate'] ) ? $updateArray['is_template'] = isset( $data['isTemplate'] ) && 
            $data['isTemplate'] ? true : false : null;
        
        // options exists
        if( isset( $data['options'] ) ){

            // options is null
            if( $data['options'] == null ){
                
                // set value empty
                $updateArray['value'] = '{}';
                
            }
            else { 
                
                // set value json
                $updateArray['value'] = json_encode( $data['options'] ) ? json_encode( $data['options'] ) : '{}';
            
            }
            // options is null
            
        }
        // options exists
        
        // update site options row
        DB::connection( $database )
            ->table( 'site_options' )
            ->where( 'id', $id )    
            ->update( $updateArray );    
        // update site options row
        
    }
    static public function updatePagePartSequence( $database, $id, $sequence, $updatedAt  ) {

        // create update array
        $updateArray = array(
            'sequence'      =>  $sequence,
            'updated_at'    =>  $updatedAt
        );
        
        // update site options row
        DB::connection( $database )
            ->table( 'site_options' )
            ->where( 'id', $id )    
            ->update( $updateArray );    
        // update site options row
        
    }        
}
