<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaUploadFile.php
        function:   
                    
        Last revision: 01-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Files;

use App\Http\Base\BaseClass;
use App\Common\Images\ImageEditor;

class MediaUploadFile extends BaseClass {

    protected $debugOn = true;
    private $uploadErrors = array(
        UPLOAD_ERR_INI_SIZE     => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE    => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL      => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE      => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR   => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE   => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION    => 'A PHP extension stopped the file upload.'
    );
    public function __construct( ){
        
        // call parent
        parent::__construct();
        
    }
    public function upload( $index, $directory ){

        // create file name
        $fileName = $directory . '/' . $_FILES['files']['name'][$index];
        
        // move file
        $moved = move_uploaded_file( $_FILES['files']['tmp_name'][$index], $fileName );

        // ! moved
        if( !$moved ) {
            
            // debug info
            $this->debug( 'upload error: ' . $this->uploadErrors[$_FILES['files']["error"][$index]] );
            
            // return error
            return array( 'error' => $this->uploadErrors[$_FILES['files']["error"][$index]] );
            
        }
        // ! moved
       
/*        
        // get mime type
        $mimeType = mime_content_type( $fileName ); 

        
        // create image editor
        $imageEditor = new ImageEditor( $mimeType );
        
        // can edit
        if( $imageEditor->canEdit( ) ){

            // create image sizes
            $imageEditor->createImageSizes( $directory, $fileName, $name );
            
        }
        // can edit
*/
        
    }
    
}
