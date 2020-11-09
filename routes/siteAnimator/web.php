<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// create options
$options = array(
    'pathBase'              =>  env( 'SITE_ANIMATOR_BASE_DIR' ) . '/',
    'appName'               =>  'siteAnimator',
    'appCode'               =>  'SITE_ANIMATOR',
    'database'              =>  'siteAnimator',
    'ipBlockedRedirect'     =>  'siteAnimatorSite',
    'redirectToSite'        =>  'siteAnimatorSite'
);
// create options

// user route handler
Route::get('/' . $options['pathBase']. 'admin/{params?}', [
    'middleware' => [
        'common.resetDebuggerLog', 
        'common.validateRequestValues', 
        'common.addUserAgent', 
        'common.cookieQueue', 
        'common.admin.registerIp', 
        'common.admin.addStandardHeaders', 
        'common.addRouteVariables', 
        'common.site.getRoute', 
        'common.site.truncateBaseDirFromRoute', 
        'siteAnimator.admin.truncateAdminFromRoute', 
        'siteAnimator.admin.getWebUser', 
        'siteAnimator.admin.truncateUserNameFromRoute', 
        'siteAnimator.admin.addSiteItems', 
        'common.admin.addUserOptions', 
        'common.addLanguages', 
        'common.addSettings', 
        'common.admin.addColors',
        'common.admin.cleanTokens', 
        'common.createCookiesEnabledCookie',
        'common.admin.createRememberMe',
        'siteAnimator.admin.addSiteLanguages', 
        'siteAnimator.site.getLanguage', 
        'siteAnimator.admin.addSiteIndexTranslations',
        'siteAnimator.site.addSettings', 
        'siteAnimator.site.addFonts', 
        'siteAnimator.site.addColors',   
        'siteAnimator.site.addCss',   
        'siteAnimator.site.addAnimationSequences', 
        'siteAnimator.site.addPage'
        
    ],
    'uses'                  =>  'SiteAnimator\Http\Controllers\Admin\AdminController@Index',
    'sitePath'              =>  $options['pathBase'],
    'ipBlockedRedirect'     =>  $options['ipBlockedRedirect'],
    'redirectToSite'        =>  $options['redirectToSite'],
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true
    
])->where( 'params', '(.*)' );
// user route handler


// site route handler
Route::get( '/' . $options['pathBase'] . '{params?}' , [
    
    'middleware' => [
        'common.resetDebuggerLog', 
        'common.addUserAgent', 
        'common.addRouteVariables', 
        'common.site.registerIp', 
        'common.site.addStandardHeaders', 
        'common.addLanguages', 
        'common.site.getRoute', 
        'common.site.truncateBaseDirFromRoute', 
        'siteAnimator.site.getLanguage', 
        'siteAnimator.site.addIndexTranslations',
        'siteAnimator.site.addSettings', 
        'siteAnimator.site.addSiteItems', 
        'siteAnimator.site.addFonts', 
        'siteAnimator.site.addAnimationSequences', 
        'siteAnimator.site.addPage', 
    ],
    'as'                    =>  'siteAnimatorSite',
    'uses'                  =>  'SiteAnimator\Http\Controllers\Site\SiteController@Index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  false
    
])->where( 'params', '(.*)' );
// site route handler
