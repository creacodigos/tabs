<?php
 
// VARIABLEs
 
#####################
### BASE DE DATOS ###
#####################
 
define("BASE_BD", 'BASE_BD');
define("USER_BD", 'USER_BD');
define("PASS_BD", 'PASS_BD');
define("HOST_BD", 'HOST_BD');
define("MOTOR_BD", 'mysqli');
 
###############
### CHARSET ###
###############
 
define("CHARSET", 'utf-8');
define("CHARSET_NAME", 'utf8');
 
##############
### FECHAS ###
##############
 
define("TIMEZONE", 'Europe/London');
 
date_default_timezone_set(TIMEZONE);
 
define("TIEMPO_INICIO", microtime(true));
define("FECHA_ACTUAL", date("Y-m-d H:i:s"));
define("FECHA_HORA", FECHA_ACTUAL);
define("FECHA_COMPLETA", FECHA_ACTUAL);
define("FECHA", date("Y-m-d"));
define("HORA", date("H:i:s"));
define("FECHA_PASS", date("Y-m-d", strtotime(FECHA_ACTUAL." -6 month")));
 
################
### ARCHIVOS ###
################
 
$protocolo      = @$_SERVER['HTTPS'] == 'on' ? 'https' : 'http';   // Se extrae el protocolo (http o https)
$raiz           = $protocolo.'://'.$_SERVER['HTTP_HOST'];         // Se devuelve la URL completa
$archivo_actual = basename($_SERVER['PHP_SELF']);
$pagina_actual  = $_SERVER['SCRIPT_FILENAME'];
$pagina_actual  = str_replace($_SERVER['QUERY_STRING'],"",$pagina_actual);
$pagina_actual  = str_replace($_SERVER['DOCUMENT_ROOT'],"",$pagina_actual);
$pagina_actual  = str_replace($archivo_actual,'',$pagina_actual);
 
define("RAIZ", "$raiz");
 
if(substr($pagina_actual,0,1)!='/')
{
  $pagina_actual = '/'.$pagina_actual;
}


$baseHOST = explode(".",$_SERVER['HTTP_HOST']);
define("BASE", reset($baseHOST));
define("PAGINA_ACTUAL", $pagina_actual);
define("SCRIPT_ACTUAL", $archivo_actual);
//define("URL_ACTUAL", $_SERVER['REQUEST_URI']);
define("URL_ACTUAL", str_replace(PAGINA_ACTUAL,'',$_SERVER['REQUEST_URI']));
define("ARCHIVO_PADRE", $_SERVER['PHP_SELF']);
/* 

PAGINA_ACTUAL: web.com/
SCRIPT_ACTUAL: index.php
URL_ACTUAL: /web.com/datos?url
ARCHIVO_PADRE: /web.com/index.php
ARCHIVO_ACTUAL: url
*/
 
unset($protocolo,$raiz,$pagina_actual);
 
##################
### NAVEGACIÓN ###
##################
 
define("PAGINA_PRINCIPAL", './datos?seccion=datos_registrados');
define("PAGINA_PRINCIPAL_ADMIN", './admin');
define("PAGINA_LOGIN", './login');
 
if(isset($_GET['p']) AND !empty($_GET['p']))
	$PAGINA_SET = strip_tags($_GET['p']);
else
	$PAGINA_SET = 'index';
 
define("PAGINA_GET", $PAGINA_SET);
 
unset($PAGINA_GET);
 
if(isset($_GET['s']) AND !empty($_GET['s']))
	define("SECCION_GET", strip_tags($_GET['s']));
 
define("PAGINA", 'view/'.$PAGINA_SET.'.php');
$array_pagina = explode('/',PAGINA_GET);
 
 
###############
### USUARIO ###
###############
 
define("AGENTE", $_SERVER['HTTP_USER_AGENT']);
define("IP", $_SERVER['REMOTE_ADDR']);

$classOscuro = '';
