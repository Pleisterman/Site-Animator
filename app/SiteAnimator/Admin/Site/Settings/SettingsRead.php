<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SettingsRead.php
        function:   
                    
        Last revision: 13-02-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Settings;

use App\Common\Base\BaseClass;
use Illuminate\Support\Facades\DB;

class SettingsRead extends BaseClass {

    protected $debugOn = true;
    public function read( $database, $selection ){

        // remmeber database
        $this->database = $database;
        
        // create result
        $result = array();
        
        // create query
        $query = DB::connection( $this->database )
                     ->table(    'site_settings' )
                     ->select(   'id', 
                                 'name', 
                                 'value',
                                 'updated_at as updatedAt',
                                 'edit_options as editOptions' )
                     ->orderBy(  'sequence', 'ASC' ); 
        // create query
        
        // type is set and type ! all
        if( isset( $selection['type'] ) && $selection['type'] != 'all' ){
        
            // add type to query
            $query->where( 'type', $selection['type'] );
        }
        // type is set and type ! all
        
        // get site settings
        $siteSettings = $query->get();
        
        // loop over site settings
        forEach( $siteSettings as $index => $siteSetting ) {

            // create setting
            $setting = array(
                'id'            =>  $siteSetting->id,
                'name'          =>  $siteSetting->name,
                'updatedAt'     =>  $siteSetting->updatedAt
            );
            // create setting
            
            // get edit settings
            $setting['editOptions'] = json_decode( $siteSetting->editOptions, true );
        
            // parse value
            $setting['value'] = $this->parseValue( $setting['editOptions']['type'],
                                                   $siteSetting->value );
            // parse value
            
            // add setting to result
            array_push( $result, $setting );
            
        }
        // loop over site settings
        
        // return result
        return $result;
        
    }
    private function parseValue( $type, $value ){
        
        // type is boolean
        if( $type == 'boolean' ){

            // get boolean value
            $value = $value == 'true' ? true : false;

        }
        // type is boolean
        
        // type is json
        if( $type == 'json' ){

            // get json value
            $value = json_decode( $value, true );

        }
        // type is json
        
        // type is array
        if( $type == 'array' ){

            // get array value
            $value = json_decode( $value, true );

        }
        // type is array
        
        // return result
        return $value;
    }
    
}
