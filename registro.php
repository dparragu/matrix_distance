<?php
require("conexion.php");
        
    //variables POST
    $inicio = $_POST['inicio'];
    $destino = $_POST['destino'];
    $km = $_POST['km'];
    $estimado = $_POST['estimado'];
    $real = $_POST['real'];
    $tiempo = date('Y-m-d G:00:00');

    $inicio = str_replace("'","",$inicio);
    $destino = str_replace("'","",$destino);

    $consulta = "INSERT INTO distancia(inicio,destino,km,estimado,treal,fecha) VALUES ('$inicio','$destino','$km','$estimado','$real','$tiempo')";
    $query = pg_query($dbconn, $consulta) or die('Error: ' . pg_last_error());
    //echo '<script language="javascript">confirm("Datos Guardados");</script>';
    pg_close($dbconn); 
    
?>
