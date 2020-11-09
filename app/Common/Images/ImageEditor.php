<?php

/*
        @package    Pleisterman/Common
  
        file:       ImageEditor.php
        function:   
                    
        Last revision: 06-06-2020
 
*/

namespace App\Common\Images;

use App\Http\Base\BaseClass;
use App\Common\Images\GdImageEditor;
use App\Common\Images\IckImageEditor;

class ImageEditor extends BaseClass {
    protected $debugOn = true;
    private $mimeType = null;
    private $editor = null;
    public function __construct( $mimeType ) {

        // call parent
        parent::__construct();
        
        $this->debug( 'ImageEditor ' );

        // set mime type
        $this->mimeType = $mimeType;
        
        // try gd editor
        $this->createGdEditor( $this->mimeType );
        
        // no editor
        if( !$this->editor ){
            
            // try ick editor
            $this->createIckEditor();
        
        }
        // no editor
                
    }
    public function canEdit( ) {
        
        // editor exists
        if( $this->editor ){
            
            // can edit
            return true;
        
        }
        // editor exists
        
        // no editor
        return false;
        
    }
    private function createGdEditor( $mimeType ) {
        
        // create gd editor
        $gdEditor = new GdImageEditor();

        // try gd editor
        if( $gdEditor->test( $mimeType  ) ){
            
            // debug info
            $this->debug( 'ImageEditor GD found' );
            
            // editor
            $this->editor = $gdEditor;
            
        }
        // try gd editor
    }
    private function createIckEditor( $mimeType ) {
        
        // create ick editor
        $ickEditor = new IckImageEditor( $mimeType );

        // try ick editor
        if( $ickEditor->test() ){
            
            // debug info
            $this->debug( 'ImageEditor ICK found' );
            
            // editor
            $this->editor = $ickEditor;
            
        }
        // try ick editor
    }
    public function createImageSizes( $directory, $fileName, $name ) {
        
        // editor exists
        if( $this->editor ){
        
            // call editor
            $this->editor->createImageSizes( $directory, $fileName, $name );
            
        }
        // editor exists

    }
    
}
