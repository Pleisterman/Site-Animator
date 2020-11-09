<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       UserOptions.php
        function:   
                    
        Last revision: 17-02-2020
 
*/

namespace App\SiteAnimator\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserOptions extends Model {
    
    static public function getUserOptionById( $database, $id ) {
        
        // get user option
        return DB::connection( $database )
                       ->table(    'admin_user_options' )
                       ->select(   'name', 
                                   'value', 
                                   'edit_options as editOptions',
                                   'updated_at as updatedAt'  )
                       ->where(    'id', $id )
                       ->first();
        // get user option
        
    }    
    
    
}
