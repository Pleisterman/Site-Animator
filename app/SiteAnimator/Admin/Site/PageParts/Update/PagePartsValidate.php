<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       PagePartsValidate.php
        function:   
                    
        Last revision: 26-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\PageParts\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\PageParts;
use App\SiteAnimator\Models\Site\SiteOptions;

class PagePartsValidate extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function validateUpdatedAt( $selection, $data ) {
        
        // get page parts row
        $pagePartsRow = SiteOptions::getOption( $this->database, $selection['id'] );

        // row ! found
        if( !$pagePartsRow ){
            
            // handle error
            return $this->handleError( 'alreadyDeleted' );
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $pagePartsRow->updated_at ); 

        // get data date
        $dataDate = \DateTime::createFromFormat( 'Y-m-d H:i:s', $data['updatedAt'] ); 

        // updated at ! updated at
        if( $date != $dataDate ){

            // handle error
            return $this->handleError( 'dataOutOfDate' );
            
        }
        // updated at ! updated at
        
    }
    public function validateName( $selection, $data ) {

        // get name and page part with other id exists for same parent
        $nameExists = PageParts::nameExistsExcept( $this->database, 
                                                   $data['routeId'], 
                                                   $selection['id'], 
                                                   $data['name'], 
                                                   $data['parentId'] );
        // get name and page part with other id exists for same parent

        // name exists    
        if( $nameExists ){
            
            // handle error
            return $this->handleError( 'nameExists' );
            
        }
        // name exists    

    }
    private function handleError( $error ){
        
        // create and return error
        return array(
            'error'         =>   $error
        );
        // create error

    }
    
}
