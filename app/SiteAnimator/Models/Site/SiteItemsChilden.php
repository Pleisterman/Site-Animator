<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteItemsChilden.php
        function:   
                    
        Last revision: 18-05-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteItemsChilden extends Model {
    
    static public function getItemChildren( $database, $siteItemId ){
    
        // create query
        $query = DB::connection( $database )
                     ->table(   'site_items_children' )
                     ->select(  'site_items_children.child_id',
                                'site_items.group_id')
                     ->join(    'site_items', 
                                'site_items.id', 
                                '=', 
                                'site_items_children.site_item_id' )
                     ->where(   'site_item_id', $siteItemId );
        // create query

        // return first
        return $query->get();              
        
        
    }
    static public function itemHasChildren( $database, $siteItemId ){
    
        // create query
        $query = DB::connection( $database )
                     ->table(   'site_items_children' )
                     ->join(    'site_items', 
                                'site_items.id', 
                                '=', 
                                'site_items_children.site_item_id' )
                     ->where(   'site_item_id', $siteItemId );
        // create query

        // return first
        $count = $query->count();              
        
        // has items
        if( $count > 0 ){

            // return has items
            return true;
            
        }
        // has items
        
        // return ! has items
        return false;
        
    }
    static public function itemHasChildrenWithChild( $database, $siteItemId, $childId ){
    
        // create query
        $query = DB::connection( $database )
                     ->table(   'site_items_children' )
                     ->join(    'site_items', 
                                'site_items.id', 
                                '=', 
                                'site_items_children.site_item_id' )
                     ->where(   'site_item_id', $siteItemId )
                     ->where(   'site_items_children.child_id', $childId );
        // create query

        // return first
        $count = $query->count();              
        
        // has items
        if( $count > 0 ){

            // return has items
            return true;
            
        }
        // has items
        
        // return ! has items
        return false;
        
    }
    static public function partHasChildren( $database, $partId ){
    
        // create query
        $query = DB::connection( $database )
                     ->table(   'site_items_children' )
                     ->join(    'site_items', 
                                'site_items.id', 
                                '=', 
                                'site_items_children.site_item_id' )
                     ->where(   'site_options.site_options_id', $partId );
        // create query

        // return first
        $count = $query->count();              
        
        // has items
        if( $count > 0 ){

            // return has items
            return true;
            
        }
        // has items
        
        // return ! has items
        return false;
        
    }
    static public function itemHasTemplates( $database, $siteItemId ){
/* 
SELECT * FROM site_options
INNER JOIN site_items  ON site_items.site_options_id = site_options.part_id
INNER JOIN site_items_children  ON site_items.id = site_items_children.child_id
where site_items_children.site_item_id = 1 and site_options.type = 'template'        
*/        
        // create query
        $query = DB::connection( $database )
                     ->table(   'site_options' )
                     ->join(    'site_items', 
                                'site_items.site_options_id', 
                                '=', 
                                'site_options.part_id' )
                     ->join(    'site_items_children', 
                                'site_items.id', 
                                '=', 
                                'site_items_children.child_id' )
                     ->where(   'site_items_children.site_item_id', $siteItemId )
                     ->where(   'site_options.type', 'template' );
        // create query

        // return first
        $count = $query->count();              
        
        // has items
        if( $count > 0 ){

            // return has items
            return true;
            
        }
        // has items
        
        // return ! has items
        return false;
        
    }
    static public function itemHasTemplatesWithChild( $database, $siteItemId, $childId ){
    
        // create query
        $query = DB::connection( $database )
                     ->table(   'site_options' )
                     ->join(    'site_items', 
                                'site_items.site_options_id', 
                                '=', 
                                'site_options.part_id' )
                     ->join(    'site_items_children', 
                                'site_items.id', 
                                '=', 
                                'site_items_children.child_id' )
                     ->where(   'site_items_children.site_item_id', $siteItemId )
                     ->where(   'site_options.type', 'template' )
                     ->where(   'site_items_children.child_id', $childId );
        // create query

        // return first
        $count = $query->count();              
        
        // has items
        if( $count > 0 ){

            // return has items
            return true;
            
        }
        // has items
        
        // return ! has items
        return false;
        
    }
    static public function itemHasItemAsChild( $database, $siteItemId, $childSiteItemId ){
    
        // create query
        $query = DB::connection( $database )
                     ->table(   'site_items_children' )
                     ->join(    'site_items', 
                                'site_items.id', 
                                '=', 
                                'site_items_children.site_item_id' )
                     ->where(   'site_items.id', $siteItemId )
                     ->where(   'site_items_children.child_id', $childSiteItemId );
        // create query

        // return first
        $count = $query->count();              
        
        // has items
        if( $count > 0 ){

            // return has items
            return true;
            
        }
        // has items
        
        // return ! has items
        return false;
        
    }    
    
}
