<?php
// http://php.net/manual/es/class.mysqli.php

##############################
### CONECTAR BASE DE DATOS ###
##############################
 
function conectar()
{   

		// Create connection
		$conexion = new mysqli(HOST_BD, USER_BD, PASS_BD, BASE_BD);

		// Check connection
		if ($conexion->connect_error) {
			exit('[ERROR CONECTANDO] -> ' . $conexion->connect_error);
		} 

		if(!$conexion->set_charset(CHARSET_NAME))
			exit('[ERROR SET CHARSET] -> '.$conexion->error);
		// IMPORTANTE CHARSET_NAME UTF8 No UTF-8

		if(!$conexion->query("SET SESSION sql_mode = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'"))
			exit('[ERROR SET SESSION] -> '.$conexion->error);
		// EVITA ERROR Incorrect integer value: '' for column... O EN BLANCO sql_mode en /etc/my.cnf (que no responde)


	return $conexion;
 
}

function selectPartituras($id = 0)
{
    $array    = null;
    $conexion = conectar();

    if($id > 0)
    {
        $query = $conexion->prepare('SELECT * FROM partituras WHERE id = ?');
		$query->bind_param("i", $id);
    }
        else
            $query = $conexion->prepare("SELECT * FROM partituras ORDER BY artista ASC, id DESC");

        $query->execute();

		$array = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        
        if ($id > 0) $array = $array[0];

            if(!$array) echo 'No hay filas';           

    $query    = null;
	$conexion->close();

    return $array;

}

function updatePartitura($datos)
{
    $conexion = conectar();

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
		
			$conexion->autocommit(FALSE); //turn on transactions
			$query = $conexion->prepare('UPDATE partituras SET 
												titulo  = ?,
												artista = ?, 
												acordes = ?, 
												texto   = ?,
												youtube = ?,
												ug      = ?,
												idioma  = ?,
												estilo  = ? 
											WHERE id    = ?');

			$query->bind_param('ssssssssi', $titulo, $artista, $acordes, $texto, $youtube, $ug, $idioma, $estilo, $id);
			$query->execute();
			$registros = $query->affected_rows; // Registros afectados

			$conexion->autocommit(TRUE);
			$query    = null;

        } catch (Exception $e) {

            $conexion->rollback();
            error_log($e->getMessage());
            exit('[ERROR UPDATE] -> '. $e->getMessage()); //something a user can understand
        }

	$conexion->close();

    return $registros;
}

function insertPartitura($datos)
{
    $conexion = conectar();

    $titulo  = $_POST['titulo'];
    $artista = $_POST['artista'];
    $texto   = $_POST['texto'];
    $acordes = $_POST['acordes'];
    $youtube = $_POST['youtube'];
    $ug      = $_POST['ug'];
    $idioma  = $_POST['idioma'];
    $estilo  = $_POST['estilo'];

        try {

			$conexion->autocommit(FALSE); //turn on transactions
            $query = $conexion->prepare('INSERT INTO partituras 
                                                (titulo,artista,acordes,texto,youtube,ug,idioma,estilo) 
                                            VALUES 
                                                (?,?,?,?,?,?,?,?)');

$query->bind_param('ssssssss', $titulo, $artista, $acordes, $texto, $youtube, $ug, $idioma, $estilo);
            $query->execute();
            $lastid = $conexion->insert_id; // ID del registro insertado

			$conexion->autocommit(TRUE);
            $query    = null;

        } catch (Exception $e) {

            $conexion->rollback();
            error_log($e->getMessage());
            exit('[ERROR INSERT] -> '. $e->getMessage()); //something a user can understand
        }

	$conexion->close();

    return $lastid;
}


function deletePartitura($id = 0)
{
    $conexion = conectar();

        if($id > 0)
        {
            try {
				$conexion->autocommit(FALSE); //turn on transactions
                $query = $conexion->prepare('DELETE FROM partituras WHERE id = ?');
                $query->bind_param('i', $id);
                $query->execute();
                $registros = $query->affected_rows; // Registros afectados
                
				$conexion->autocommit(TRUE);
                $query    = null;

            } catch (Exception $e) {

                $conexion->rollback();
                error_log($e->getMessage());
                exit('[ERROR DELETE] -> '. $e->getMessage()); //something a user can understand
            }
        }
    echo 'BORRANDO '.$id;

	$conexion->close();

    return $registros;

}