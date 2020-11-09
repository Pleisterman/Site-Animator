<?php

$version = 0.00001;

// create base dit
$baseDir = '';

// base dir ! empty
if( !empty( env( 'SITE_ANIMATOR_BASE_DIR' ) ) ){

    // set base dir
    $baseDir = '/' . env( 'SITE_ANIMATOR_BASE_DIR' );

}
// base dir ! empty

// create site root
$siteRoot = '';

// site root ! empty
if( !empty( env( 'SITE_ANIMATOR_BASE_DIR' ) ) ){

    // set site root
    $siteRoot = '/' . env( 'SITE_ANIMATOR_BASE_DIR' );

}
// site root ! empty

// add admin to site root
$siteRoot .= env( 'SITE_ANIMATOR_SITE_ROOT' ) . '/admin/' . $adminUserRoute;

// set font option if exists
$font = isset( $siteSettings['font'] ) ? $siteSettings['font'] : 'Roboto';
// set font size option if exists
$fontSize = isset( $siteSettings['fontSize'] ) ? $siteSettings['fontSize'] . 'px' : '18px';
// set commonBackgroundColor if exists
$commonBackgroundColor = isset( $siteColors['commonBackgroundColor'] ) ? $siteColors['commonBackgroundColor'] : 'white';
// set commonColor if exists
$commonColor = isset( $siteColors['commonColor'] ) ? $siteColors['commonColor'] : 'black';
// set commonBackgroundColor if exists
$linkColor = isset( $siteColors['linkColor'] ) ? $siteColors['linkColor'] : 'rgb( 172, 172, 172)';
// set commonColor if exists
$linkHighlightColor = isset( $colors['linkHighlightColor'] ) ? $siteColors['linkHighlightColor'] : 'rgb( 192, 192, 172)';

// add doc type
echo '<!DOCTYPE html>' . PHP_EOL;

// add html tag
echo '<html lang="' . $selectedLanguageCode . '">' . PHP_EOL;

    // open head
    echo '<head>' . PHP_EOL;

    // is mobile
    if( $userAgent['isMobile'] ){

        // add view port
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        
    }
    // is mobile
    
    // add font
?>

    <link href="https://fonts.googleapis.com/css?family=<?php echo $font; ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=<?php echo $adminUserOptions['fontFamily']; ?>" rel="stylesheet" type="text/css">

<?php  // include icon ?>
    
    @include( 'siteAnimator.common.icon' )

<?php

// spacing
echo PHP_EOL;

    // add title
    echo '<title>'  . '</title>' . PHP_EOL;

?>

    <?php // include common css ?>
<link href="{{ URL::to( '/public' . $baseDir . '/site/css/common.css') }}" media="screen" rel="stylesheet">

<?php


// spacing
echo PHP_EOL;

?>
<!-- Styles -->
<style>
    
    html, body, div {
        background-color: <?php echo $commonBackgroundColor; ?>;
        color: <?php echo $commonColor; ?>;
        font-family: '<?php echo $font; ?>';
        font-size: <?php echo $fontSize; ?>;
    }
    
    a:link {
      color: <?php echo $linkColor; ?>;
    }

    /* visited link */
    a:visited {
      color: <?php echo $linkColor; ?>;
    }

    /* mouse over link */
    a:hover {
      color: <?php echo $linkHighlightColor; ?>;
    }

    /* selected link */
    a:active {
      color: <?php echo $linkColor; ?>;
    }    
    
</style>

<?php

// close head
echo '</head>' . PHP_EOL;


// open body
echo '<body>' . PHP_EOL;

?>

     <script>

        // set strict mode
        "use strict";      

        // add the pleisterman object to the window
        var pleisterman = new function(){};

        // add site root
        pleisterman.siteRoot = "<?php echo $siteRoot; ?>";
    
        // include admin javascript varables
        @include( 'siteAnimator.admin.jsVars' );

        // include site javascript varables
        @include( 'siteAnimator.site.jsVars' );

        // debug options
        pleisterman.debugOn = <?php echo json_encode( env( 'ADMIN_JS_DEBUG_ON', false ) ); ?>;
        pleisterman.debugOptions = {
            'zIndex'    : {{ env( 'ADMIN_JS_DEBUG_Z_INDEX', 1000 ) }},
            'top'       : {{ env( 'ADMIN_JS_DEBUG_TOP', 100 ) }},
            'left'      : {{ env( 'ADMIN_JS_DEBUG_LEFT', 100 ) }},
            'width'     : {{ env( 'ADMIN_JS_DEBUG_WIDTH', 500 ) }},
            'height'    : {{ env( 'ADMIN_JS_DEBUG_HEIGHT', 200 ) }}        
        };
        // debug options

        // add onload event    
        window.onload = function(){

            // start the application
            pleisterman.start();

        };
        // done add onload event    

    </script> 
    
    @include( 'siteAnimator.common.jsFiles' )
    @include( 'siteAnimator.admin.jsFiles' )
    @include( 'siteAnimator.site.jsFiles' )
    
<?php

// spacing
echo PHP_EOL;

// close body
echo '</body>' . PHP_EOL;


// open html
echo '</html>' . PHP_EOL;

?>
