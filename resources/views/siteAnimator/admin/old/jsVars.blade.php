<?php
?>

    // add languages
    pleisterman.languages = <?php echo json_encode( $languages ); ?>;

    // add selected language id
    pleisterman.selectedLanguageId = <?php echo $userLanguageId; ?>;

    // add translations
    pleisterman.translations = <?php echo json_encode( $indexTranslations ); ?>;

    // add colors
    pleisterman.colors = <?php echo json_encode( $colors ); ?>;
    
    // site path
    pleisterman.sitePath = "<?php echo url( '/' ) . '/' . $sitePath; ?>";
    
    // base dir
    pleisterman.baseDir = "<?php echo env( 'SITE_ANIMATOR_BASE_DIR' ); ?>";
    
    // add admin image url
    pleisterman.adminImageUrl = "<?php echo url( '/' ) . '/public/siteAnimator/admin/assets/images/'; ?>";    
    
    // user id
    pleisterman.uid = '<?php echo $uid; ?>';
    
    // user name
    pleisterman.userName = '<?php echo $userName; ?>';
    
    // user options
    pleisterman.userOptions = <?php echo json_encode( $userOptions ); ?>;
    
    // helpSubjects 
    pleisterman.helpSubjects = <?php echo json_encode( $helpSubjects ); ?>;
    
    // token 
    pleisterman.token = "<?php echo $token ?>";
    
    // isResetPassword 
    pleisterman.isResetPassword = <?php echo json_encode( $isResetPassword ); ?>;

    // add settings
    pleisterman.settings = <?php echo json_encode( $settings ); ?>;
