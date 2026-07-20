<?php

/**
 * BBlightbox
 * @copyright (c) 2017 sitesplat.com All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_BBLIGHTBOX'               => 'BBlightbox',
	'SS_HELPER_NOTY'               => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBLIGHTBOX_NOTICE'            => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'ACP_BBLIGHTBOX_SETTING_SAVED' => 'As configurações da BBlightbox foram guardadas',
	'ALL_ATTACHMENTS'              => 'Todos os Anexos',
	'ALL_ATTACHMENTS_EXPLAIN'      => 'Ocultar ou mostrar links diretos no final de todos os Anexos em publicações (Isto oculta a indicação de quantidade de transferências (downloads) e o tamanho do ficheiro também)',
	'REASSIGN_THUMBNAILS'          => 'Reatribuir miniaturas (thumbnails)',
	'REASSIGN_THUMBNAILS_EXPLAIN'  => 'Regenerar e recriar todas as miniaturas (thumbnails).',
]);

// Description of Upload extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota de extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Até 4 diferentes lightboxes',
			'DESCRIPTION_2' => 'Apresentação de diapositivos (Slideshow)',
			'DESCRIPTION_3' => 'Legendas',
		],
		'note' => [
			'NOTICE_1' => 'pronta a atuar sobre as principais secções gerais como UCP, MCP, Publicação/Mensagem, leitura de tópicos (viewtopic) etc.',
			'NOTICE_2' => 'phpBB 3.2 pronta e compatível.',
		]
	]
]);
