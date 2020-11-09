<?php
    $version = 0.000020;

    $files = array(
        
        'site/js/service/getInterfaceIndexModule.js',
        'site/js/service/calculateFontSizeModule.js',
        
        'common/js/tools/colorPickerModule.js',
        'common/js/tools/imageButtonModule.js',
        'common/js/tools/dragAbleModule.js',
        'common/js/tools/clickAbleModule.js',
        'common/js/tools/uiEventsModule.js',
        
        'site/js/service/processBackgroundImageModule.js',
        'site/js/service/processLayoutModule.js',
        'site/js/service/processOrientationOptionsModule.js',
        
        'site/js/service/openLinkModule.js',
        'site/js/service/validateModule.js',
        'site/js/service/elementEventsModule.js',
        
        'site/js/parts/page/pageWithMenuModule.js',
        
        'site/js/parts/animations/logo/logoBlockModule.js',
        
        'site/js/parts/animations/service/getAnimationDelayModule.js',
        
        'site/js/parts/animations/player/animationPlayerModule.js',
        
        'site/js/parts/animations/sound/soundPlayerModule.js',
        
        'site/js/parts/common/layerModule.js',
        'site/js/mobile/parts/common/headerModule.js',
        'site/js/mobile/parts/common/logoModule.js',
        'site/js/mobile/parts/common/blockModule.js',
        'site/js/mobile/parts/common/collapseAbleBlockModule.js',
        'site/js/mobile/parts/common/blockTextContainerModule.js',
        'site/js/mobile/parts/common/adjustedTextContainerModule.js',
        'site/js/mobile/parts/common/homeLinkModule.js',
        
        'site/js/mobile/parts/languageMenu/languageMenuModule.js',
        'site/js/mobile/parts/languageMenu/languageMenuItemsModule.js',
        
        'site/js/mobile/parts/contact/contactFormModule.js',
        'site/js/mobile/parts/contact/contactFormItemModule.js'
        
    );
    
    
?>

@foreach ($files as $file)
<script type="text/javascript" src="{{ URL::to( '/public/' . $file ) }}<?php echo '?version=' . $version; ?>"></script>
@endforeach


