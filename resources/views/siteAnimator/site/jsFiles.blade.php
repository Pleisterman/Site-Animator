<?php

$version = 0.0000039;

$jsDir = env( 'SITE_ANIMATOR_JS_DIR' );

$files = array(    
    '/common/js/site/connection/siteConnectionModule.js',    
    '/common/js/site/connection/siteConnectionErrorModule.js',    
    '/common/js/site/connection/siteCommunicationModule.js',    
    '/common/js/site/main/siteBusyScreenModule.js',    
    
    $jsDir . '/site/js/service/processBackgroundImageModule.js',
    $jsDir . '/site/js/service/processLayoutModule.js',
    $jsDir . '/site/js/service/processOrientationOptionsModule.js',
    $jsDir . '/site/js/service/openLinkModule.js',
    $jsDir . '/site/js/service/validateModule.js',
    $jsDir . '/site/js/service/extendElementModule.js',
    $jsDir . '/site/js/service/elementPositionModule.js',
    $jsDir . '/site/js/service/elementEventsModule.js',
    $jsDir . '/site/js/service/calculateFontSizeModule.js',

    $jsDir . '/site/js/jQueryAnimations/jQueryAnimationsModule.js',

    $jsDir . '/site/js/lazyLoading/lazyLoadingModule.js',

    $jsDir . '/site/js/parts/page/pageWithMenuModule.js',

    $jsDir . '/site/js/parts/animations/service/getAnimationDelayModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerFramesModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerAnimateModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerAnimatePositionModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerAnimateScaleModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerAnimateColorModule.js',

    $jsDir . '/site/js/parts/animations/sound/soundPlayerModule.js',

    $jsDir . '/site/js/parts/common/textContainerModule.js',
    $jsDir . '/site/js/parts/common/linkModule.js',
    $jsDir . '/site/js/parts/common/containerModule.js',
    $jsDir . '/site/js/parts/common/elementModule.js',
    $jsDir . '/site/js/parts/common/imageModule.js',
    $jsDir . '/site/js/parts/common/toTopButtonModule.js',

    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageModule.js',
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageSplashScreenModule.js',
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageSplashScreenContentModule.js',
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageContentModule.js',
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageContentHeaderModule.js',
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageContentFooterModule.js',
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageContentItemsModule.js',
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageContentAnimationsModule.js',
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageContentAnimationDimensionsModule.js',    
    $jsDir . '/site/js/parts/pleistermanSite/pleistermanPageContentItemModule.js',
        
    $jsDir . '/site/js/parts/pleistermanSite/common/pleistermantSiteCommonHeaderModule.js',
);
    
    
?>

@foreach ($files as $file)
<script type="text/javascript" src="{{ URL::to( '/public' . $file ) }}<?php echo '?version=' . $version; ?>"></script>
@endforeach


