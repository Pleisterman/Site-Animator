<?php
?>
    
    // base dir
    pleisterman.baseDir = "<?php echo env( 'SITE_ANIMATOR_BASE_DIR' ); ?>";

    // ajax dir
    pleisterman.ajaxDir = "<?php echo env( 'SITE_ANIMATOR_AJAX_DIR' ); ?>";

    // add user agent
    pleisterman.userAgent = <?php echo json_encode( $userAgent ); ?>;

    // set routeVariables
    pleisterman.routeVariables = <?php echo json_encode( $routeVariables ); ?>;
    
    // add public url
    pleisterman.publicUrl = "<?php echo url( '/' ) . '/public/' . env( 'SITE_ANIMATOR_BASE_DIR' ) . '/'; ?>";

    // add image url
    pleisterman.siteImageUrl = "<?php echo url( '/' ) . '/public/' . env( 'SITE_ANIMATOR_BASE_DIR' ) . '/site/assets/images/'; ?>";
    
    // site languages
    pleisterman.siteLanguages = <?php echo json_encode( $siteLanguages ); ?>;

    // site language id
    pleisterman.siteLanguageId = <?php echo $siteLanguageId; ?>;

    // site language default id
    pleisterman.siteDefaultLanguageId = <?php echo $siteDefaultLanguageId; ?>;

    // site items files
    pleisterman.siteItemsFiles =  <?php echo json_encode( $siteItemsFiles ); ?>;
    
    // site translations
    pleisterman.siteTranslations =  <?php echo json_encode( $siteTranslations ); ?>;
    
    // site animation sequences
    pleisterman.siteAnimationSequences = <?php echo json_encode( $animationSequences ); ?>;

    // debug animations debug 
    pleisterman.siteAnimationsDebugOn = false; <?php // echo json_encode( env( 'ANIMATIONS_DEBUG_ON', false ) ); ?>;

    // site settings
    pleisterman.siteSettings = <?php echo json_encode( $siteSettings ); ?>;

    // hide elements ids
    pleisterman.hideElementIds = <?php echo isset( $siteSettings['hideElementIds'] ) ? $siteSettings['hideElementIds'] : true; ?>;

    // set page
    pleisterman.page = <?php echo json_encode( $page ); ?>;

    // add language routes
    pleisterman.languageRoutes = <?php echo json_encode( $languageRoutes ); ?>;

    // set routeVariables
    pleisterman.routeVariables = <?php echo json_encode( $routeVariables );
    