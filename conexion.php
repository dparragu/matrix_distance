<?php
 
// detalles de la conexion
$con = "host=localhost port=5432 dbname=project_distance user=postgres password=postgres";
 
// establecemos una conexion con el servidor postgresSQL
$dbconn = pg_connect($con)or die("Error en la Conexión: ".pg_last_error());
 
// Revisamos el estado de la conexion en caso de errores. 
if(!$dbconn) {
echo "Error: No se ha podido conectar a la base de datos\n";
}
 
// Close connection
//pg_close($dbconn);
 
?>