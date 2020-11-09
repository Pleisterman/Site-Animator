<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       Media.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Media extends Model
{
    
    static public function getGroupMedia( $database, $groupId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_media' )
                     ->orderBy( 'name' );
        // create query
        
        // group id ! null / else
        if( $groupId != null ){
            
            // add group id
            $query->where( 'site_options_id', $groupId );
            
        }
        else {
            
            // add group id
            $query->whereNull( 'site_options_id' );
            
        }
        // group id ! null / else
        
        // return execute
        return $query->get(); 
        
    }
    static public function getItemCount( $database, $groupId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_media' )
                     ->orderBy( 'name' );
        // create query
        
        // group id ! null / else
        if( $groupId != null ){
            
            // add group id
            $query->where( 'site_options_id', $groupId );
            
        }
        else {
            
            // add group id
            $query->whereNull( 'site_options_id' );
            
        }
        // group id ! null / else
        
        // return count
        return $query->count(); 
        
    }
    static public function getRow( $database, $itemId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_media' )                
                     ->where( 'id', $itemId );
        // create query

        // return execute
        return $query->first();              
            
    }
    static public function deleteMedia( $database, $selection ) {
    
        // delete media row
        DB::connection( $database )
            ->table( 'site_media' )
            ->where( 'id', $selection['id'] )
            ->delete();    
        // delete media row
        
    }
    static public function mediaWithGroupIdAndNameExists( $database, $groupId, $name ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_media' )
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
    static public function mediaWithoutIdWithGroupIdAndNameExists( $database, $id, $groupId, $name ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_media' )
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
    static public function insertMedia( $database, $data, $updatedAt ) {
              
        // insert site item row
        $id = DB::connection( $database )
                  ->table(    'site_media' )
                  ->insertGetId([
                    'name'              => $data['name'],
                    'site_options_id'   => $data['groupId'] ? $data['groupId'] : null,
                    'options'           => isset( $data['options'] ) && $data['options'] != 'null' ? json_encode( $data['options'] ) : '{}',              
                    'file_name'         => isset($data['fileName'] ) ? $data['fileName'] : '',              
                    'type'              => isset($data['type'] ) ? $data['type'] : '',              
                    'uploaded_at'       => isset($data['uploadedAt'] ) ? $data['uploadedAt'] : null,              
                    'updated_at'        => $updatedAt,
                    'created_at'        => $updatedAt
                  ]);    
        // insert site item row
    
        // return id
        return $id;
        
    }
    static public function updateMedia( $database, $id, $data, $updatedAt ) {
        
        $options = '{}';
        
        // options exists
        if( isset( $data['options'] ) ){
            
            // options ! null
            if( $data['options'] != null && $data['options'] != 'null' ){
                
                // set value json
                $options = json_encode( $data['options'] ) != null ? json_encode( $data['options'] ) : '{}';
            
            }
            // options ! null
            
        }
        // options exists
        
        // create update data
        $updateData = array(
            'name'              => $data['name'],
            'site_options_id'   => $data['groupId'] ? $data['groupId'] : null,
            'options'           => $options,              
            'updated_at'        => $updatedAt
        );
        // create update data
        
        // file name exists
        if( isset($data['fileName'] ) ){
           
            // set file name
            $updateData['file_name'] = $data['fileName'];              
                
        }
        // file name exists

        // uploaded at exists
        if( isset($data['uploadedAt'] ) ){
           
            // set uploaded at
            $updateData['uploaded_at'] = $data['uploadedAt'];              
                
        }
        // uploaded at exists
        
        // type exists
        if( isset($data['type'] ) ){
            
            // set type
            $updateData['type'] = $data['type'];              
            
        }
        // type exists

        // update media row
        DB::connection( $database )
            ->table( 'site_media' )
            ->where( 'id', $id )
            ->update( $updateData );
        // update media row
        
    }
    
}
