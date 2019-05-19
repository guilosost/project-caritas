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
function calculaedad($fechanacimiento){
    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
      $ano_diferencia--;
    return $ano_diferencia;
  }
?>