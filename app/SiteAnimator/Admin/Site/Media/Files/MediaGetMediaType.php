<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaGetMediaType.php
        function:   
                    
        Last revision: 01-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Files;

use App\Http\Base\BaseClass;
use App\Common\Models\Site\Settings;

class MediaGetMediaType extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $imageExtensions = null;
    private $soundExtensions = null;
    private $videoExtensions = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
        // get image settings
        $imageSetting = Settings::getSetting( $this->database, 'media' ,'imageExtensions' );
        
        // get image extensions
        $this->imageExtensions = json_decode( $imageSetting->value );
        
        // get sound extensions
        $soundSetting = Settings::getSetting( $this->database, 'media' ,'soundExtensions' );
        
        // get sound extensions
        $this->soundExtensions = json_decode( $soundSetting->value );
        
        // get video extensions
        $videoSetting = Settings::getSetting( $this->database, 'media' ,'videoExtensions' );
        
        // get video extensions
        $this->videoExtensions = json_decode( $videoSetting->value );
        
    }
    public function getType( $index ){

        // file ! exists
        if( !isset( $_FILES['files']['name'] ) && 
            !isset( $_FILES['files']['name'][$index] ) ){
            
            // done with error
            return array( 'error' => 'noFile' );
            
        }    
        // file ! exists

        // split name
        $nameArray = explode( '.', $_FILES['files']['name'][$index] );
        
        // get extension
        $extension = strtolower( $nameArray[count( $nameArray ) - 1] );        

        // debug info
        $this->debug( 'file extension: ' . $extension );
            
        // create type
        $type = null;

        // is image extension
        if( in_array( $extension, $this->imageExtensions ) ){

            // set type
            $type = 'image';
            
            // debug info
            $this->debug( 'file mime type: ' . mime_content_type( $_FILES['files']['tmp_name'][$index] ) );
            
        }
        // is image extension

        // is sound extension
        if( in_array( $extension, $this->soundExtensions ) ){

            // set type
            $type = 'sound';

        }
        // is sound extension

        // is video extension
        if( in_array( $extension, $this->videoExtensions ) ){

            // set type
            $type = 'video';

        }
        // is video extension

        // type found / else
        if( $type ){

            // return type
            return $type;

        }
        else {

            // return error
            return array( 'error' => 'UploadUnsuportedExtension' );

        }
        // type found / else

    }    
    
}
