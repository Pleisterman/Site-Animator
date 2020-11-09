<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteOptionsUpdate.php
        function:   
                    
        Last revision: 07-04-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteOptionsUpdate extends Model
{
    
     static public function optionsWithoutIdWithParentIdAndTypeAndNameExists( $database, $id, $parentId, $type, $name ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'type', $type )        
                     ->where( 'name', $name )
                     ->where(  'id', '!=', $id );        
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
    static public function optionsWithoutIdWithParentIdAndNameExists( $database, $id, $parentId, $name ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_options' )                
                     ->where( 'name', $name )
                     ->where( 'parent_id', $parentId )
                     ->where(  'id', '!=', $id );        
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
    static public function updateOption( $database, $id, $data, $updatedAt ) {

        // create update array
        $updateArray = array(
            'updated_at'        => $updatedAt
        );
        
        // name exists
        isset( $data['name'] ) ? $updateArray['name'] = $data['name'] : null; 
        
        // part id exists
        isset( $data['partId'] ) ? $updateArray['part_id'] = $data['partId'] : null; 
        
        // parent id exists
        isset( $data['parentId'] ) ? $updateArray['parent_id'] = $data['parentId'] ? 
            $data['parentId'] : null  : null; 
        
        // public exists
        $updateArray['public'] = isset( $data['isPublic'] ) && $data['isPublic'] == "true" ? 1 : 0;
        
        // sequence exists
        isset( $data['sequence'] ) ? $updateArray['sequence'] = $data['sequence'] : null; 
        
        // is template exists
        isset( $data['isTemplate'] ) ? isset( $data['isTemplate'] ) && $data['isTemplate'] ? 
            $data['isTemplate'] = true : $data['isTemplate'] = false : null; 
        
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
    static public function updateOptionSequence( $database, $id, $sequence, $updatedAt  ) {

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
