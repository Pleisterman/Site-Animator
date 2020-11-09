<?php

/*
    @package    Pleisterman\SiteAnimator

    file:       api.php
    function:   defines api Routes 

    Last revision: 02-01-2020
 
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

// read
Route::post('/'  . $options['pathBase'] . 'admin/read', [
    'uses'                  => 'SiteAnimator\Http\Controllers\Admin\ReadController@index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true
]);
// read

// remember me
Route::post('/'  . $options['pathBase'] . 'admin/rememberMe', [
    
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.validateCookiesEnabled', 
        'common.addUserAgent', 
        'common.cookieQueue', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.addUserOptions', 
        'common.admin.validateRememberMe'        
    ],
    'uses'                  => 'SiteAnimator\Http\Controllers\Admin\RememberMeController@Index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true,
    'ipBlockedRedirect'     =>  'siteAnimatorSite',
    'redirectToSite'        =>  'siteAnimatorSite'
]);
// remember me

// prepare login
Route::post('/' . $options['pathBase'] . 'admin/prepareLogin', [
    
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.cookieQueue', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.createPrepareLogin'        
    ],
    'uses'                  => 'SiteAnimator\Http\Controllers\Admin\LoginController@prepareLogin',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true,
    'ipBlockedRedirect'     =>  'siteAnimatorSite',
    'redirectToSite'        =>  'siteAnimatorSite'
    
]);
// prepare login

// validate prepare login
Route::post('/' . $options['pathBase'] . 'admin/validatePrepareLogin', [
    
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.cookieQueue', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.validatePrepareLogin', 
        'common.admin.createLogin'        
    ],
    'uses'                  => 'SiteAnimator\Http\Controllers\Admin\LoginController@validatePrepareLogin',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true,
    'ipBlockedRedirect'     =>  'siteAnimatorSite',
    'redirectToSite'        =>  'siteAnimatorSite'
    
]);
// validate prepare login

// login
Route::post('/' . $options['pathBase'] . 'admin/login', [
    
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.cookieQueue', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.validateLogin', 
        'common.admin.validateCredentials'      
    ],
    'uses'                  => 'SiteAnimator\Http\Controllers\Admin\LoginController@login',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true,
    'ipBlockedRedirect'     =>  'siteAnimatorSite',
    'redirectToSite'        =>  'siteAnimatorSite'
    
]);
// login

// log out
Route::post('/' . $options['pathBase'] . 'admin/logOut', [
    
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.cookieQueue', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.authenticate', 
        'common.admin.logOut'      
    ],
    'uses'                  => 'SiteAnimator\Http\Controllers\Admin\LoginController@logOut',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true,
    'ipBlockedRedirect'     =>  'siteAnimatorSite',
    'redirectToSite'        =>  'siteAnimatorSite'
    
]);
// log out

// read secure
Route::post('/' . $options['pathBase'] . 'admin/readSecure', [
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.authenticate',
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Admin\ReadSecureController@index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true
]);
// read secure

// read secure
Route::post('/' . $options['pathBase'] . 'admin/getPage', [
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.authenticate',
        'common.site.getRoute', 
        'common.addRouteVariables', 
        'common.site.addStandardHeaders', 
        'siteAnimator.site.addSettings', 
        'siteAnimator.site.addColors', 
        'siteAnimator.site.addLanguages', 
        'siteAnimator.site.getApiLanguage', 
        'siteAnimator.site.addShowNotPublic', 
        'siteAnimator.site.addPage', 
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Site\ReadController@page',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true
]);
// read secure

// insert
Route::post('/' . $options['pathBase'] . 'admin/insert', [
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.authenticate',
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Admin\InsertController@index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true
]);
// insert

// update
Route::post('/' . $options['pathBase'] . 'admin/update', [
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.authenticate',
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Admin\UpdateController@index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true
]);
// update

// delete
Route::post('/' . $options['pathBase'] . 'admin/delete', [
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.authenticate',
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Admin\DeleteController@index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true
]);
// delete

// upload
Route::post('/' . $options['pathBase'] . 'admin/upload', [
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.admin.registerIp', 
        'common.admin.findApiUser', 
        'common.admin.authenticate',
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Admin\UploadController@index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  true
]);
// upload

// get page
Route::post('/' . $options['pathBase'] . 'getPage', [
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.admin.registerIp', 
        'common.site.getRoute', 
        'common.addRouteVariables', 
        'siteAnimator.site.addSettings', 
        'siteAnimator.site.addColors', 
        'common.addLanguages', 
        'siteAnimator.site.getApiLanguage', 
        'siteAnimator.site.addPage', 
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Site\ReadController@page',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  false
    
]);
// get page

// get blog data
Route::post('/' . $options['pathBase'] . 'getBlogData', [
    'middleware' => [
        'common.validateRequestValues', 
        'common.validateConnectionSecure', 
        'common.addUserAgent', 
        'common.admin.registerIp', 
        'common.addLanguages', 
        'siteAnimator.site.getApiLanguage', 
        'siteAnimator.site.addBlogData', 
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Site\ReadController@blogData',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  false
    
]);
// get blog data

// mail
Route::post('/' . $options['pathBase'] . '/mail', [
    'middleware' => [
        'common.addUserAgent', 
        'common.addLanguages', 
        'siteAnimator.site.getApiLanguage', 
    ],
    'uses' => 'SiteAnimator\Http\Controllers\Site\MailController@index',
    'appName'               =>  $options['appName'],
    'appCode'               =>  $options['appCode'],
    'database'              =>  $options['database'],
    'isAdmin'               =>  false
]);
// mail
