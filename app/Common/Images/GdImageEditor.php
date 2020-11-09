<?php

/*
        @package    Pleisterman/Common
  
        file:       ImageEditor.php
        function:   
                    
        Last revision: 06-06-2020
 
*/

namespace App\Common\Images;

use App\Http\Base\BaseClass;

class GdImageEditor extends BaseClass {
    private $image = null;
    private $quality = 100;
    public function __destruct() {
        
        if ( $this->image ) {
            
            // destroy image
            imagedestroy( $this->image );
            
        }
    }
    public function test( $mimeType ) {
        
        // extension ! found
        if ( !extension_loaded( 'gd' ) || 
             !function_exists( 'gd_info' ) ) {
            
            // no gd support
            return false;
                
        }
        // extension ! found
        
        // ! test mime type
        if( !$this->testMimeType( $mimeType ) ){
            
            // no gd support
            return false;
            
        }
        // ! test mime type
        
        // gd support
        return true;
        
    }
    private function testMimeType( $mimeType ) {

        // get supportedf image types
        $image_types = imagetypes();

        // witch type
        switch ( $mimeType ) {

            // jpeg    
            case 'image/jpeg': {

                // return jpeg supported
                return ( $image_types & IMG_JPG ) != 0;
                
            }
            // png    
            case 'image/png': {

                // return png supported
                return ( $image_types & IMG_PNG ) != 0;
                
            }
            // gif    
            case 'image/gif': {

                // return gif supported
                return ( $image_types & IMG_GIF ) != 0;
                
            }

        }
        // witch type
        
        // not supported
        return false;

    }
    public function createImageSizes( $directory, $fileName, $name ) {
        
        // ! read image
        if( !$this->readImage( $fileName ) ){
            
            // done with error
            return;
            
        }
        // ! read image
        
        // add alpha blending
        $this->addAlphaBlending( );
        
        
    }
    private function readImage( $fileName ) {
        
        // get image
        $this->image = @imagecreatefromstring( file_get_contents( $fileName ) );
                
        // image ! read
        if ( !is_resource( $this->image ) ) {
            
            // done with error
            return false;
            
        }
        // image ! read

        // get size
        $size = @getimagesize( $fileName );

        // size not found
        if ( ! $size ) {
            
            // done with error
            return false;
            
        }
        // size not found
        
        // image read
        return true;
        
    }
    private function addAlphaBlending( ) {
    
        // has alpha blending and alpha save
        if ( function_exists( 'imagealphablending' ) && function_exists( 'imagesavealpha' ) ) {
            
            // set alpha blending
            imagealphablending( $this->image, false );
            
            // set alpha save
            imagesavealpha( $this->image, true );
            
        }
        // has alpha blending and alpha save

    }
}
