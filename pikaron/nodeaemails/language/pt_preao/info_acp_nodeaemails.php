<?php

/**
 * No DEA Emails. An extension for the phpBB Forum Software package.
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'ACP_NO_DEA_EMAILS_EXPLAIN'         => 'Esta extensão impede o registo de um utilizador no fórum quando é utilizada uma conta de e-mail descartável ou temporária <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.',
	'ACP_NO_DEA_EMAILS_WARNING_CRON'    => 'Nesta secção são obtidos os dados de estado do CRON.<br>- A opção para definir o intervalo de tempo de execução do CRON está activada.<br>É apresentada uma lista dos domínios de e-mail do tipo DEA com os quais serão filtradas, daqui para a frente, as contas de e-mail dos utilizadores do fórum.',
	'ACP_NO_DEA_EMAILS_WARNING_LOCAL'   => 'Nesta secção podes gerir (adicionar/remover) localmente domínios de contas de e-mail descartáveis ou temporárias <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.<br><br>Deves ter especial atenção, pois se incluíres um domínio válido, impedirás os utilizadores de o usar para se registarem.<br><i>Exemplo: Se registares o domínio "gmail.com", vais deixar todos os teus utilizadores sem poder usar contas de e-mail do Google.</i>',
	'ACP_NO_DEA_EMAILS_WARNING_USERS'   => 'Esta secção reúne informação sobre todos os utilizadores do fórum que têm um e-mail descartável <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a> associado à sua conta.<br><br>Podes <strong>ELIMINAR COMPLETAMENTE</strong> os utilizadores seleccionados.<br>(incluindo todas as suas mensagens publicadas)<br><br><strong>ATENÇÃO:<br>Esta acção NÃO É REVERSÍVEL, tem cuidado ao usar esta opção se o teu fórum estiver em produção.</strong>',
	'ACP_NO_DEA_EMAILS_SETTINGS'        => 'Gestão de CRON e Domínios de E-mail DEA Externos',
	'ACP_NO_DEA_EMAILS_LOCALS'          => 'Gestão Local de Domínios de E-mail DEA',
	'ACP_NO_DEA_EMAILS_USERS'           => 'Utilizadores com Contas de E-mail DEA',
	'ACP_SUBMIT_DELETE'                 => 'Aplicar Alterações',
	'LOG_CONFIG_CONFIGURATION'          => '<strong>Configuração da Extensão "No DEA Emails" Actualizada</strong>',
	'LOG_CONFIG_USERS'                  => '<strong>Utilizadores ELIMINADOS por "No DEA Emails"</strong>',
	'LOG_FORCE_CHG_EMAIL'               => '<strong>No DEA Emails</strong><br>» %s',
	'LOG_FORCE_USERS_CHG_EMAIL'         => '<strong>Utilizadores MARCADOS para FORÇAR ALTERAÇÃO de E-mail</strong>',
	'LOG_FORCE_USERS_NO_CHG_EMAIL'      => '<strong>Utilizadores DESMARCADOS para FORÇAR ALTERAÇÃO de E-mail</strong>',
	'LOG_FORCE_USER_CHG_EMAIL'          => 'Utilizador MARCADO para FORÇAR ALTERAÇÃO de E-mail',
	'L_NO_DEA_EMAILS_DELAY'             => 'Intervalo para execução do CRON',
	'L_NO_DEA_EMAILS_DELAY_EXPLAIN'     => '(Mínimo: 300 segundos, Máximo: 86400 segundos = 1 dia)',
	'L_DEA_DELAY'                       => 'Segundos',
	'L_DEA_DELAY_MIN'                   => 'Minutos',
	'L_NO_DEA_EMAILS_VERSION'           => 'Versão da Extensão: ',
	'L_NO_DEA_EMAILS_CONFIG'            => 'Opções de Configuração do CRON',
	'L_NO_DEA_EMAILS_TEX'               => 'Domínios de E-mail "DEA" recolhidos através do CRON',
	'L_NO_DEA_EMAILS_TEX_LOCAL'         => 'Domínios de E-mail "DEA" recolhidos localmente',
	'L_NO_DEA_EMAILS_COUNTER'           => 'Execuções do CRON',
	'L_NO_DEA_EMAILS_TIMES'             => 'Desde a instalação da extensão, o CRON já foi executado <strong>%s</strong> vezes.',
	'L_NO_DEA_EMAILS_DATE'              => 'Última execução do CRON',
	'L_NO_DEA_EMAILS_USERS'             => 'Gestão de Utilizadores com Contas de E-mail DEA',
	'L_NO_DEA_EMAILS_TOT_USERS'         => 'Total de Utilizadores Registados',
	'L_NO_DEA_EMAILS_TOT_USERS_EXPLAIN' => 'Incluindo bots e utilizadores inactivos.',
	'L_NO_DEA_EMAILS_DEA_USERS'         => 'Total de Utilizadores com Contas de E-mail DEA',
	'L_NO_DEA_EMAILS_DOMAIN'            => 'Domínio de E-mail Descartável',
	'L_NO_DEA_EMAILS_PLACE'             => 'Introduz um Domínio de E-mail Descartável',
	'L_NO_DEA_EMAILS_ACTION'            => 'Acção',
	'L_NO_DEA_EMAILS_SAVE'              => 'Guardar',
	'L_NO_DEA_EMAILS_DEL'               => 'Eliminar',
	'L_NO_DEA_EMAILS_DOM_SAVE'          => 'O Domínio de E-mail DEA foi GUARDADO correctamente: <strong>((%s))</strong>',
	'L_NO_DEA_EMAILS_DOM_DEL'           => 'O Domínio de E-mail DEA foi ELIMINADO correctamente: <strong>((%s))</strong>',
	'L_NO_DEA_EMAILS_DOM_VALID'         => 'O Domínio de E-mail DEA: <strong>((%s))</strong> não é válido.',
	'L_NO_DEA_EMAILS_DOM_LOCATE'        => 'O Domínio de E-mail DEA não foi encontrado: <strong>((%s))</strong>.',
	'L_NO_DEA_EMAILS_CANNOT_FOUNDER'    => 'Não é permitido eliminar as contas de fundador.<br><br>O utilizador <strong>%s</strong> não pode ser eliminado.',
	'L_NO_DEA_EMAILS_CANNOT_YOURSELF'   => 'Não podes eliminar a tua própria conta.',
	'L_NO_DEA_EMAILS_DEL_USERS'         => 'Ferramentas Básicas',
	'L_NO_DEA_EMAILS_DEL_USERS_EXPLAIN' => 'Nota que a eliminação de um utilizador é definitiva e não pode ser recuperada. As mensagens privadas enviadas pelo utilizador que ainda não tenham sido lidas serão eliminadas e deixarão de estar disponíveis para os seus destinatários.',
	'L_NO_DEA_EMAILS_FORCE_CHG_EMAIL'   => 'Forçar alteração de "E-mail"',
	'L_NO_DEA_EMAILS_N_FORCE_CHG_EMAIL' => 'NÃO Forçar alteração de "E-mail"',
	'L_NO_DEA_EMAILS_SEND_PM'           => 'Enviar Mensagem Privada',
	'L_NO_DEA_EMAILS_RETAIN_POSTS'      => 'ELIMINAR UTILIZADOR e Manter as Suas Mensagens',
	'L_NO_DEA_EMAILS_REMOVE_POSTS'      => 'ELIMINAR UTILIZADOR e Eliminar as Suas Mensagens',
	'L_NO_DEA_EMAILS_NEED_ACTION'       => 'Tens de seleccionar uma "Ferramenta Básica".',
	'L_NO_DEA_EMAILS_NO_USERS'          => 'Nenhum Utilizador seleccionado',
	'L_NO_DEA_EMAILS_PERCENTAGE'        => '<i>(%s &#37; do Total de Utilizadores Registados)</i>',
]);
