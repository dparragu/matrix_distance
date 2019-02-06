<?php
require("conexion.php");
    

    $i = 0;
    $name_archivo = date ( "d_m_Y-H_i_s" , time () );
    $ruta = "datos/"."$name_archivo.txt";
    if(file_exists($ruta)){
      $archivo = fopen("datos/$name_archivo.txt", "r+");
      $consulta = "SELECT inicio, destino, km, estimado, treal, fecha FROM distancia";
      $query = pg_query($dbconn, $consulta) or die('Error: ' . pg_last_error());
      //echo '<script language="javascript">confirm("Datos Guardados");</script>';
      while ($row = pg_fetch_array($query)) {
        $contenido = "
          INICIO = $row[inicio]
          DESTINO = $row[destino]
          KM = $row[km]
          TIEMPO ESTIMADO DE VIAJE = $row[estimado]
          TIEMPO REAL DE VIAJE = $row[treal]
          FECHA = $row[fecha]

        ";
        fwrite($archivo, $contenido);  
      }
    }
    else{
      $archivo = fopen($ruta, "w+");
      $consulta = "SELECT inicio, destino, km, estimado, treal, fecha FROM distancia";
      $query = pg_query($dbconn, $consulta) or die('Error: ' . pg_last_error());
      //echo '<script language="javascript">confirm("Datos Guardados");</script>';
      while ($row = pg_fetch_array($query)) {
        $contenido = "
          INICIO = $row[inicio]
          DESTINO = $row[destino]
          KM = $row[km]
          TIEMPO ESTIMADO DE VIAJE = $row[estimado]
          TIEMPO REAL DE VIAJE = $row[treal]
          FECHA = $row[fecha]

        ";
        fwrite($archivo, $contenido);  
      }
    }
    
    
    fclose($archivo);
    pg_close($dbconn);
    echo '<script language="javascript">confirm("Datos Exportados");</script>';
    echo "<script>";    
    echo "window.location.href ='matriz.php';";
    echo "</script>";
    
?>
