<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsDelete.php
        function:   
                    
        Last revision: 07-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Routes\Delete\GroupsDelete as RouteGroupsDelete;
use App\SiteAnimator\Admin\Site\SiteItems\Delete\GroupsDelete as SiteItemGroupsDelete;
use App\SiteAnimator\Admin\Site\Templates\Delete\GroupsDelete as TemplateGroupsDelete;
use App\SiteAnimator\Admin\Site\Translations\Delete\GroupsDelete as TranslationGroupsDelete;
use App\SiteAnimator\Admin\Site\Lists\Delete\GroupsDelete as ListGroupsDelete;
use App\SiteAnimator\Admin\Site\Animations\Delete\GroupsDelete as AnimationGroupsDelete;
use App\SiteAnimator\Admin\Site\Sequences\Delete\GroupsDelete as SequenceGroupsDelete;
use App\SiteAnimator\Admin\Site\Media\Groups\GroupsDelete as MediaGroupsDelete;
use App\SiteAnimator\Admin\Site\Colors\Delete\GroupsDelete as ColorGroupsDelete;
use App\SiteAnimator\Admin\Site\Css\Delete\GroupsDelete as CssGroupsDelete;

class GroupsDelete extends BaseClass {

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
    public function delete( $selection ){
        
        // choose type 
        switch ( $selection['type'] ) {
                        
            // route group
            case 'routeGroup': {
                
                // create route groups delete
                $routeGroupsDelete = new RouteGroupsDelete( $this->database, $this->appCode );
                
                // return route group call
                return $routeGroupsDelete->delete( $selection );
                
            }
            // site item group
            case 'siteItemGroup': {
                
                // create site item groups delete
                $siteItemGroupsDelete = new SiteItemGroupsDelete( $this->database, $this->appCode );
                
                // return site item group call
                return $siteItemGroupsDelete->delete( $selection );
                
            }
            // template group
            case 'templateGroup': {
                
                // create template groups delete
                $templateGroupsDelete = new TemplateGroupsDelete( $this->database, $this->appCode );
                
                // return template group call
                return $templateGroupsDelete->delete( $selection );
                
            }
            // translation group
            case 'translationGroup': {
                
                // create translation groups delete
                $translationGroupsDelete = new TranslationGroupsDelete( $this->database, $this->appCode );
                
                // return site translations group call
                return $translationGroupsDelete->delete( $selection );
                
            }
            // list group
            case 'listGroup': {
                
                // create list groups delete
                $listGroupsDelete = new ListGroupsDelete( $this->database, $this->appCode );
                
                // return site list group call
                return $listGroupsDelete->delete( $selection );
                
            }
            // animation group
            case 'animationGroup': {
                
                // create animation groups delete
                $animationGroupsDelete = new AnimationGroupsDelete( $this->database, $this->appCode );
                
                // return site animation group call
                return $animationGroupsDelete->delete( $selection );
                
            }
            // sequence group
            case 'sequenceGroup': {
                
                // create sequence groups delete
                $sequenceGroupsDelete = new SequenceGroupsDelete( $this->database, $this->appCode );
                
                // return site sequence group call
                return $sequenceGroupsDelete->delete( $selection );
                
            }
            // media group
            case 'mediaGroup': {
                
                // create media groups delete
                $mediaGroupsDelete = new MediaGroupsDelete( $this->database, $this->appCode );
                
                // return site media group call
                return $mediaGroupsDelete->delete( $selection );
                
            }
            // css group
            case 'cssGroup': {
                
                // create css groups delete
                $cssGroupsDelete = new CssGroupsDelete( $this->database, $this->appCode );
                
                // return site css group call
                return $cssGroupsDelete->delete( $selection );
                
            }
            // color group
            case 'colorGroup': {
                
                // create color groups delete
                $colorGroupsDelete = new ColorGroupsDelete( $this->database, $this->appCode );
                
                // return site color group call
                return $colorGroupsDelete->delete( $selection );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'GroupsDelete error delete, type not found: ' . isset( $selection['type'] ) ? $selection['type'] : 'type not set' );
                
                // done with error
                return array( 'criticalError' => 'typeNotFound' );
                
            }
            
        }        
        // done choose type
                
    }
    
}
