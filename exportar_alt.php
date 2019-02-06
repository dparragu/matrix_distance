<?php
require("conexion.php");
    

    $i = 0;
    $name_archivo = date ( "d_m_Y-H_i_s" , time () )."_alternativas";
    $ruta = "datos/"."$name_archivo.txt";
    if(file_exists($ruta)){
      $archivo = fopen("datos/$name_archivo.txt", "r+");
      $consulta = "SELECT inicio_sec, destino_sec, km_sec, estimado_sec, treal_sec, fecha_sec FROM distancia_sec";
      $query = pg_query($dbconn, $consulta) or die('Error: ' . pg_last_error());
      //echo '<script language="javascript">confirm("Datos Guardados");</script>';
      while ($row = pg_fetch_array($query)) {
        $contenido = "
          INICIO = $row[inicio_sec]
          DESTINO = $row[destino_sec]
          KM = $row[km_sec]
          TIEMPO ESTIMADO DE VIAJE = $row[estimado_sec]
          TIEMPO REAL DE VIAJE = $row[treal_sec]
          FECHA = $row[fecha_sec]

        ";
        fwrite($archivo, $contenido);  
      }
    }
    else{
      $archivo = fopen($ruta, "w+");
      $consulta = "SELECT inicio_sec, destino_sec, km_sec, estimado_sec, treal_sec, fecha_sec FROM distancia_sec";
      $query = pg_query($dbconn, $consulta) or die('Error: ' . pg_last_error());
      //echo '<script language="javascript">confirm("Datos Guardados");</script>';
      while ($row = pg_fetch_array($query)) {
        $contenido = "
          INICIO = $row[inicio_sec]
          DESTINO = $row[destino_sec]
          KM = $row[km_sec]
          TIEMPO ESTIMADO DE VIAJE = $row[estimado_sec]
          TIEMPO REAL DE VIAJE = $row[treal_sec]
          FECHA = $row[fecha_sec]

        ";
        fwrite($archivo, $contenido);  
      }
    }
    
    
    fclose($archivo);
    pg_close($dbconn);
    echo '<script language="javascript">confirm("Rutas Alternativas Exportadas");</script>';
    echo "<script>";    
    echo "window.location.href ='matriz.php';";
    echo "</script>";
    
?>
