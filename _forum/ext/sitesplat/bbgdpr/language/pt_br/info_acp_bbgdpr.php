<?php

/**
 * @package BBgdpr for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ACP_BBGDPR_TITLE'         => 'BBgdpr',
	'ACP_BBGDPR_TITLE_EXPLAIN' => 'Ajuste e configure as regras do BBgdpr abaixo. Terá de aceitar as políticas com a sua própria conta antes de conseguir ajustar outras configurações que não as desta extensão.',
	'ACP_BBGDPR_SETTING_SAVED' => 'As configurações do BBgdpr foram guardadas com sucesso.',
	'SS_HELPER_NOTY'           => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',

	'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME'         => 'Manter o nome de usuário ao excluir a conta',
	'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME_EXPLAIN' => 'Defina como Não (No) para gerar aleatoriamente um nome de usuário anônimo que passará a substituir o anterior quando o usuário pretender apagar e remover a sua conta.',
	'SITESPLAT_BBGDPR_ACCEPT_OLD_USERS'             => 'Forçar o tela com as novas Políticas GDPR (Regulamento Geral sobre a Proteção de Dados) apenas para usuários atuais já existentes',
	'SITESPLAT_BBGDPR_ACCEPT_OLD_USERS_EXPLAIN'     => 'Não faz qualquer sentido aos novos usuários este tela do GDPR pois os mesmos já o aceitarão aquando da criação do seu novo registro em concordância. Defina como Não (No) para forçar as políticas GDPR a TODOS os usuários em absoluto sem exceção para sua aceitação.',
	'SITESPLAT_BBGDPR_REQUEST_DELETE'               => 'Método de exclusão',
	'SITESPLAT_BBGDPR_REQUEST_DELETE_EXPLAIN'       => 'Defina para Solicitar (Request) um pedido sempre que um usuário queira apagar/remover os seus dados ou conta, com isto os Administradores irão receber por MP tal notificação e tratarão do caso. Caso contrário se desativado e deixado para Pessoal (Self) os usuários estão aptos a poderem apagar pessoalmente e de imediato a sua conta/dados.',
	'REQUEST_DELETE'                                => 'Solicitar',
	'SELF_DELETE'                                   => 'Pessoal',

	'LOG_USER_REJECTED_PRIVACY' => '<strong>Rejeitou a nova política de privacidade.</strong><br>» Última data de aceitação: %s',
]);
