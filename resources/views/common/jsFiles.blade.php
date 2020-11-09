<?php
    $version = 0.000001;
    
    $jsMinimized = isset( $jsMinimized ) ? $jsMinimized : false;

?>

<?php // include jquery ?>
<script type="text/javascript" src="{{ URL::to( '/public/common/js/thirdParty/jquery-3.4.1.min.js') }}<?php echo '?version=' . $version; ?>"></script>

<?php
    
//////////////////////////  minimized / else /////////////////////////////
if( $jsMinimized ){
?>

    @include( 'common.jsProjectMinimized' )

<?php

}
else {
///////////////////////////////  else ///////////////////////////////////
?>

    @include( 'common.jsProject' )

<?php
}
//////////////////////////  minimized / else /////////////////////////////

?>



    



