<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesRead.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesReadList;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesReadTemplatesById;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplateParts\TemplatePartReadParentList;
use App\SiteAnimator\Admin\Site\Templates\Read\ChildParts\TemplatePartReadChildParts;

class TemplatesRead extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read template list
                $readlist = new TemplatesReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // parent list
            case 'parentList': {
                
                // create read parent list
                $readlist = new TemplatePartReadParentList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // child parts
            case 'childParts': {
                
                // create read parent child parts
                $readChildParts = new TemplatePartReadChildParts( $this->database, $selection );

                // return parent child parts call
                return $readChildParts->read( );
                
            }
            // part parents
            case 'partParents': {
                
                // create read template page parents
                $readPageParents = new TemplatesReadPartParents( $this->database, $selection );

                // return page parents call
                return $readPageParents->read( );
                
            }
            // byId
            case 'byId': {

                // create template by id
                $templatesRow = new TemplatesReadTemplatesById();

                // call template by id
                return $templatesRow->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Templates error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
