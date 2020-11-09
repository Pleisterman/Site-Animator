<?php
    $version = 0.000001
?>

<script type="text/javascript" src="{{ URL::to( '/public/common/js/thirdParty/jquery-3.4.1.min.js') }}<?php echo '?version=' . $version; ?>"></script>

@include( 'common.jsProjectMinimized' )


<?php

    $files = array(
        
        '/common/js/service/getInterfaceIndexModule.js',
        '/common/js/service/keyboardEventsModule.js',
        
        '/common/js/tools/imageButtonModule.js',
        '/common/js/tools/dragAbleModule.js',
        '/common/js/tools/clickAbleModule.js',
        '/common/js/tools/uiEventsModule.js',

        '/common/js/tools/clickAbleModule.js'
      
        
    );
    
?>

@foreach ($files as $file)
<script type="text/javascript" src="{{ URL::to( '/public' . $file ) }}<?php echo '?version=' . $version; ?>"></script>
@endforeach

