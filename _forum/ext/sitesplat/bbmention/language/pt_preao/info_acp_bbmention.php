<?php

/**
 * @package BBembed for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_BBMENTION'    => 'BBmention',
	'SS_HELPER_NOTY'   => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBMENTION_NOTICE' => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. Comece a utilizá-la e dar uso a partir das respostas rápidas ou a enviar uma publicação, para isto basta apenas começar e iniciar com uma simples <strong>&#64;</strong> seguida da primeira letra e terá em modo de auto-sugestão ou autocompletar na perfeição os nomes da lista de utilizadores. <br />Pode ainda efectuar marcações manualmente sem as sugestões, bastando apenas digitar o nome e a extensão fará com que o utilizador mesmo que não se encontre a ler esse tópico seja notificado com este menção referida ao mesmo.</p></div>',
]);
