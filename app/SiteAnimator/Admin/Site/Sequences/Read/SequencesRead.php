<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SequencesRead.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Sequences\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Sequences\Read\SequencesReadList;
use App\SiteAnimator\Admin\Site\Sequences\Read\SequencesReadSequencesById;

class SequencesRead extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function read( $database, $selection ){

        // remember database
        $this->database = $database;

        // choose what
        switch ( $selection['what'] ) {
            
            // list
            case 'list': {
                
                // create read sequences list
                $readlist = new SequencesReadList( $this->database, $selection );

                // return list call
                return $readlist->read( );
                
            }
            // byId
            case 'byId': {

                // create sequences by id
                $sequencesRow = new SequencesReadSequencesById();

                // call sequences by id
                return $sequencesRow->read( $this->database, $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'Sequences error get, what not found: ' . $selection['what'] );
                
                // done with error
                return array( 'criticalError' => 'whatNotFound' );
                
            }
                    
        }        
        // done choose what

    }
    
}
