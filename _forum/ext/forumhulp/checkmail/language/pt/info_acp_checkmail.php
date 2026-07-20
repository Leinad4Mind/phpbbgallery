<?php

/**
 * @package Check mail for phpBB.
 * @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_CHECKMAIL'          => 'Verificar e-mail',
	'ACP_CHECKMAIL_SETTINGS' => 'Configurações de verificar e-mail',
	'ACP_CHECKMAIL_EXPLAIN'  => 'O verificar e-mail verifica endereços de e-mail para um domínio e registo mx válidos, relatório de comunicação para cada membro.<br />Verificar e-mail verifica periodicamente os endereços de e-mail dos seus membros.',
	'EMAIL_STATUS'           => 'Estado do e-mail',
	'CHECK_STATUS'           => 'Verificar',
	'CHECK_MAIL_ADDRESS'     => 'Verificar endereço de e-mail',
	'CHECKMAIL_USERS'        => 'Utilizadores verificados',
	'CHECKMAIL_TOTAL'        => 'Total de utilizadores',
	'EMAIL'                  => 'E-mail &lt;',
	'EXIST'                  => '&gt; existe!',
	'VALID'                  => '&gt; válido, mas não existe!',
	'NOT_VALID'              => '&gt; não válido e não existe!',
	'FH_HELPER_NOTICE'       => 'A aplicação ajudante forumhulp não existe!<br />Descarregue <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
	'CHECKMAIL_NOTICE'       => '<div class="phpinfo"><p class="entry">Esta extensão reside em %1$s » %2$s » %3$s.</p></div>',
]);

$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral dos endereços de e-mail dos utilizadores',
			'DESCRIPTION_2' => 'Verificação manual e periódica',
			'DESCRIPTION_3' => 'Relatório de comunicação',
			'DESCRIPTION_4' => 'Ordenação',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para phpBB 3.2'
		]
	]
]);
