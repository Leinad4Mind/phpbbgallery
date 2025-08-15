<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_BBCOMPRESS'				            => 'BBcompress',
	'ACP_BBCOMPRESS_TITLE'			            => 'BBcompress',
	'ACP_SETTINGS'					            => 'Configurações',

	'BBCOMPRESS_NOTICE'						    => '<div class="phpinfo"><p>As configurações desta extensão encontram-se na aba <strong>Extensões</strong>.</p></div>',
	
	'ACP_BBCOMPRESS_SETTINGS_EXPLAIN'	        => 'Configuração de BBcompress. Selecciona, se queres optimizar imagens em anexo nas mensagens, mensagens privadas, e **avatares (**<i>Suporte para avatares pronto. Apenas à espera dos core.events da versão phpBB 3.1.9</i>). Escolhe da lista de drivers fornecida, o método de compressão. Cada driver providencia resultados diferentes e/ou tem configurações adicionais e restrições. <br /><br /><strong>O BBcompress já optimizou e poupou-te: %s</strong>.',

	'ACP_OPTIMIZER_GENERAL_OPTIONS'				=> 'Configurações Gerais',
	'ACP_BBCOMPRESS_ALLOWED_POSTS'				=> 'Permite optimizar novas imagens nas mensagens',
	'ACP_BBCOMPRESS_ALLOWED_POSTS_EXPLAIN'		=> 'Irá permitir optimizar todas as novas imagens enviadas como anexo nas mensagens e MPs.',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS'			=> 'Permite optimizar novos avatares',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS_EXPLAIN'	=> 'Irá permitir optimizar todos os novos avatares enviados.',

	'ACP_OPTIMIZER_DRIVER'			            => 'Driver de Optimização',
	'ACP_OPTIMIZER_DRIVER_EXPLAIN'	            => 'Selecciona da lista de drivers disponíveis. A driver seleccionada irá optimizar as imagens antes de estas serem armazenadas. Opções adicionais poderão surgir para a driver seleccionada, presta atenção às informações.',

	'ACP_TINIFY_API_KEY'			            => 'Chave API do TinyPNG/JPG',
	'ACP_TINIFY_API_KEY_EXPLAIN'	            => 'Por favor, coloca a chave API para a extensão começar a comprimir imagens. Visita a <a href="https://tinypng.com/developers" target="_blank">Secção de Desenvolvedores do TinyPNG/JPG</a> para obter uma chave API gratuita.',

	'ACP_BBCOMPRESS_SETTING_SAVED'	            => 'Configurações do BBcompress guardadas',
	'ACP_TINIFY_API_KEY_INVALID'	            => 'Chave API do TinyPNG/JPG está guardada, mas o BBcompress não foi capaz de confirmar a chave API, ou excedeste o limite da tua conta. Por favor, tenta novamente com uma chave API válida, caso não tenhas mesmo excedido. Se tens a certeza de que a tua chave API está correcta e o limite da tua conta não foi atingido, poderá existir um problema na rede. Tente novamente mais tarde.',
));
