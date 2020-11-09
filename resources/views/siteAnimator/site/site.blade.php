<?php

$version = 0.000003;

// create js mimimized
$jsMinimized = false;

// create base dit
$baseDir = '';

// base dir ! empty
if( !empty( env( 'SITE_ANIMATOR_BASE_DIR' ) ) ){

    // set base dir
    $baseDir = '/' . env( 'SITE_ANIMATOR_BASE_DIR' );

}
// base dir ! empty

// set font option if exists
$font = isset( $siteSettings['font'] ) ? $siteSettings['font'] : 'Roboto';
// set font size option if exists
$fontSize = isset( $siteSettings['fontSize'] ) ? $siteSettings['fontSize'] . 'px' : '18px';

// get site language
$siteLanguage = $siteLanguages[$siteLanguageId];

// create title
$title = '';

// page options title options exists
if( isset( $page['options']['titleOptions'] ) ){
 
    // set title
    $title = $page['options']['titleOptions']['text'];
    
}
// page options title options exists

?>

<!DOCTYPE html>
<html lang='<?php echo $siteLanguage['abbreviation'] ?>'>
    <head>

<title><?php echo $title ?></title>
        
<?php // include icon ?>

<link id="favicon" href="{{ URL::to( '/public/site/assets/images/logo.ico') }}?version=0.0241" rel="shortcut icon" type="image/x-icon">
<?php
    
// is mobile
if( $userAgent['isMobile'] ){

    // add view port
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

}
// is mobile

// page options meta options exists
if( isset( $page['options']['metaOptions'] ) ){
 
    // get meta options
    $metaOptions = $page['options']['metaOptions'];
    
    // loop over meta options
    foreach( $metaOptions as $index => $option ){

        // open meta tag
        echo '<meta '; 

        // add name
        echo 'name="' . $index . '" ';
        

        // has translationId / else
        if( isset( $option['text'] ) ){
            
            // add content
            echo 'content="' . $option['text'] . '"';
            
        }
        else {
            
            // add content
            echo 'content="' . $option . '"';
            
        }
        // has translationId / else
        
        // close meta tag
        echo '>' . PHP_EOL;    
    }
    // loop over meta options
    
}
// page options meta options exists
    


// loop over sie fonts
foreach( $siteFonts as $index => $siteFont ){
    
    // type google
    if( $siteFont['type'] == 'google' ){
        
        // add font
        echo '<link href="https://fonts.googleapis.com/css?family=' .
              $siteFont['name'] .
              '" rel="stylesheet>' . PHP_EOL;
    }
}
// loop over sie fonts

?>


<link href="{{ URL::to( '/public' . $baseDir . '/site/css/common.css') }}" media="screen" rel="stylesheet">

<?php

// set commonBackgroundColor if exists
$commonBackgroundColor = isset( $siteColors['commonBackgroundColor'] ) ? $siteColors['commonBackgroundColor'] : 'white';
// set commonColor if exists
$commonColor = isset( $siteColors['commonColor'] ) ? $siteColors['commonColor'] : 'black';
// set commonBackgroundColor if exists
$linkColor = isset( $siteColors['linkColor'] ) ? $siteColors['linkColor'] : 'rgb( 172, 172, 172)';
// set commonColor if exists
$linkHighlightColor = isset( $siteColors['linkHighlightColor'] ) ? $siteColors['linkHighlightColor'] : 'rgb( 192, 192, 172)';
    
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
<!-- Styles -->


    </head>
        <body>

<script>
                 
    // set strict mode
    "use strict";      
    
    // add the pleisterman object to the window
    var pleisterman = new function(){};

    // add site root
    pleisterman.siteRoot = "<?php echo env( 'SITE_ANIMATOR_SITE_ROOT' ) . $baseDir; ?>";
    
    // debug options
    pleisterman.debugOn = <?php echo json_encode( env( 'SITE_JS_DEBUG_ON', false ) ); ?>;
    pleisterman.debugOptions = {
        'zIndex'    : {{ env( 'SITE_JS_DEBUG_Z_INDEX', 1000 ) }},
        'top'       : {{ env( 'SITE_JS_DEBUG_TOP', 100 ) }},
        'left'      : {{ env( 'SITE_JS_DEBUG_LEFT', 100 ) }},
        'width'     : {{ env( 'SITE_JS_DEBUG_WIDTH', 500 ) }},
        'height'    : {{ env( 'SITE_JS_DEBUG_HEIGHT', 200 ) }}        
    };
    // debug options
    
    // include site javascript vars
    @include( 'siteAnimator.site.jsVars' );
    
    // add onload event    
    window.onload = function(){

        // start the application
        pleisterman.start();

    };
    // done add onload event    
            
</script> 

@include('siteAnimator.common.jsFiles')

<script type="text/javascript" src="{{ URL::to( '/public' . $baseDir . '/site/js/main/main.js') }}<?php echo '?version=' . $version; ?>"></script>
<script type="text/javascript" src="{{ URL::to( '/public' . $baseDir . '/site/js/main/settingsModule.js') }}<?php echo '?version=' . $version; ?>"></script>
<script type="text/javascript" src="{{ URL::to( '/public' . $baseDir . '/site/js/main/contentModule.js') }}<?php echo '?version=' . $version; ?>"></script>
<script type="text/javascript" src="{{ URL::to( '/public' . $baseDir . '/site/js/main/cssModule.js') }}<?php echo '?version=' . $version; ?>"></script>
<script type="text/javascript" src="{{ URL::to( '/public' . $baseDir . '/site/js/main/layoutModule.js') }}<?php echo '?version=' . $version; ?>"></script>


<?php

///////////////////////////////  ! mobile  ///////////////////////////////////
//    if( !$userAgent['isMobile'] ){

        // site files minimized / else
        if( $jsMinimized ){
        
        // include minimized site js
?>        
        @include('siteAnimator.site.jsMinimized' )
        
<?php 
        }
        else {
            
        // include site js
?>        
        @include('siteAnimator.site.jsFiles' )
        
<?php 
        }
        // site files minimized / else

//    }
    // ! mobile
         
/////////////////////////////// ! mobile ///////////////////////////////////
?>        

        

        
    </body>
</html>
