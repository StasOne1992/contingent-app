<?php

namespace App\MainApp\Service;

class DataService
{

public function daysCountString($ndata):string
{

    if( $ndata == '1'){
        return $ndata." день";
    } elseif( str_ends_with($ndata, -1) == '2'){
        return $ndata." дня";
    } elseif(  str_ends_with($ndata, -1) == '3'){
        return $ndata." дня";
    } elseif(  str_ends_with($ndata, -1) == '4'){
        return $ndata." дня";
    } else {
        return $ndata." дней";
    }
}

}