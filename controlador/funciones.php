<?php
//Seleccionar usuario de sql

function minchars($str, $min){
    $len = strlen($str);
    if($len < $min){
        return 1;
    }else{
        return 0;
    }
}
?>