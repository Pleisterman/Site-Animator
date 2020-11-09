<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteOptions.php
        function:   
                    
        Last revision: 14-10-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteOptionGroups extends Model
{
    
    static public function getNextSequence( $database, $parentId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )
                     ->whereNull( 'site_routes_id' )
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
    static public function groupWithParentIdAndNameExists( $database, $type, $parentId, $name ) {

        // create query
        $query = DB::connection( $database )
                 ->table(  'site_options' )
                 ->where(  'type', $type )
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
        
        // get count
        $count = $query->count();
        
        if( $count > 0 ){
            
            // return exists
            return true;
            
        }
          
        // return ! exists
        return false;
        
    }
    static public function groupsWithoutIdWithParentIdAndNameExists( $database, $groupId, $type, $parentId, $name ) {

        // create query
        $query = DB::connection( $database )
                 ->table(  'site_options' )
                 ->where(  'type', $type )
                 ->where(  'id', '!=', $groupId )
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
        
        // get count
        $count = $query->count();
        
        if( $count > 0 ){
            
            // return exists
            return true;
            
        }
          
        // return ! exists
        return false;
        
    }
    static public function insertGroup( $database, $data, $updatedAt ) {
        
        // insert site options row
        $id = DB::connection( $database )
                  ->table( 'site_options' )
                  ->insertGetId([
                    'name'          => $data['name'],
                    'type'          => $data['type'],
                    'site_routes_id' => isset( $data['routeId'] ) &&
                                       $data['routeId'] ? $data['routeId'] : null,
                    'parent_id'     => isset( $data['parentId'] ) &&
                                       $data['parentId'] ? $data['parentId'] : null,
                    'part_id'       => isset( $data['partId'] ) &&
                                       $data['partId'] ? $data['partId'] : null,
                    'sequence'      => isset( $data['sequence'] ) &&
                                       $data['sequence'] ? $data['sequence'] : null,
                    'value'         => isset( $data['options'] ) && $data['options'] != null ? json_encode( $data['options'] ) : '{}',
                    'updated_at'    => $updatedAt,
                    'created_at'    => $updatedAt
                  ]);    
        // insert site options row
    
        // return id
        return $id;
        
    }
    static public function updateGroup( $database, $selection, $data, $updatedAt ) {
        
        // create update array
        $updateArray = array(
            'name'          =>  $data['name'],
            'type'          =>  $data['type'],
            'updated_at'    =>  $updatedAt
        );
        // create update array

        // site pages id is set
        if( isset( $data['routeId'] ) ){
            
            // add site pages id
            $updateArray['site_routes_id'] = $data['routeId'] ? $data['routeId'] : null;
            
        }
        // site pages id is set
        
        // part id is set
        if( isset( $data['partId'] ) ){
            
            // add part id
            $updateArray['part_id'] = $data['partId'] ? $data['partId'] : null;
            
        }
        // part id is set
        
        // sequence is set
        if( isset( $data['sequence'] ) ){
            
            // add sequence
            $updateArray['sequence'] = $data['sequence'] ? $data['sequence'] : null;
            
        }
        // sequence is set
        
        // parent id is set
        if( isset( $data['parentId'] ) ){
            
            // add parent id
            $updateArray['parent_id'] = $data['parentId'] ? $data['parentId'] : null;
            
        }
        // parent id is set
        
        // add public
        $updateArray['public'] = isset( $data['isPublic'] ) && $data['isPublic'] == "true" ? 1 : 0;

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
            ->where( 'id', $selection['id'] )
            ->update( $updateArray );    
        // update site options row
    
    }
    
}
