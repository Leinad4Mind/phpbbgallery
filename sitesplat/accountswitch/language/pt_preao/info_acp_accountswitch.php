<?php

/**
 * @package BBSwitch for phpBB.
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
	'ACCOUNTSWITCH_OK'              => 'O BBswitch está pronto a ser utilizado',
	'ACCOUNTSWITCH_REUSE'           => 'No entanto, o BBswitch <strong>não</strong> está ainda pronto para ser utilizado devido à configuração de reutilização de e-mail estar definida como <strong>NÃO</strong>. Define como <strong>sim</strong> a opção <strong>Permitir a reutilização do e-mail</strong> em <strong>ACP &#187; Configuração do Fórum &#187; Configurações de registo de utilizador</strong>',
	'LOG_ACCOUNTSWITCH'             => '<strong>Troca de Conta</strong><br />» Trocou para a conta %s',
	'ACCOUNTSWITCH_LINKED_ACCOUNTS' => 'Contas ligadas',
	'SS_HELPER_NOTY'                => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="http://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'ACCOUNTSWITCH_NOTICE'          => '<div class="phpinfo"><p>Esta extensão não possui definições configuráveis.<br />%1$s.<br />Lembra-te de definir a ativação para "<strong>Pelo utilizador (verificação de e-mail)</strong>" de forma a prevenir qualquer pirataria na conta!</p></div>',
]);
