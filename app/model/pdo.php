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

function selectPartituras($id = 0)
{
    $array    = null;
    $conexion = conectar();

    if($id > 0)
    {
        $query = $conexion->prepare('SELECT * FROM partituras WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
    }
        else
        $query = $conexion->prepare("SELECT * FROM partituras");
        //$query = $conexion->prepare("SELECT * FROM partituras ORDER BY artista ASC, id DESC");

        $query->execute();    
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if ($id > 0) $array = $array[0];

            if(!$array) echo 'No hay filas';           
        
    $query    = null;
    $conexion = null;

    return $array;

}

function updatePartitura($datos)
{
    $conexion = conectar();
    $conexion->beginTransaction();

    $titulo   = $_POST['titulo'];
    $artista  = $_POST['artista'];
    $texto    = $_POST['texto'];
    $acordes  = $_POST['acordes'];
    $youtube  = $_POST['youtube'];
    $ug       = $_POST['ug'];
    $idioma   = $_POST['idioma'];
    $estilo   = $_POST['estilo'];
    $id       = $_POST['id'];

        /* Ejecutar una sentencia preparada vinculando varialbes de PHP */
        try {
        $query = $conexion->prepare('UPDATE partituras SET 
                                            titulo  = :titulo,
                                            artista = :artista, 
                                            acordes = :acordes, 
                                            texto   = :texto,
                                            youtube = :youtube,
                                            ug      = :ug,
                                            idioma  = :idioma,
                                            estilo  = :estilo 
                                        WHERE id    = :id');
        // bindValue para no permitir modificaciones posteriores del valor                                
        $query->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $query->bindValue(':artista', $artista, PDO::PARAM_STR);
        $query->bindValue(':acordes', $acordes, PDO::PARAM_STR);
        $query->bindValue(':texto', $texto, PDO::PARAM_STR);
        $query->bindValue(':youtube', $youtube, PDO::PARAM_STR);
        $query->bindValue(':ug', $ug, PDO::PARAM_STR);
        $query->bindValue(':idioma', $idioma, PDO::PARAM_STR);
        $query->bindValue(':estilo', $estilo, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $registros = $query->rowCount(); // Registros afectados

        $conexion->commit();
        $query    = null;

        } catch (Exception $e) {

            $conexion->rollback();
            error_log($e->getMessage());
            exit('[ERROR UPDATE] -> '. $e->getMessage()); //something a user can understand
        }

    $conexion = null;
    header('Location: ./');
    exit;

}

function insertPartitura($datos)
{
    $conexion = conectar();
    $conexion->beginTransaction();

    $titulo  = $_POST['titulo'];
    $artista = $_POST['artista'];
    $texto   = $_POST['texto'];
    $acordes = $_POST['acordes'];
    $youtube = $_POST['youtube'];
    $ug      = $_POST['ug'];
    $idioma  = $_POST['idioma'];
    $estilo  = $_POST['estilo'];

        try {

            $query = $conexion->prepare('INSERT INTO partituras 
                                                (titulo,artista,acordes,texto,youtube,ug,idioma,estilo) 
                                            VALUES 
                                                (:titulo,:artista,:acordes,:texto,:youtube,:ug,:idioma,:estilo)');

            $query->bindValue(':titulo', $titulo, PDO::PARAM_STR);
            $query->bindValue(':artista', $artista, PDO::PARAM_STR);
            $query->bindValue(':acordes', $acordes, PDO::PARAM_STR);
            $query->bindValue(':texto', $texto, PDO::PARAM_STR);
            $query->bindValue(':youtube', $youtube, PDO::PARAM_STR);
            $query->bindValue(':ug', $ug, PDO::PARAM_STR);
            $query->bindValue(':idioma', $idioma, PDO::PARAM_STR);
            $query->bindValue(':estilo', $estilo, PDO::PARAM_STR);
            $query->execute();
            $lastid = $conexion->lastInsertId(); // ID del registro insertado

            $conexion->commit();
            $query    = null;

        } catch (Exception $e) {

            $conexion->rollback();
            error_log($e->getMessage());
            exit('[ERROR INSERT] -> '. $e->getMessage()); //something a user can understand
        }

    $conexion = null;
    header('Location: ./');
    exit;

}


function deletePartitura($id = 0)
{
    $conexion = conectar();
    $conexion->beginTransaction();

        if($id > 0)
        {
            try {
                $query = $conexion->prepare('DELETE FROM partituras WHERE id = :id');
                $query->bindValue(':id', $id, PDO::PARAM_INT);
                $query->execute();
                $registros = $query->rowCount(); // Registros afectados
                
                $conexion->commit();
                $query    = null;

            } catch (Exception $e) {

                $conexion->rollback();
                error_log($e->getMessage());
                exit('[ERROR DELETE] -> '. $e->getMessage()); //something a user can understand
            }
        }
    echo 'BORRANDO '.$id;

    $conexion = null;
    header('Location: ./');
    exit;

}