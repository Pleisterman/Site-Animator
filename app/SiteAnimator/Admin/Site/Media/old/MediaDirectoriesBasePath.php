<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaDirectoriesBasePath.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Directories;

use App\Http\Base\BaseClass;

class MediaDirectoriesBasePath extends BaseClass {

    static public function getPath( $appCode ){

        // return path
        return public_path() . '\\' . env( $appCode . '_BASE_DIR' ) . '\\' . 'site\media' . '\\';
        
    }
    static public function getUrl( $appCode ){

        // create url
        $url = url( '/' );
        
        $url .= '/' . 'public' . '/';
        
        // base dir ! empty
        if( env( $appCode . '_BASE_DIR' ) != '' ){
            
            // add base dir
            $url .= env( $appCode . '_BASE_DIR' ) . '/';
            
        }
        // base dir ! empty
        
        // add media path
        $url .= 'site/media' . '/';
        
        // return url
        return  $url;
        
    }
    
}
