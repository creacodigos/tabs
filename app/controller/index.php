<?php
// Lanzador
 
require_once "../app/model/config.php";
require_once "../app/model/variables.php";
require_once "../app/model/pdo.php";
require_once "../app/model/funciones.php";

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
header('Content-Type: text/html; charset='.CHARSET);