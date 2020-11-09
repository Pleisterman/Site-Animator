<?php
?>

    // add languages
    pleisterman.languages = <?php echo json_encode( $languages ); ?>;

    // add selected language id
    pleisterman.selectedLanguageId = <?php echo $selectedLanguageId; ?>;

    // add translations
    pleisterman.translations = <?php echo json_encode( $translations ); ?>;

    // add colors
    pleisterman.colors = <?php echo json_encode( $colors ); ?>;
    
    // base dir
    pleisterman.baseDir = "<?php echo env( 'SITE_ANIMATOR_BASE_DIR' ); ?>";
    
    // add admin image url
    pleisterman.adminImageUrl = "<?php echo url( '/' ) . '/public/siteAnimator/admin/assets/images/'; ?>";    
    
    // user id
    pleisterman.adminUid = '<?php echo $adminUid; ?>';
    
    // user name
    pleisterman.adminUserName = '<?php echo $adminUserName; ?>';
    
    // user options
    pleisterman.adminUserOptions = <?php echo json_encode( $adminUserOptions ); ?>;
    
    // token 
    pleisterman.adminToken = "<?php echo $adminToken ?>";
    
    // isResetPassword 
    pleisterman.isResetPassword = <?php echo json_encode( $isResetPassword ); ?>;

    // add settings
    pleisterman.settings = <?php echo json_encode( $settings ); ?>;

    // site path 
    pleisterman.sitePath = "<?php echo $sitePath ?>";
    
    