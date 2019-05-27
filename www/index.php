<?php
// INDEX 
require "../app/controller/index.php";
//require "./app/view/head.php";

// Defino los valores por defecto del POST si no existe y es vacío
if(empty($_POST))
{ 
    $_POST['id']      = '';
    $_POST['titulo']  = '';
    $_POST['artista'] = '';
    $_POST['texto']   = '';
    $_POST['acordes'] = '';
    $_POST['youtube'] = '';
    $_POST['ug']      = '';
    $_POST['idioma']  = 'español';
    $_POST['estilo']  =  'pop';
}

    if(isset($_POST['texto']) AND !empty($_POST['texto']))
	{
        if(isset($_POST['id']) AND !empty($_POST['id']))
            updatePartitura($_POST);
                else
                    insertPartitura($_POST);
    }

    if(isset($_GET['id']) AND !empty($_GET['id']))
    {
        $id     = strip_tags($_GET['id']);

        if(isset($_GET['borrar']) && $_GET['borrar'] == 1)
            deletePartitura($id); 
        else
            $_POST = selectPartituras($id);
    }

    if(isset($_GET['ver']) && $_GET['ver'] == 1)
    {
        $datosHTML = '<h2><strong>'.$_POST['artista'].'</strong> - '.$_POST['titulo'].'</h2>';
        $datosHTML .= '<h2><strong>'.$_POST['acordes'].'</strong></h2>';
        $datosHTML .= '<div>'.verAcordes($_POST['acordes']).'</div>';
        $datosHTML .= '<div><a href="'.$_POST['youtube'].'" title="'.$_POST['youtube'].'" target="_blank">'.$_POST['youtube'].'</a></div>';
        $datosHTML .= '<div><a href="'.$_POST['ug'].'" title="'.$_POST['ug'].'" target="_blank">'.$_POST['ug'].'</a></div>';
        $datosHTML .= '<pre>'.resaltarAcordes($_POST['texto']).'</pre>';
    }
    else
    {
        // Obtener multiple array clave -> valor
        $datos = selectPartituras();
        $datosHTML = '
    <table id="tablaDatos" class="sortable">
        <tr>
            <th></th>
            <th>Artista</th>
            <th>Título</th>
            <th class="sorttable_nosort"></th>
            <th class="sorttable_nosort"></th>
        </tr> 
                ';

        $n = 0;
        for ($i=0; $i < count($datos); $i++) {            
                   
            $datosHTML .= '
        <tr onclick="document.location=\'./?id='.$datos[$i]['id'].'&ver=1\'">        
            <td>'.++$n.'</td>
            <td><strong>'.$datos[$i]['artista'].'</strong></td>
            <td>'.$datos[$i]['titulo'].'</td>
            <td><a href="./?id='.$datos[$i]['id'].'#formulario">E</a></td>
            <td><a href="./?id='.$datos[$i]['id'].'&borrar=1" onclick="return confirm(\'Confirma que quieres borrar '.$datos[$i]['titulo'].'\')">B</a></td>
        </tr>
        ';
        }

        $datosHTML .= '
    </table>
        ';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- DESACTIVAR CACHÉ -->
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <!-- DESACTIVAR CACHÉ -->    
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, user-scalable=yes">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:100,300,400,700" rel="stylesheet">
    <link href="css/reset.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <?php
        if(detectarMovil()==1){
        echo '
    <link href="css/movil.css" rel="stylesheet">
        ';    
        $classOscuro = ' class="oscuro" ';    
    }
    ?>

    <script src="js/class.js"></script>
    <script src="js/sorttable.js"></script>

    <title>Partituras PDO demo</title>
</head>
<body <?php echo $classOscuro ?> >
    <header>
        <div>
            <a href="./">PARTITURAS</a>
            <div class="cuadroOscuro" onClick="changeClass('oscuro')"></div>
            <div class="cuadroClaro" onClick="removerClass()"></div>
        </div>
    </header>

    <section id="datosHTML">
<?php
    echo $datosHTML;
    if(isset($_GET['ver']) && $_GET['ver'] == 1) exit;
?>
    </section>
    
    <section id="formulario">
        <div>
            DATOS DE LA PARTITURAS
        </div>
        <form action="" method="post" name="partitura" autocomplete="on">
            <input type="hidden" name="id" value="<?php echo $id; ?>">		
            <br>
            <input type="text" name="artista" placeholder="artista" value="<?php echo $_POST['artista']; ?>">
            <br>
            <input type="text" name="titulo" placeholder="titulo" value="<?php echo $_POST['titulo']; ?>" autocomplete="on">
            <br>
            <input type="text" name="acordes" placeholder="acordes" value="<?php echo $_POST['acordes']; ?>">
            <br>
            <textarea name="texto"><?php echo $_POST['texto']; ?></textarea>
            <br>
            <input type="text" name="idioma" placeholder="idioma" value="<?php echo $_POST['idioma']; ?>" autocomplete="on">
            <br>
            <input type="text" name="estilo" placeholder="estilo" value="<?php echo $_POST['estilo']; ?>" autocomplete="on">
            <br>
            <input type="text" name="youtube" placeholder="youtube" value="<?php echo $_POST['youtube']; ?>">
            <br>
            <input type="text" name="ug" placeholder="Ultimate Guitar" value="<?php echo $_POST['ug']; ?>">
            <input type="submit">
        </form>
    </section>    
</body>
</html>