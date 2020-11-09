<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteItemsFiles.php
        function:   
                    
        Last revision: 30-07-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteItemsFiles extends Model {
    
    static public function getItemFiles( $database, $itemId ){
    
        // create query
        $query = DB::connection(  $database )
                     ->table(     'site_items_files' )
                     ->select(    'site_items_files.source' )
                     ->where(     'site_item_id', $itemId );
        // create query

        // return first
        return $query->get();                      
        
    }
    static public function getUsedFiles( $database ){
    
        // create query
        $query = DB::connection(  $database )
                     ->table(     'site_items_files' )
                     ->select(    'site_items_files.source' )
                     ->distinct(  'site_items_files.source' )
                     ->join(      'site_items', 
                                  'site_items_files.site_item_id', 
                                  '=', 
                                  'site_items.id' )
                     ->join(      'site_options', 
                                  'site_items.site_options_id', 
                                  '=', 
                                  'site_options.part_id' )
                     ->whereNull( 'site_options.type' );
        // create query

        // return first
        return $query->get();              
        
        
    }
    static public function getUsedTemplatesFiles( $database ){

        // get parts
        $parts = $query = DB::connection(  $database )
                              ->table(     'site_options' )
                              ->select(    'site_options.part_id' )
                              ->distinct(  'site_options.part_id' )
                              ->where(     'site_options.is_template', 1 )
                              ->get();
        // get parts
        
        // create id list
        $partsList = array();
        
        // loop over parts
        foreach( $parts as $index => $part ){
           
            array_push( $partsList, $part->part_id );
            
        }
        // loop over parts

        // get template parts
        $templateParts = DB::connection(  $database )
                             ->table(     'site_items_files' )
                             ->select(    'site_items_files.source' )
                             ->distinct(  'site_items_files.source' )
                             ->join(      'site_items', 
                                          'site_items_files.site_item_id', 
                                          '=', 
                                          'site_items.id' )
                             ->join(      'site_options', 
                                          'site_options.part_id', 
                                          '=', 
                                          'site_items.site_options_id' )
                             ->whereIn(   'site_options.id', $partsList )
                             ->get();
        // get template parts
                
        // return template parts
        return $templateParts;              
        
        
    }
    
}
