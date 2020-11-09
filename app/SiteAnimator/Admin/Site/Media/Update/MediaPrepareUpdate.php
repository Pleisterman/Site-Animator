<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaPrepareUpdate.php
        function:   
                    
        Last revision: 11-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Media;
use App\SiteAnimator\Models\Site\SiteOptionGroups;

class MediaPrepareUpdate extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $hasError = null;
    private $error = null;
    private $mediaRow = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function prepareUpdate( $id, $data ){
        
        // get media row
        $this->mediaRow = Media::getRow( $this->database, $id );

        // reset has error
        $this->hasError = false;
        
        // validate updated at
        $this->validateUpdatedAt( $data );
        
        // ! has error
        if( !$this->hasError ){
            
            // validate name
            $this->validateName( $id, $data );

        }
        // ! has error
        
        // has error
        if( $this->hasError ){
            
            // create error
            $error = array(
                'error'         =>   $this->error
            );
            // create error
            
            // return error
            return $error;
            
        }
        // has error      
        
        // create result
        $result = array(
            'id'        =>  $this->mediaRow->id, 
            'groupId'   =>  $this->mediaRow->site_options_id,
            'name'      =>  $this->mediaRow->name,
            'fileName'  =>  $this->mediaRow->file_name
         );
        // create result

        // return result
        return $result;
        
    }
    private function validateUpdatedAt( $data ) {
        
        // row ! found
        if( !$this->mediaRow ){
            
            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'alreadyDeleted';
            
            // dobe
            return;
            
        }
        // row ! found
        
        // get date
        $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->mediaRow->updated_at ); 

        // get data date
        $dataDate = \DateTime::createFromFormat( 'Y-m-d H:i:s', $data['updatedAt'] ); 

        // updated at ! updated at
        if( $date != $dataDate ){

            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'dataOutOfDate';

            // done
            return;

        }
        // updated at ! updated at
        
    }
    private function validateName( $id, $data ) {

        // get media name and group with other id exists
        $nameExists = Media::mediaWithoutIdWithGroupIdAndNameExists( $this->database, 
                                                                     $id, 
                                                                     $data['groupId'], 
                                                                     $data['name'] );
        // get media name and group with other id exists

        // group name with parent exists
        $groupNameExists = SiteOptionGroups::groupWithParentIdAndNameExists( $this->database, 
                                                                             'mediaGroup', 
                                                                             $data['groupId'], 
                                                                             $data['name'] );
        // group name with parent exists

        // name exists    
        if( $nameExists || $groupNameExists ){
            
            // set has error
            $this->hasError = true;

            // set error
            $this->error = 'nameExists';
                
            // set error object
            $this->errorObject = 'name';
            
        }
        // name exists    

    }
    
}
