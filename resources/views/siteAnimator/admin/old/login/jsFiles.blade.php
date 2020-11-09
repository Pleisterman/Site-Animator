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
        
        '/common/js/login/main.js',
        '/common/js/login/settingsModule.js',
        '/common/js/login/layoutModule.js',
        '/common/js/login/contentModule.js',
        '/common/js/login/loginDialogModule.js',
        '/common/js/login/sendResetPasswordEmailDialogModule.js',
        
        '/common/js/admin/errors/adminErrorsModule.js',
        '/siteAnimator/admin/js/login/redirectAfterLoginModule.js',
        
    );
    
    
?>

@foreach ($files as $file)
<script type="text/javascript" src="{{ URL::to( '/public' . $file ) }}<?php echo '?version=' . $version; ?>"></script>
@endforeach


