<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       LanguagesRead.php
        function:   
                    
         Last revision: 23-07-2020

*/

namespace App\SiteAnimator\Admin\Site\Languages\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\Languages;

class LanguagesRead extends BaseClass {

    protected $debugOn = true;
    public function read( $database, $selection ){

        // get languages
        return Languages::getLanguages( $database );
        
    }
    
}
