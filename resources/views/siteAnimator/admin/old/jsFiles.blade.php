<?php
    $version = 0.0000001;

    $files = array(
        
        '/common/js/service/getInterfaceIndexModule.js',
        '/common/js/service/keyboardEventsModule.js',
        '/common/js/service/busyScreenModule.js',

        '/common/js/errors/errorDialogModule.js',

        '/common/js/tools/clickAbleModule.js',
        
        '/common/js/ajax/ajaxModule.js',
        
        '/common/js/ajax/ajaxErrorModule.js',
        
        '/common/js/user/userModule.js',
        '/common/js/user/loginDialogModule.js',
        '/common/js/user/sendResetPasswordEmailDialogModule.js',
        
        '/siteAnimator/admin/js/main/main.js',
        '/siteAnimator/admin/js/main/settingsModule.js',
        '/siteAnimator/admin/js/main/layoutModule.js',
        '/siteAnimator/admin/js/main/contentModule.js',
        
        '/siteAnimator/admin/js/errors/errorsModule.js',
    );
    
    
?>

@foreach ($files as $file)
<script type="text/javascript" src="{{ URL::to( '/public' . $file ) }}<?php echo '?version=' . $version; ?>"></script>
@endforeach


