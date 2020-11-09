<?php

/*
        @package    Pleisterman/Common
  
        file:       Translations.php
        function:   
                    
        Last revision: 01-01-2020
 
*/

namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Translations extends Model
{
    
    static public function getTranslationsByTypeAndLanguage( $database, $isAdmin, $languageId, $type, $translationIds = null ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // create query
        $query = DB::connection( $database )
                     ->table(  $adminOrSite . 'translation_ids' )
                     ->join(   $adminOrSite . 'translations', 
                               $adminOrSite . 'translation_ids.id', 
                               '=', 
                               $adminOrSite . 'translations.translation_id' )
                     ->select( $adminOrSite . 'translation_ids.name', 
                               $adminOrSite . 'translations.translation' )
                     ->where(  $adminOrSite . 'translation_ids.type', $type )
                     ->where(  $adminOrSite . 'translations.language_id', $languageId );
        // create query
        
        // translation ids exists
        if( $translationIds != null ){
            
            // add translation ids 
            $query->whereIn( $adminOrSite . 'translation_ids.name', $translationIds );
            
        }
        // translation ids exists
        
        // get 
        $translations = $query->get();

        // create result
        $result = array();

        // loop over translations
        forEach( $translations as $translation ) {
        
            // add to translation to result
            $result[$translation->name] = $translation->translation;

        }
        // loop over translations        
     
        // return result
        return $result;
        
    }
    static public function getTranslationsByType( $database, $isAdmin, $type ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get translation
        $translations = DB::connection( $database )
                            ->table(  $adminOrSite . 'translation_ids' )
                            ->join(   $adminOrSite . 'translations', 
                                      $adminOrSite . 'translation_ids.id', 
                                      '=', 
                                      $adminOrSite . 'translations.translation_id' )
                            ->select( $adminOrSite . 'translation_ids.id', 
                                      $adminOrSite . 'translation_ids.name', 
                                      $adminOrSite . 'translations.language_id', 
                                      $adminOrSite . 'translations.translation' )
                            ->where(  $adminOrSite . 'translation_ids.type', $type )
                            ->get();
        // get translation

        // create result
        $result = array();

        // loop over translations
        forEach( $translations as $translation ) {
        
            // translation index ! exists
            if( !isset( $result[$translation->name] ) ){
                
                // create index
                $result[$translation->name] = array();
                
            }
            // translation index !  exists
            
            // add to translation to array
            $result[$translation->name][$translation->language_id] = $translation->translation;

        }
        // loop over translations        
          
        // return result
        return $result;
        
    }
    static public function translationsWithGroupIdAndNameExists( $database, $isAdmin, $groupId, $name ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // create query
        $query = DB::connection( $database )
                 ->table(  $adminOrSite . 'translation_ids' )
                 ->join(   $adminOrSite . 'translations', 
                           $adminOrSite . 'translation_ids.id', 
                           '=', 
                           $adminOrSite . 'translations.translation_id' )
                 ->where(  $adminOrSite . 'translation_ids.name', $name );
        // create query

        // group id ! null / else
        if( $groupId != null ){
            
            // add site options id
            $query->where( $adminOrSite . 'translation_ids.site_options_id', $groupId );
            
        }
        else {
            
            // add site options id
            $query->whereNull( $adminOrSite . 'translation_ids.site_options_id' );
            
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
    static public function translationsWithoutIdWithGroupIdAndNameExists( $database, $isAdmin, $id, $groupId, $name ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // create query
        $query = DB::connection( $database )
                 ->table(  $adminOrSite . 'translation_ids' )
                 ->join(   $adminOrSite . 'translations', 
                           $adminOrSite . 'translation_ids.id', 
                           '=', 
                           $adminOrSite . 'translations.translation_id' )
                 ->where(  $adminOrSite . 'translation_ids.name', $name )
                 ->where(  $adminOrSite . 'translation_ids.id', '!=', $id );
        // create query

        // group id ! null / else
        if( $groupId != null ){
            
            // add site options id
            $query->where( $adminOrSite . 'translation_ids.site_options_id', $groupId );
            
        }
        else {
            
            // add site options id
            $query->whereNull( $adminOrSite . 'translation_ids.site_options_id' );
            
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
    static public function getTranslationIdRow( $database, $isAdmin, $id ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get translations id row
        return DB::connection( $database )
                   ->table(    $adminOrSite . 'translation_ids' )
                   ->select(   'id', 
                               'name', 
                               'site_options_id as groupId', 
                               'updated_at as updatedAt' )
                   ->where(    'id',
                               '=',
                               $id )
                   ->first();    
        // get translations id row
        
    }
    static public function getTranslationRows(  $database, $isAdmin, $translationIdsId ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get translations by id
        return DB::connection( $database )
               ->table(    $adminOrSite . 'translation_ids' )
               ->join(     $adminOrSite . 'translations', 
                           $adminOrSite . 'translation_ids.id', 
                           '=', 
                           $adminOrSite . 'translations.translation_id' )
               ->select(   $adminOrSite . 'translations.id', 
                           $adminOrSite . 'translations.language_id as languageId', 
                           'translation' )
               ->where(    $adminOrSite . 'translation_ids.id',
                           '=',
                           $translationIdsId )
               ->get(); 
        // get translations by id
        
    }
    static public function getTranslation( $database, $isAdmin, $translationIdsId, $languageId ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get translations by id
        return DB::connection( $database )
               ->table(    $adminOrSite . 'translations' )
               ->select(   'translation' )
               ->where(    'translation_id',
                           '=',
                           $translationIdsId )
                ->where(   'language_id', $languageId )
               ->first(); 
        // get translations by id
        
    }
    static public function insertTranslationId(  $database, $isAdmin, $data, $updatedAt ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // insert translation id row
        $id = DB::connection( $database )
                  ->table(    $adminOrSite . 'translation_ids' )
                  ->insertGetId([
                    'name'              => $data['name'],
                    'type'              => $data['type'],
                    'site_options_id'   => $data['groupId'] ? $data['groupId'] : null,
                    'updated_at'        => $updatedAt,
                    'created_at'        => $updatedAt
                  ]);    
        // insert translation id row
    
        // return id
        return $id;
        
    }
    static public function insertTranslation( $database, $isAdmin, $data, $translationId ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // insert translation row
        $id = DB::connection( $database )
                  ->table(    $adminOrSite . 'translations' )
                  ->insertGetId([
                    'language_id'       => $data['languageId'],
                    'translation_id'    => $translationId,
                    'translation'       => $data['translation']
                  ]);    
        // insert translation row
    
        // return id
        return $id;
        
    }
    static public function updateTranslationId(  $database, $isAdmin, $selection, $data, $updatedAt ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // update translation id row
        DB::connection( $database )
            ->table(    $adminOrSite . 'translation_ids' )
            ->where( 'id', $selection['id'] )
            ->update([
                'name'              => $data['name'],
                'type'              => $data['type'],
                'site_options_id'   => $data['groupId'] ? $data['groupId'] : null,
                'updated_at'        => $updatedAt
            ]);
        // update translation id row
        
    }
    static public function updateTranslation( $database, $isAdmin, $data ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // update translation row
        DB::connection( $database )
            ->table(    $adminOrSite . 'translations' )
            ->where( 'id', $data['id'] )    
            ->update([
                'translation'       => $data['translation']
            ]);
        // update translation row
    
    }
    
}
