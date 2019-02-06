<?php
require("conexion.php");
        
    //variables POST
    $longitud = $_POST['longitud'];
    $latitud = $_POST['latitud'];
    $tiempo = date('Y-m-d h:i:s');

    $consulta = "INSERT INTO direcciones(latitude,longitude,fecha_busq) VALUES ('$latitud','$longitud','$tiempo')";
    $query = pg_query($dbconn, $consulta) or die('Error: ' . pg_last_error());
    if($query)
    {            
        echo '<script language="javascript">confirm("Datos Guardados");</script>'; 
        pg_close($dbconn);
    }
    else
    {
        echo "No se pudieron guardar los datos";
    }
    
?>