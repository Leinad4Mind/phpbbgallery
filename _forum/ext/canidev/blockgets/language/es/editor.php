<?php
/** 
* editor.php [Spanish [Es]]
*
* @package language cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Local Variables
$lang = array_merge($lang, array(
	'sceditor'			=> array(
		'Bold'			=> 'Negrita',
		'Italic'		=> 'Cursiva',
		'Underline'		=> 'Subrayar',
		'Strikethrough'	=> 'Tachar',
		'Subscript'		=> 'Subíndice',
		'Superscript'	=> 'Superíndice',
		'Align left'	=> 'Alinear a la Izquierda',
		'Center'		=> 'Centrar',
		'Align right'	=> 'Alinear a la Derecha',
		'Justify'		=> 'Justificar',
		'Font Name'		=> 'Tipo de Letra',
		'Font Size'		=> 'Tamaño de Letra',
		'Font Color'	=> 'Color de Fuente',
		'Remove Formatting'	=> 'Quitar Formatos',
		'Code:'		=> 'Código:',
		'Cut'		=> 'Cortar',
		'Your browser does not allow the cut command. Please use the keyboard shortcut Ctrl/Cmd-X'	=> 'Su navegador no acepta el comando cortar. Por favor, use la combinación Ctrl/Cmd-X',
		'Copy'		=> 'Copiar',
		'Your browser does not allow the copy command. Please use the keyboard shortcut Ctrl/Cmd-C'	=> 'Su navegador no acepta el comando copiar. Por favor, use la combinación Ctrl/Cmd-C',
		'Paste'		=> 'Pegar',
		'Your browser does not allow the paste command. Please use the keyboard shortcut Ctrl/Cmd-V'	=> 'Su navegador no acepta el comando pegar. Por favor, use la combinación Ctrl/Cmd-V',
		'Paste your text inside the following box:'	=> 'Pega el texto dentro del siguiente recuadro',
		'Paste Text'		=> 'Pegar Texto',
		'Bullet list'		=> 'Lista de Viñetas',
		'Numbered list'		=> 'Lista Numerada',
		'Undo'				=> 'Deshacer',
		'Redo'				=> 'Rehacer',
		'Rows:'				=> 'Filas',
		'Cols:'				=> 'Columnas',
		'Insert a table'	=> 'Insertar una Tabla',
		'Insert a horizontal rule'	=> 'Insertar una Regla Horizontal',
		'Code'					=> 'Código',
		'Width (optional):'		=> 'Ancho (Opcional)',
		'Height (optional):'	=> 'Altura (Opcional)',
		'Insert an image'		=> 'Insertar una Imagen',
		'E-mail:'				=> 'E-mail',
		'Insert an email'		=> 'Insertar un Email',
		'URL:'					=> 'URL',
		'Insert a link'			=> 'Insertar un Vínculo',
		'Unlink'				=> 'Quitar Vínculo',
		'More'					=> 'Más',
		'Insert an emoticon'	=> 'Insertar un emoticono',
		'Video URL:'			=> 'URL del Video',
		'Insert'				=> 'Insertar',
		'Insert a YouTube video'	=> 'Insertar un video de YouTube',
		'Insert current date'		=> 'Insertar fecha actual',
		'Insert current time'		=> 'Insertar hora actual',
		'Print'						=> 'Imprimir',
		'View source'				=> 'Ver Código',
		'Description (optional):'	=> 'Descripción (Opcional):',
		'Enter the image URL:'		=> 'Ingresar la URL de la imagen:',
		'Enter the e-mail address:'	=> 'Ingresar el correo electrónico:',
		'Enter the displayed text:'	=> 'Ingresar el texto mostrado:',
		'Enter URL:'				=> 'Ingresar URL:',
		'Enter the YouTube video URL or ID:'	=> 'Ingresar URL o ID de YouTube',
		'Insert a Quote'		=> 'Insertar Cita',
		'Insert HTML Code'		=> 'Insertar código HTML',
		'Invalid YouTube video'	=> 'Video de YouTube Inválido',

		'dateFormat'	=> 'day-month-year',
		
		// Font Sizes
		'Huge'		=> 'Enorme',
		'Large'		=> 'Grande',
		'Small'		=> 'Pequeña',
		'Tiny'		=> 'Diminuta',
	)
));
