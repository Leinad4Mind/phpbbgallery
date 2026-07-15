<?php
/**
 *
 * No DEA Emails extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Picaron
 * @license GNU General Public License, version 2 (GPL-2.0)
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

$lang = array_merge($lang, array(
		'ACP_NO_DEA_EMAILS'					=> 'No DEA Emails',
		'ACP_NO_DEA_EMAILS_EXPLAIN'			=> 'Esta extensão impede o registo de um utilizador no fórum quando se utiliza uma conta de Email descartável ou temporária <a href="https://bit.ly/2W2MrVO" target="_blank">(DED)</a>.',
		'ACP_NO_DEA_EMAILS_WARNING_CRON'	=> 'Nesta secção obtém-se dados do estado do CRON.<br>- Habilita-se a opção para definir o intervalo de tempo para execução do CRON.<br>Mostra-se uma relação dos domínios de Email tipo DED com os que se filtrarem de contas já existentes do fórum.',
		'ACP_NO_DEA_EMAILS_WARNING_LOCAL'	=> 'Nesta secção pode-se gerir (incluir/eliminar) de forma local domínios de contas de Email descartáveis ou temporárias <a href="https://bit.ly/2W2MrVO" target="_blank">(DED)</a>.<br><br>Deve-se prestar especial atenção, já que se incluir um domínio válido, impediremos o registo do utilizador que o utilize.<br><i>Exemplo: Se adicionarmos o domínio “gmail.com” faremos com que nenhum utilizador possa usar uma conta de Email da Google.</i>',
		'ACP_NO_DEA_EMAILS_WARNING_USERS'	=> 'Nesta secção recompila-se informação de todos os Utilizadores do fórum que têm um Email Descartável associado <a href="https://bit.ly/2W2MrVO" target="_blank">(DED)</a> na sua conta.<br><br>Poderemos <strong>ELIMINAR POR COMPLETO</strong> os utilizadores que seleccionados.<br>(Incluindo todas as suas mensagens publicadas)<br><br><strong>ATENÇÃO:<br>Esta acção NÃO É REVERSÍVEL, tenha precaução ao utilizar esta opção caso o seu fórum esteja em produção.</strong>',
		'ACP_NO_DEA_EMAILS_SETTINGS'		=> 'Gestão CRON & Domínios de Emails DED Externos',
		'ACP_NO_DEA_EMAILS_LOCALS'			=> 'Gestão Local de Domínios de Email DED',
		'ACP_NO_DEA_EMAILS_USERS'			=> 'Utilizadores com Contas de Email DED',
		'ACP_SUBMIT_DELETE'					=> 'Aplicar Alterações',
		'LOG_CONFIG_CONFIGURATION'			=> '<strong>Configuração Actualizada Extensão “No DEA Emails”</strong>',
		'LOG_CONFIG_USERS'					=> '<strong>Utilizadores ELIMINADOS desde “No DEA Emails”</strong>',
		'L_NO_DEA_EMAILS_DELAY'				=> 'Intervalo para execução do CRON',
		'L_NO_DEA_EMAILS_DELAY_EXPLAIN'		=> '(Mínimo: 300 Segundos , Máximo: 86400 Segundos = 1 Día)',
		'L_DEA_DELAY'						=> 'Segundos',
		'L_DEA_DELAY_MIN'					=> 'Minutos',
		'L_NO_DEA_EMAILS_VERSION'			=> 'Versão de Extensão: ',
		'L_NO_DEA_EMAILS_CONFIG'			=> 'Opções de Configuração do CRON',
		'L_NO_DEA_EMAILS_TEX'				=> 'Domínios de Emails “DED” recompilados mediante CRON',
		'L_NO_DEA_EMAILS_TEX_LOCAL'			=> 'Domínios de Emails “DED” recompilados de forma local',
		'L_NO_DEA_EMAILS_COUNTER'			=> 'Execução do CRON',
		'L_NO_DEA_EMAILS_TIMES'				=> 'Desde a instalação da extensão, o CRON foi executado <strong>%s</strong> vezes.',
		'L_NO_DEA_EMAILS_DATE'				=> 'Última execução do CRON',
		'L_NO_DEA_EMAILS_USERS'				=> 'Gestão de Utilizadores com Contas de Email DED',
		'L_NO_DEA_EMAILS_TOT_USERS'			=> 'Total de Utilizadores Registados',
		'L_NO_DEA_EMAILS_TOT_USERS_EXPLAIN'	=> 'Incluindo Bots e utilizadores inactivos.',
		'L_NO_DEA_EMAILS_DEA_USERS'			=> 'Total de Utilizadores com Contas de Email DED',
		'L_NO_DEA_EMAILS_NAME_USER'			=> 'Nome do Utilizador',
		'L_NO_DEA_EMAILS_EMAIL'				=> 'Email',
		'L_NO_DEA_EMAILS_JOINED'			=> 'Registado',
		'L_NO_DEA_EMAILS_LAST_ACTIVE'		=> 'Última vez activo',
		'L_NO_DEA_EMAILS_POST'				=> 'Quantidade de Mensagens',
		'L_NO_DEA_EMAILS_DOMAIN'			=> 'Domínio de Email Descartável',
		'L_NO_DEA_EMAILS_PLACE'				=> 'Introduza um domínio de Email Descartável',
		'L_NO_DEA_EMAILS_ACTION'			=> 'Acção',
		'L_NO_DEA_EMAILS_SAVE'				=> 'Guardar',
		'L_NO_DEA_EMAILS_DEL'				=> 'Eliminar',
		'L_NO_DEA_EMAILS_MARK'				=> 'Seleccionar',
		'L_NO_DEA_EMAILS_DOM_SAVE'			=> 'Foram GUARDADOS correctamente os Domínios de Email DED: <strong>((%s))</strong>',
		'L_NO_DEA_EMAILS_DOM_DEL'			=> 'Foram ELIMINADOS correctamente os Domínios de Email DED: <strong>((%s))</strong>',
		'L_NO_DEA_EMAILS_DOM_VALID'			=> 'O Domínio de Email DED: <strong>((%s))</strong> não é válido.',
		'L_NO_DEA_EMAILS_DOM_LOCATE'		=> 'Não se localizou o Domínio de Email DED: <strong>((%s))</strong>.',
		'L_NO_DEA_EMAILS_CANNOT_FOUNDER'	=> 'Não é permitido apagar contas de fundadores.<br><br>O Utilizador <strong>%s</strong> não pode ser removido.',
		'L_NO_DEA_EMAILS_CANNOT_YOURSELF'	=> 'Não pode apagar a sua própria conta.',
		'L_NO_DEA_EMAILS_DEL_USERS'			=> 'Ferramentas Básicas',
		'L_NO_DEA_EMAILS_DEL_USERS_EXPLAIN'	=> 'Por favor, tenha em conta que a eliminação de um utilizador é final, não pode ser recuperado. As mensagens privadas enviadas pelo utilizador sem ler, serão apagadas e não estarão disponíveis para seus destinatários.',
		'L_NO_DEA_EMAILS_SEND_PM'			=> 'Enviar Mensagem Privada',
		'L_NO_DEA_EMAILS_RETAIN_POSTS'		=> 'ELIMINAR UTLIZADOR e Manter as suas Mensagens',
		'L_NO_DEA_EMAILS_REMOVE_POSTS'		=> 'ELIMINAR UTLIZADOR e Apagar as suas Mensagens',
		'L_NO_DEA_EMAILS_NEED_ACTION'		=> 'Deve de seleccionar una “Ferramenta Básica”.',
		'L_NO_DEA_EMAILS_NO_USERS'			=> 'Não seleccionou nenhum utilizador.',
));
