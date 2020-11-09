<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsDelete.php
        function:   
                    
        Last revision: 18-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Translations\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;
use App\SiteAnimator\Models\Site\Translations;
use App\SiteAnimator\Admin\Site\Translations\Delete\TranslationsDelete;

class GroupsDelete extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $translationDelete = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
        // create translation delete
        $this->translationDelete = new TranslationsDelete( $this->database, $this->appCode );
        
    }
    public function delete( $selection ){
        
        // find groups
        $this->findGroupGroups( $selection['id'] );
        
        // delete group
        $this->deleteGroup( $selection['id'] );

        // return ok
        return array( 'ok' );
        
    }
    private function findGroupGroups( $groupId ){
        
        // get groups
        $groups = SiteOptions::getOptionOptions( $this->database, $groupId );
        
        // loop over groups
        foreach( $groups as $index => $group ){
            
            // delete group recursive
            $this->findGroupGroups( $group->id );

            // delete group
            $this->deleteGroup( $group->id );
        
        }
        // loop over groups
        
    }
    private function deleteGroup( $groupId ) {
        
        // debug info
        $this->debug( 'group: ' . $groupId );

        // get translations
        $translations = Translations::getGroupTranslations( $this->database, $groupId );
        
        // loop over translations
        foreach( $translations as $index => $translation ){
            
            // remove translation
            $this->translationDelete->delete( array( 'id' => $translation->id ) );
            
        }
        // loop over translations
        
        // delete group
        SiteOptionsDelete::deleteOption( $this->database, $groupId );        
        
    }
    
}
