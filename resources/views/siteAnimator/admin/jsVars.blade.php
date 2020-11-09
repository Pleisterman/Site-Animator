<?php
?>

    // add admin languages
    pleisterman.adminLanguages = <?php echo json_encode( $adminLanguages ); ?>;

    // add admin translations
    pleisterman.adminTranslations = <?php echo json_encode( $adminTranslations ); ?>;

    // add admin colors
    pleisterman.adminColors = <?php echo json_encode( $adminColors ); ?>;
    
    // add admin image url
    pleisterman.adminImageUrl = "<?php echo url( '/' ) . '/public/' . env( 'SITE_ANIMATOR_BASE_DIR' ) . '/admin/assets/images/'; ?>";    
    
    // user id
    pleisterman.adminUid = '<?php echo $adminUid; ?>';
    
    // user name
    pleisterman.adminUserName = '<?php echo $adminUserName; ?>';
    
    // user options
    pleisterman.adminUserOptions = <?php echo json_encode( $adminUserOptions ); ?>;
    
    // token 
    pleisterman.adminToken = "<?php echo $adminToken ?>";
    
    // isResetPassword 
    pleisterman.adminIsResetPassword = <?php echo json_encode( $adminIsResetPassword ); ?>;

    // add admin settings
    pleisterman.adminSettings = <?php echo json_encode( $adminSettings ); ?>;

    // host 
    pleisterman.host = "<?php echo env( 'SITE_ANIMATOR_HOST' ) ?>";
        
    // site path 
    pleisterman.sitePath = "<?php echo $sitePath ?>";
        
    // site items
    pleisterman.siteItems = <?php echo json_encode( $siteItems ); ?>;