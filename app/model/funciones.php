<?php
 
// Funciones
  
function crear_enlaces($texto)
{
	$url	= '@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
	$texto	= preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $texto);
	return $texto;
}
 
function mostrar_texto($texto)
{
	$texto = crear_enlaces($texto);
	$texto = nl2br($texto);
	return $texto;
}
 
function resaltarAcordes($texto)
{
    $patron      = '/(A#m|A#7|A#m7|A#|B#m|B#7|B#m7|B#|C#m|C#7|C#m7|C#|D#m|D#7|D#m7|D#|E#m|E#7|E#m7|E#|F#m|F#7|F#m7|F#|G#m|G#7|G#m7|G#|Am|A7|Am7|A|Bm|B7|Bm7|B|Cm|C7|Cm7|C|Dm|D7|Dm7|D|Em|E7|Em7|E|Fm|F7|Fm7|F|Gm|G7|Gm7|G)/';
    $sustitucion = '<strong>$1</strong>';
    $texto       = preg_replace($patron, $sustitucion, $texto);
    return $texto;
}


function verAcordes($texto)
{
	$patron      = '/(A#m|A#7|A#m7|A#|B#m|B#7|B#m7|B#|C#m|C#7|C#m7|C#|D#m|D#7|D#m7|D#|E#m|E#7|E#m7|E#|F#m|F#7|F#m7|F#|G#m|G#7|G#m7|G#|Am|A7|Am7|A|Bm|B7|Bm7|B|Cm|C7|Cm7|C|Dm|D7|Dm7|D|Em|E7|Em7|E|Fm|F7|Fm7|F|Gm|G7|Gm7|G)/';
	
	preg_match_all($patron, $texto, $resultado);
	$texto = $resultado[1];
	$texto = array_values(array_unique($texto));
	//$texto = asort($texto);

	$textos = '';
		foreach($texto as $acorde) { 
			$textos .= $acorde.' '; 
		}
	 
	$sustitucion = '<img src="img/acordes/$1.png" height="150">';
    $texto       = preg_replace($patron, $sustitucion, $textos);
    return $texto;
}

function detectarMovil()
{
	$dispositivoMovil = 0;

	$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
	$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
	$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
	$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
	$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

	if( $iPod || $iPhone || $iPad || $Android || $webOS){
		$dispositivoMovil = 1;
	}

	return $dispositivoMovil;
}