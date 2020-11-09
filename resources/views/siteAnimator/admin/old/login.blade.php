<?php

$version = 0.00001;

// set font option if exists
$font = isset( $userOptions['font'] ) ? $userOptions['font']['value'] : 'Roboto';
// set font size option if exists
$fontSize = isset( $userOptions['fontSize'] ) ? $userOptions['fontSize']['value'] . 'px' : '18px';
// set commonBackgroundColor if exists
$commonBackgroundColor = isset( $colors['commonBackgroundColor'] ) ? $colors['commonBackgroundColor']['color'] : 'white';
// set commonColor if exists
$commonColor = isset( $colors['commonColor'] ) ? $colors['commonColor']['color'] : 'black';
// set commonBackgroundColor if exists
$linkColor = isset( $colors['linkColor'] ) ? $colors['linkColor']['color'] : 'rgb( 172, 172, 172)';
// set commonColor if exists
$linkHighlightColor = isset( $colors['linkHighlightColor'] ) ? $colors['linkHighlightColor']['color'] : 'rgb( 192, 192, 172)';

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

<?php  // include icon ?>
    
    @include( 'siteAnimator.common.icon' )

<?php

// spacing
echo PHP_EOL;

    // add title
    echo '<title>' . $translations['documentTitle'][$selectedLanguageId] . '</title>' . PHP_EOL;

?>

    <?php // include common css ?>
    <link href="{{ URL::to( '/public/codeAnalyser/admin/css/common.css') }}" media="screen" rel="stylesheet" type="text/css">

<?php

    // add document description
    echo '<meta name="description" content="' . $translations['documentDescription'][$selectedLanguageId] . '">' . PHP_EOL;;
    
    // add document keywords
    echo '<meta name="keywords" content="' . $translations['documentKeywords'][$selectedLanguageId] . '">' . PHP_EOL;;
    

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

        // incluse login javascript varables
        @include( 'siteAnimator.login.jsVars' );

        // add onload event    
        window.onload = function(){

            // start the application
            pleisterman.start();

            // create redirect module
            pleisterman.redirect = new pleisterman.redirectAfterLoginModule();

        };
        // done add onload event    

    </script> 
    
    @include( 'common.jsFiles' )
    @include( 'siteAnimator.login.jsFiles' )

<?php

// spacing
echo PHP_EOL;

// close body
echo '</body>' . PHP_EOL;


// open html
echo '</html>' . PHP_EOL;

?>
