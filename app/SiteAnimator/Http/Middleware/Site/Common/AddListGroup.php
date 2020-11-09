<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddSiteOptions.php
        function:   
                    
        Last revision: 03-05-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site\Common;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Translations\SiteObject\SiteObjectRead as ReadTranslation;
use App\SiteAnimator\Admin\Site\Sequences\SiteObject\SiteObjectRead as ReadSequence;
use App\SiteAnimator\Admin\Site\Css\SiteObject\SiteObjectRead as ReadCss;
use App\SiteAnimator\Admin\Site\Colors\SiteObject\SiteObjectRead as ReadColor;
use App\SiteAnimator\Admin\Site\Media\SiteObject\SiteObjectRead as ReadMedia;

class AddListGroup extends BaseClass {
    
    protected $debugOn = true;
    private $database = null;
    private $order = array(
        'column'        =>      'sequence',
        'direction'     =>      'ASC'
    );
    public function __construct( $database ){
    
        // remember database
        $this->database = $database;

        // call parent
        parent::__construct();
            
    }
    public function add( $options ){

        // get group 
        $group = SiteOptions::getOption( $this->database, $options['id'] );
        
        // enhance options
        $group->options = $this->enhanceOptions( json_decode( $group->value, true ) );   
        
        // get order
        $this->getOrder( $group->options );
        
        // create result
        $result = $this->getItems( $options['id'] );

        // return options
        return $result;
        
    }
    private function getOrder( $options ){
        
        // get order
        $order = isset( $options['order'] ) ? $options['order'] : array();
        
        // 
        $this->debug( 'order: ' . json_encode($options));
        
        // set order column
        $this->order['column'] = isset( $order['column'] ) ? $order['column'] : $this->order['column'];
        
        // set order direction
        $this->order['direction'] = isset( $order['direction'] ) ? $order['direction'] : $this->order['direction'];
        
    }
    private function getItems( $groupId ){
        
        // create empty result
        $result = array();
        
        // get list items
        $rows = SiteOptions::getOptionOptions( $this->database, 
                                               $groupId,
                                               null,
                                               $this->order );
        // get list items
                
        // loop over rows
        forEach( $rows as $row ) {

            // add item
            array_push( $result, $this->createItem( $row ) );
            
        }
        // loop over rows
        
        // return options
        return $result;
        
    }
    private function createItem( $row ){
        
        // create item array
        $item = array(
            'id'                =>   $row->id,
            'name'              =>   $row->name,
            'groupId'           =>   $row->parent_id,
            'items'             =>   $this->getItems( $row->id ),
            'options'           =>   $this->enhanceOptions( json_decode( $row->value, true ) ),
            'updatedAt'         =>   $row->updated_at
        );
        // create item array

        // return result
        return $item;
            
    }
    private function enhanceOptions( $options ){
                
        // loop over options
        foreach( $options as $key => $value ) {
 
            // site object exists
            if( isset( $value['siteObject'] ) ) {
                
                // get site object
                $options[$key] = $this->getSiteObject( $value );
                
            }
            // site object exists
            
            
            // is array
            if ( is_array( $value ) ) {
                
                // call recursive
                $options[$key] = $this->enhanceOptions( $options[$key] );
                
            }
            // is array
            
        }
        // loop over options        
        
        // return result       
        return $options;
        
    }
    private function getSiteObject( $options ){
        
        // is translation
        if( isset( $options['translation'] ) ){
        
            // create read
            $readTranslation = new ReadTranslation( $this->database );
            
            // read translation
            $options = $readTranslation->read( $options );
            
        }
        // is translation

        // is color
        if( isset( $options['color'] ) ){
        
            // create read
            $readColor = new ReadColor( $this->database );
            
            // read color
            $options = $readColor->read( $options );
            
        }
        // is color
        
        // is css
        if( isset( $options['css'] ) ){
        
            // create read
            $readCss = new ReadCss( $this->database );
            
            // read css
            $options = $readCss->read( $options );
            
        }
        // is css
        
        // is media
        if( isset( $options['media'] ) ){
        
            // create read
            $readMedia = new ReadMedia( $this->database );
            
            // read media
            $options = $readMedia->read( $options );
            
        }
        // is media
        
        // is sequence
        if( isset( $options['sequence'] ) ){
        
            // create read
            $readSequence = new ReadSequence( $this->database );
            
            // read sequence
            $options = $readSequence->read( $options );
            
        }
        // is sequence
        
        
        // return result
        return $options;
        
    }
    
}