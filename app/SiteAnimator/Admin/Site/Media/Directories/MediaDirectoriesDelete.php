<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaDirectoriesDelete.php
        function:   
                    
        Last revision: 13-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Directories;

use App\Http\Base\BaseClass;

class MediaDirectoriesDelete extends BaseClass {

    protected $debugOn = true;
    public function deleteDirectory( $path ){

        // debug info
        $this->debug( 'MediaDirectoriesDelete deleteDirectory path: ' . $path );

        // remove dir
        rmdir( $path );
        
    }        
    public function deleteDirectoryItems( $path ) {
        
        // debug info
        $this->debug( 'MediaDirectoriesDelete deleteDirectoryItems path: ' . $path );
        
        // get files
        $files = array_diff( scandir( $path ), array( '.', '..' ) );
        
        // loop over files
        foreach( $files as $file ) {
            
            // is directory / else
            if( is_dir( $path . '/' . $file ) ){
                
                // call recursive
                $this->deleteDirectoryItems( $path . '/' . $file );
                        
            }
            else {
                
                // remove file
                unlink( $path . '/' . $file );
                
            }
            // is directory / else

        }
        // loop over files
        
    }
    
}
