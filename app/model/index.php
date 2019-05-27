<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get("/", function(){
    echo 'Slim Framework';
});

$app->get("/hola/:nombre", function($nombre) use ($app){
    echo "Hola ".$nombre;
    // Todos
    var_dump($app->request->params());
    // Específicos
    var_dump($app->request->get());
    var_dump($app->request->post());
    var_dump($app->request->put());
    var_dump($app->request->delete());
});

$app->get("/opcional/(:uno(/:dos))",function($uno = null,$dos = null){
    // Parámetros opcionales
    echo "opcionales $uno $dos";
})->conditions(array(
    // condicional con expresiones regulares
    'uno' => '[\d]*',
    'dos' => '[\w]*'
));

// MiddleWare
function pruebaMiddle()
{
    echo 'Soy un MiddleWare';
}

$app->get("/pruebas/:uno/:dos",'pruebaMiddle',function($uno,$dos){
    // Parámetros obligatorios
    echo "Pruebas $uno $dos";
});

// Grupo de rutas
// CON use ($var) pasamos variables a usar dentro de las funciones

$app->group("/api",function() use ($app){
    $app->group("/ejemplo",function() use ($app){

        $app->get('/hola/:nombre',function($nombre){
            echo 'Hola '.$nombre;
        });
        $app->get('/dime-tu-apellido/:apellido',function($apellido){
            echo 'Tu apellido es '.$apellido;
        });

        // Redirecciones
        $app->get("/mandame-a-hola",function() use ($app){
            $app->redirect('./hola/Pedro');
        });

    });
});

// Redirecciones

$app->get("/mandame-a-hola",function() use ($app){

    $app->redirect('./hola/Pedro');
});


$app->run();