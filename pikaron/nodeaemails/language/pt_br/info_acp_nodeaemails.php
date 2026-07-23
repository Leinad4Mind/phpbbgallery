<?php

/**
 * No DEA Emails. An extension for the phpBB Forum Software package.
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, [
	'ACP_NO_DEA_EMAILS'                 => 'No DEA Emails',
	'ACP_NO_DEA_EMAILS_EXPLAIN'         => 'Esta extensão impede o registro de um usuário no fórum quando é utilizada uma conta de e-mail descartável ou temporária <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.',
	'ACP_NO_DEA_EMAILS_WARNING_CRON'    => 'Nesta seção são obtidos os dados de status do CRON.<br>- A opção para definir o intervalo de tempo de execução do CRON está habilitada.<br>É apresentada uma lista dos domínios de e-mail do tipo DEA com os quais serão filtradas, daqui para frente, as contas de e-mail dos usuários do fórum.',
	'ACP_NO_DEA_EMAILS_WARNING_LOCAL'   => 'Nesta seção você pode gerenciar (adicionar/remover) localmente domínios de contas de e-mail descartáveis ou temporárias <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.<br><br>Tenha atenção especial, pois se incluir um domínio válido, você impedirá os usuários de usá-lo para se registrarem.<br><i>Exemplo: Se você registrar o domínio "gmail.com", vai deixar todos os seus usuários sem poder usar contas de e-mail do Google.</i>',
	'ACP_NO_DEA_EMAILS_WARNING_USERS'   => 'Esta seção reúne informações sobre todos os usuários do fórum que têm um e-mail descartável <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a> associado à sua conta.<br><br>Você pode <strong>EXCLUIR COMPLETAMENTE</strong> os usuários selecionados.<br>(incluindo todas as suas mensagens publicadas)<br><br><strong>ATENÇÃO:<br>Esta ação NÃO É REVERSÍVEL, tenha cuidado ao usar esta opção se o seu fórum estiver em produção.</strong>',
	'ACP_NO_DEA_EMAILS_SETTINGS'        => 'Gerenciamento de CRON e Domínios de E-mail DEA Externos',
	'ACP_NO_DEA_EMAILS_LOCALS'          => 'Gerenciamento Local de Domínios de E-mail DEA',
	'ACP_NO_DEA_EMAILS_USERS'           => 'Usuários com Contas de E-mail DEA',
	'ACP_SUBMIT_DELETE'                 => 'Aplicar Alterações',
	'LOG_CONFIG_CONFIGURATION'          => '<strong>Configuração da Extensão "No DEA Emails" Atualizada</strong>',
	'LOG_CONFIG_USERS'                  => '<strong>Usuários EXCLUÍDOS por "No DEA Emails"</strong>',
	'LOG_FORCE_CHG_EMAIL'               => '<strong>No DEA Emails</strong><br>» %s',
	'LOG_FORCE_USERS_CHG_EMAIL'         => '<strong>Usuários MARCADOS para FORÇAR ALTERAÇÃO de E-mail</strong>',
	'LOG_FORCE_USERS_NO_CHG_EMAIL'      => '<strong>Usuários DESMARCADOS para FORÇAR ALTERAÇÃO de E-mail</strong>',
	'LOG_FORCE_USER_CHG_EMAIL'          => 'Usuário MARCADO para FORÇAR ALTERAÇÃO de E-mail',
	'L_NO_DEA_EMAILS_DELAY'             => 'Intervalo para execução do CRON',
	'L_NO_DEA_EMAILS_DELAY_EXPLAIN'     => '(Mínimo: 300 segundos, Máximo: 86400 segundos = 1 dia)',
	'L_DEA_DELAY'                       => 'Segundos',
	'L_DEA_DELAY_MIN'                   => 'Minutos',
	'L_NO_DEA_EMAILS_VERSION'           => 'Versão da Extensão: ',
	'L_NO_DEA_EMAILS_CONFIG'            => 'Opções de Configuração do CRON',
	'L_NO_DEA_EMAILS_TEX'               => 'Domínios de E-mail "DEA" coletados através do CRON',
	'L_NO_DEA_EMAILS_TEX_LOCAL'         => 'Domínios de E-mail "DEA" coletados localmente',
	'L_NO_DEA_EMAILS_COUNTER'           => 'Execuções do CRON',
	'L_NO_DEA_EMAILS_TIMES'             => 'Desde a instalação da extensão, o CRON já foi executado <strong>%s</strong> vezes.',
	'L_NO_DEA_EMAILS_DATE'              => 'Última execução do CRON',
	'L_NO_DEA_EMAILS_USERS'             => 'Gerenciamento de Usuários com Contas de E-mail DEA',
	'L_NO_DEA_EMAILS_TOT_USERS'         => 'Total de Usuários Registrados',
	'L_NO_DEA_EMAILS_TOT_USERS_EXPLAIN' => 'Incluindo bots e usuários inativos.',
	'L_NO_DEA_EMAILS_DEA_USERS'         => 'Total de Usuários com Contas de E-mail DEA',
	'L_NO_DEA_EMAILS_DOMAIN'            => 'Domínio de E-mail Descartável',
	'L_NO_DEA_EMAILS_PLACE'             => 'Insira um Domínio de E-mail Descartável',
	'L_NO_DEA_EMAILS_ACTION'            => 'Ação',
	'L_NO_DEA_EMAILS_SAVE'              => 'Salvar',
	'L_NO_DEA_EMAILS_DEL'               => 'Excluir',
	'L_NO_DEA_EMAILS_DOM_SAVE'          => 'O Domínio de E-mail DEA foi SALVO corretamente: <strong>((%s))</strong>',
	'L_NO_DEA_EMAILS_DOM_DEL'           => 'O Domínio de E-mail DEA foi EXCLUÍDO corretamente: <strong>((%s))</strong>',
	'L_NO_DEA_EMAILS_DOM_VALID'         => 'O Domínio de E-mail DEA: <strong>((%s))</strong> não é válido.',
	'L_NO_DEA_EMAILS_DOM_LOCATE'        => 'O Domínio de E-mail DEA não foi encontrado: <strong>((%s))</strong>.',
	'L_NO_DEA_EMAILS_CANNOT_FOUNDER'    => 'Não é permitido excluir as contas de fundador.<br><br>O usuário <strong>%s</strong> não pode ser excluído.',
	'L_NO_DEA_EMAILS_CANNOT_YOURSELF'   => 'Você não pode excluir sua própria conta.',
	'L_NO_DEA_EMAILS_DEL_USERS'         => 'Ferramentas Básicas',
	'L_NO_DEA_EMAILS_DEL_USERS_EXPLAIN' => 'Observe que a exclusão de um usuário é definitiva e não pode ser recuperada. As mensagens privadas enviadas pelo usuário que ainda não tenham sido lidas serão excluídas e deixarão de estar disponíveis para os seus destinatários.',
	'L_NO_DEA_EMAILS_FORCE_CHG_EMAIL'   => 'Forçar alteração de "E-mail"',
	'L_NO_DEA_EMAILS_N_FORCE_CHG_EMAIL' => 'NÃO Forçar alteração de "E-mail"',
	'L_NO_DEA_EMAILS_SEND_PM'           => 'Enviar Mensagem Privada',
	'L_NO_DEA_EMAILS_RETAIN_POSTS'      => 'EXCLUIR USUÁRIO e Manter Suas Mensagens',
	'L_NO_DEA_EMAILS_REMOVE_POSTS'      => 'EXCLUIR USUÁRIO e Excluir Suas Mensagens',
	'L_NO_DEA_EMAILS_NEED_ACTION'       => 'Você deve selecionar uma "Ferramenta Básica".',
	'L_NO_DEA_EMAILS_NO_USERS'          => 'Nenhum Usuário selecionado',
	'L_NO_DEA_EMAILS_PERCENTAGE'        => '<i>(%s &#37; do Total de Usuários Registrados)</i>',
]);
