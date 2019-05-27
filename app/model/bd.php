<?php
// https://websitebeaver.com/php-pdo-vs-mysqli

##############################
### CONECTAR BASE DE DATOS ###
##############################
 
function conectar()
{    
    $dsn = 'mysql:host='.HOST_BD.';dbname='.BASE_BD.';charset='.CHARSET_NAME;
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];

    try {
        $conexion = new PDO($dsn, USER_BD, PASS_BD, $options);
        try {
            $conexion->query("SET SESSION sql_mode = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
        } catch (Exception $e) {
            error_log($e->getMessage());
            exit('[ERROR SET SESSION] -> '. $e->getMessage()); //something a user can understand
        }

    } catch (Exception $e) {
        error_log($e->getMessage());
        exit('[ERROR CONECTANDO] -> '. $e->getMessage()); //something a user can understand
    }
    
    return $conexion;
 
}