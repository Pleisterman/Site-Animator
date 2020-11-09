<?php

$version = 0.0000019;

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

    $jsDir . '/site/js/parts/animations/logo/logoBlockModule.js',

    $jsDir . '/site/js/parts/animations/block/blockWithAnimationModule.js',
    $jsDir . '/site/js/parts/animations/block/blockWithAnimationLayoutModule.js',

    $jsDir . '/site/js/parts/animations/service/getAnimationDelayModule.js',

    $jsDir . '/site/js/parts/animations/groups/animationGroupLayoutModule.js',
    $jsDir . '/site/js/parts/animations/groups/animationGroupValidateModule.js',
    $jsDir . '/site/js/parts/animations/groups/animationGroupAnimationsModule.js',
    $jsDir . '/site/js/parts/animations/groups/animationGroupModule.js',

    $jsDir . '/site/js/parts/animations/animation/animationValidateModule.js',
    $jsDir . '/site/js/parts/animations/animation/animationSequencesModule.js',
    $jsDir . '/site/js/parts/animations/animation/animationUiEventsModule.js',
    $jsDir . '/site/js/parts/animations/animation/animationModule.js',

    $jsDir . '/site/js/parts/animations/player/animationPlayerModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerFramesModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerAnimateModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerAnimatePositionModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerAnimateScaleModule.js',
    $jsDir . '/site/js/parts/animations/player/animationPlayerAnimateColorModule.js',

    $jsDir . '/site/js/parts/animations/sound/soundPlayerModule.js',

    // old
    $jsDir . '/site/js/parts/animations/old/multiLineTextAnimationModule.js',
    $jsDir . '/site/js/parts/animations/old/multiLineTextAnimationTextModule.js',
    $jsDir . '/site/js/parts/animations/old/bigCircleAnimationModule.js',
    $jsDir . '/site/js/parts/animations/old/bigCircleAnimationCircleModule.js',
    $jsDir . '/site/js/parts/animations/old/objects/textAnimationModule.js',
    $jsDir . '/site/js/parts/animations/old/objects/backgroundImageAnimationModule.js',
    $jsDir . '/site/js/parts/animations/old/objects/imageAnimationModule.js',
    // old


    $jsDir . '/site/js/parts/animations/object/animationObjectModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectTextModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectImageModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectLanguageMenuModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectLayoutModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectUiEventsModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectLayoutAnimationsModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectCssModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectLetterChaseModule.js',
    $jsDir . '/site/js/parts/animations/object/animationObjectTumbleAnimationsModule.js',

    $jsDir . '/site/js/parts/chinese/chineseTextModule.js',

    $jsDir . '/site/js/parts/video/videoModule.js',


    
    $jsDir . '/site/js/parts/footer/footerModule.js',
    $jsDir . '/site/js/parts/footer/footerBlockModule.js',

    $jsDir . '/site/js/parts/cookieConsent/cookieConsentModule.js',

    $jsDir . '/site/js/parts/common/adjustedTextContainerModule.js',
    $jsDir . '/site/js/parts/common/layerModule.js',
    $jsDir . '/site/js/parts/common/blockModule.js',
    $jsDir . '/site/js/parts/common/columnModule.js',
    $jsDir . '/site/js/parts/common/headerModule.js',
    $jsDir . '/site/js/parts/common/logoModule.js',
    $jsDir . '/site/js/parts/common/toTopButtonModule.js',
    $jsDir . '/site/js/parts/common/textContainerModule.js',
    $jsDir . '/site/js/parts/common/collapseContainerModule.js',
    $jsDir . '/site/js/parts/common/linkModule.js',
    $jsDir . '/site/js/parts/common/containerModule.js',
    $jsDir . '/site/js/parts/common/elementModule.js',
    $jsDir . '/site/js/parts/common/imageWithTextModule.js',
    $jsDir . '/site/js/parts/common/backgroundImageModule.js',
    $jsDir . '/site/js/parts/lists/listModule.js',
    $jsDir . '/site/js/parts/lists/listItemModule.js',
    $jsDir . '/site/js/parts/topMenu/topMenuModule.js',
    $jsDir . '/site/js/parts/topMenu/topMenuLanguageMenuModule.js',
    $jsDir . '/site/js/parts/topMenu/topMenuLanguageMenuItemsModule.js',
    $jsDir . '/site/js/parts/topMenu/topMenuItemModule.js',
    $jsDir . '/site/js/parts/topMenu/topMenuSubItemModule.js',
    $jsDir . '/site/js/parts/topMenu/topCollapseMenuModule.js',
    $jsDir . '/site/js/parts/topMenu/topCollapseMenuItemModule.js',
    $jsDir . '/site/js/parts/home/homePanelModule.js',

    $jsDir . '/site/js/parts/flexContainer/flexContainerModule.js',
    $jsDir . '/site/js/parts/flexContainer/flexContainerItemModule.js',

    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderTitleModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderMenuModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderMenuRootItemModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderMenuSubItemModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderLanguageMenuModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderLanguageCollapseMenuModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderLanguageCollapseMenuSelectModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderLanguageCollapseMenuSelectItemModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderCollapseMenuModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderCollapseMenuSelectModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderCollapseMenuSelectItemModule.js',
    $jsDir . '/site/js/parts/responsiveHeader/responsiveHeaderCollapseMenuSelectLanguageItemModule.js',
    
    $jsDir . '/site/js/parts/blog/blogModule.js',
    $jsDir . '/site/js/parts/blog/blogNavigationModule.js',
    $jsDir . '/site/js/parts/blog/blogSubjectBreadCrumbModule.js',
    $jsDir . '/site/js/parts/blog/blogContentModule.js',
    $jsDir . '/site/js/parts/blog/blogSubjectsModule.js',
    $jsDir . '/site/js/parts/blog/blogSubjectModule.js',
    $jsDir . '/site/js/parts/blog/blogExcerptsListModule.js',
    $jsDir . '/site/js/parts/blog/blogExcerptModule.js',
    $jsDir . '/site/js/parts/blog/blogEntryModule.js',
    $jsDir . '/site/js/parts/blog/blogEntryNavigationModule.js',
    $jsDir . '/site/js/parts/blog/blogEntryNavigationItemModule.js',
    $jsDir . '/site/js/parts/blog/blogEntryContentModule.js',

    $jsDir . '/site/js/parts/contact/contactFormModule.js',
    $jsDir . '/site/js/parts/contact/contactFormItemModule.js',
    $jsDir . '/site/js/parts/contact/contactFormItemTextModule.js',
    $jsDir . '/site/js/parts/contact/contactFormItemTextAreaModule.js',
    $jsDir . '/site/js/parts/contact/contactFormItemCheckboxModule.js',
    $jsDir . '/site/js/parts/contact/contactFormItemLinkedCheckboxModule.js',

    $jsDir . '/site/js/parts/cv/cvPageModule.js',
    $jsDir . '/site/js/parts/cv/cvHeaderModule.js',

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
        
    $jsDir . '/site/js/parts/tutorials/packman/packmanModule.js',
    $jsDir . '/site/js/parts/tutorials/packman/packmanSplashScreenModule.js',
    $jsDir . '/site/js/parts/tutorials/packman/packmanSplashScreenContentModule.js',
    $jsDir . '/site/js/parts/tutorials/packman/packmanContentModule.js',
    
);
    
    
?>

@foreach ($files as $file)
<script type="text/javascript" src="{{ URL::to( '/public' . $file ) }}<?php echo '?version=' . $version; ?>"></script>
@endforeach


