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

function fechaAnteriorActual($fecha){
    if(strtotime($fecha) > date()){
        return 0;
    }
    return 1;
}
?>