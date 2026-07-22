<?php

/**
 * @package Double Account Preventer for phpBB.
 * @copyright (c) 2014 www.phpbb-work.ru
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'ACP_CAT_DAP_MOD'                => 'Double Account Preventer',
	'ACP_DAP_ADD_NAME'               => 'Adicionar utilizador a',
	'ACP_DAP_ADD_TO_BLACKLIST'       => 'Lista Negra',
	'ACP_DAP_ADD_TO_WHITELIST'       => 'Lista Branca',
	'ACP_DAP_ADD_TO_EXCLUSION'       => 'Exclusão',
	'ACP_DAP_BLACKLIST'              => 'Banir por Cookie',
	'ACP_DAP_BLACKLIST_EXPLAIN'      => 'Aqui podes banir utilizadores por Cookie.<br />A cor vermelha do nome de utilizador significa utilizador na lista negra. Quando o utilizador inicia sessão com um nome a vermelho, esta extensão cria um cookie especial no navegador dele, e se este existir, o utilizador não consegue ver o fórum nesse <strong>navegador</strong>. A cor verde do nome de utilizador significa utilizador na lista branca: quando o utilizador inicia sessão com um nome a verde, o cookie de banimento é removido do navegador dele. A cor azul do nome de utilizador significa uma exceção à verificação de banimento. <strong>Nota:</strong> se o utilizador recusar a aceitação de cookies no navegador, o banimento por cookie não funcionará com ele. Mas com um nome na lista negra, não conseguirá iniciar sessão de qualquer forma.',
	'ACP_DAP_BLACKLIST_UPDATED'      => 'A lista de banidos foi actualizada com sucesso.',
	'ACP_DAP_COOKIE_BAN'             => 'Banir um ou mais nomes de utilizador',
	'ACP_DAP_COOKIE_BAN_EXPLAIN'     => 'Podes banir vários utilizadores de uma vez inserindo cada nome numa nova linha. Usa a funcionalidade «Procurar um membro» para procurar e adicionar automaticamente um ou mais utilizadores.',
	'ACP_DAP_COOKIE_BAN_SETTINGS'    => 'Definições de Banimento por Cookie',
	'ACP_DAP_COOKIE_UNBAN'           => 'Desbanir ou remover exclusão de nomes de utilizador',
	'ACP_DAP_COOKIE_UNBAN_EXPLAIN'   => 'Podes desbanir (ou remover a exclusão de) vários utilizadores de uma vez usando a combinação apropriada de rato e teclado do teu computador e navegador.',
	'ACP_DAP_DELETE_BY_TIME'         => 'Eliminar entradas mais antigas que',
	'ACP_DAP_DELETE_FROM_BLOCKLIST'  => 'Eliminar da lista de bloqueio',
	'ACP_DAP_DELETE_USER'            => 'Eliminar utilizador',
	'ACP_DAP_DUPE_LOG'               => 'Registo de autenticações suspeitas',
	'ACP_DAP_DUPE_LOG_EXPLAIN'       => 'Quando a verificação de cookie está activada, aqui fica a lista de eventos em que um utilizador inicia sessão com dados de outro utilizador no cookie do seu navegador, o que pode indicar uma conta duplicada ou uma autenticação ilegal. Isto pode ajudar a detectar duplicados já registados no teu fórum. Se o utilizador tentar autenticar-se estando presente na lista de bloqueio por cookie, verás o estado actual dele por baixo do nome, na coluna da esquerda.',
	'ACP_DAP_DUPE_USER_LIST'         => 'Lista de Utilizadores Duplicados',
	'ACP_DAP_DUPE_USER_LIST_EXPLAIN' => 'Lista de todos os utilizadores marcados no registo como contas duplicadas.<br /><strong>Nota:</strong> o método de detecção por IP não garante que o utilizador identificado seja o mesmo do computador que partilha os nomes comuns, porque algumas redes têm computadores diferentes com o mesmo IP. O método de detecção por <strong>Cookie</strong> dá uma garantia quase total no caso de encontrar correspondências. Lê <a href="http://www.phpbb-work.ru/double-account-preventer-ext-t92.html">aqui</a> mais informações (apenas em russo).',
	'ACP_DAP_EXCLUDES_MANAGE'        => 'Gestão de exclusões do registo de suspeitas',
	'ACP_DAP_EXCLUDE_USERS'          => 'Utilizadores a excluir',
	'ACP_DAP_EXCLUDED_USERS'         => 'Pares excluídos',
	'ACP_DAP_EXCLUDED_USERS_EXPLAIN' => 'O registo «utilizador1 - utilizador2» é idêntico ao registo «utilizador2 - utilizador1». Usa combinações adequadas de teclado e rato para escolher e eliminar vários pares da lista de uma vez.',
	'ACP_DAP_EXCLUDED_USERS_LIST'    => 'Lista de exclusões',
	'ACP_DAP_FORUM_ID_ERROR'         => 'Demasiados fóruns seleccionados. Tenta seleccionar menos.',
	'ACP_DAP_NO_EXCLUDES'            => 'A lista de exclusões está vazia',
	'ACP_DAP_NO_MATCHES'             => 'Não foram encontrados registos para eliminar.',
	'ACP_DAP_NO_USERS_SELECTED'      => 'Nenhum par seleccionado para eliminação.',
	'ACP_DAP_NOTIFICATIONS'          => 'Definições de Notificações',
	'ACP_DAP_NOTIFICATIONS_EXPLAIN'  => 'Configura as notificações do Double Account Preventer.',
	'ACP_DAP_NO_PERMISSIONS'         => 'Não tens as permissões necessárias para realizar esta operação.',
	'ACP_DAP_PM_NOTIFICATION'        => 'Notificações por MP',
	'ACP_DAP_POST_NOTIFICATION'      => 'Notificações por mensagem',
	'ACP_DAP_QUICK_ACTIONS'          => 'Ações rápidas',
	'ACP_DAP_SAVED_SETTINGS'         => 'Definições do Double Account Preventer guardadas.',
	'ACP_DAP_SETTINGS'               => 'Definições do Double Account Preventer',
	'ACP_DAP_SETTINGS_EXPLAIN'       => 'Configura as várias verificações para prevenir contas duplicadas.<br />Versão da Extensão: <strong>%s</strong>. Consulta a <a style="font-weight: bold;" href="http://www.phpbb-work.ru/double-account-preventer-ext-t92.html" onclick="window.open(this.href);return false;">página de suporte</a> para a versão mais recente ou para obter ajuda com esta extensão.',
	'ACP_DAP_SETTINGS_UPDATED'       => '<strong>Definições do Double Account Preventer alteradas</strong>',
	'ACP_DAP_USER_ID_ERROR'          => 'Não existe utilizador com o ID introduzido.',
	'ACP_DAP_USERNAME'               => 'Nome de Utilizador / Estado do Banimento',
	'ACP_DAP_USER_DELETED'           => 'Utilizador eliminado com sucesso',

	'BAN_TRIGGERED_BY_DAP' => 'Foi emitido um banimento sobre o teu nome de utilizador.',

	'CANNOT_REMOVE_ANONYMOUS' => 'Não podes remover a conta de utilizador convidado.',
	'CANNOT_REMOVE_FOUNDER'   => 'Não tens permissão para remover uma conta de fundador.',
	'CANNOT_REMOVE_YOURSELF'  => 'Não tens permissão para remover a tua própria conta de utilizador.',

	'COOKIE_CHECK_REGISTRATION'         => 'Verificação de Cookie',
	'COOKIE_CHECK_REGISTRATION_EXPLAIN' => 'Procura um cookie com dados de outro utilizador no navegador do utilizador, no registo e no início de sessão. Se existir, o utilizador será marcado como conta duplicada.',

	'DAP_ALERT_USER_ID'                  => 'ID do utilizador de alerta',
	'DAP_ALERT_USER_ID_EXPLAIN'          => 'ID de utilizador a usar para enviar notificações por mensagem e MPs. Usa apenas um ID de utilizador.',
	'DAP_CANNOT_BAN_ANONYMOUS'           => 'Não tens permissão para banir a conta de convidado.',
	'DAP_CANNOT_BAN_BOT'                 => 'Não tens permissão para banir uma conta de bot.',
	'DAP_CANNOT_BAN_FOUNDER'             => 'Não tens permissão para banir uma conta de fundador.',
	'DAP_CANNOT_BAN_YOURSELF'            => 'Não tens permissão para te banires a ti próprio.',
	'DAP_CONTACT_ADMIN_MESSAGE'          => 'Por favor contacta o %2$sAdministrador do Fórum%3$s para mais informações.',
	'DAP_COOKIE_AUTOBAN_ENABLED'         => 'Activar Banimento Automático',
	'DAP_COOKIE_AUTOBAN_ENABLED_EXPLAIN' => 'Se um utilizador iniciar sessão ou se registar com um nome de utilizador não banido mas com um cookie de banimento no navegador, e o nome de utilizador não estiver nas exclusões ou na lista branca, a nova conta será automaticamente adicionada à Lista Negra.',
	'DAP_COOKIE_BAN_ENABLED'             => 'Activar Banimento por Cookie',
	'DAP_COOKIE_BAN_ENABLED_EXPLAIN'     => 'Activa ou desactiva as funcionalidades de Banimento por Cookie.',
	'DAP_COOKIE_BAN_MESSAGE'             => 'Motivo do banimento',
	'DAP_COOKIE_BAN_MESSAGE_EXPLAIN'     => 'Mensagem apresentada quando um utilizador é banido por cookie. Deixa em branco se tiveres um fórum multilingue e quiseres apresentar o texto da variável <samp>DAP_COOKIE_BAN_MESSAGE_TEXT</samp> localizada em <em>ext/shredder/dap/language/en/info_acp_dap.php</em>',
	'DAP_COOKIE_BAN_MESSAGE_TEXT'        => 'As regras do fórum são para se cumprir.',
	'DAP_COOKIE_COMMON_NAMES'            => 'Nomes Comuns de Cookie',
	'DAP_COOKIE_DENY_MESSAGE'            => 'Mensagem de recusa de registo',
	'DAP_COOKIE_DENY_MESSAGE_EXPLAIN'    => 'Mensagem apresentada quando um utilizador é impedido de se registar por cookie. Deixa em branco se tiveres um fórum multilingue e quiseres apresentar o texto da variável <samp>DAP_COOKIE_DENY_REGISTER_TEXT</samp> localizada em <em>ext/shredder/dap/language/en/info_acp_dap.php</em>',
	'DAP_COOKIE_DENY_REGISTER'           => 'Recusar registo a utilizadores banidos',
	'DAP_COOKIE_DENY_REGISTER_EXPLAIN'   => 'O utilizador terá o registo recusado se for encontrado um cookie de banimento no seu navegador.',
	'DAP_COOKIE_DENY_REGISTER_TEXT'      => 'Não te podes registar neste fórum.',
	'DAP_EXCLUDE_NAMES_EXPLAIN'          => 'Para especificar vários nomes de utilizador diferentes, insere cada um numa nova linha.',
	'DAP_EXCLUDES_NAMES'                 => 'Nomes de utilizadores-exclusões',
	'DAP_EXCLUDES_NAMES_EXPLAIN'         => 'A cada utilizador da lista superior será atribuído o nome-exclusão ou vários nomes deste campo. Os pares excluídos não serão registados como autenticações suspeitas se for encontrado nos navegadores um cookie com o nome de um dos utilizadores no navegador do outro.',
	'DAP_EXCLUDES_UPDATE_SUCCESSFUL'     => 'Lista de exclusões actualizada com sucesso.',
	'DAP_DUPLICATES_PER_PAGE'            => 'Número de duplicados por página',
	'DAP_DUPLICATES_PER_PAGE_EXPLAIN'    => 'Número de utilizadores marcados como duplicados apresentados por página na Lista de Utilizadores Duplicados.',
	'DAP_EMAIL_NOTIFICATION'             => 'Activar notificações por e-mail',
	'DAP_EMAIL_NOTIFICATION_EXPLAIN'     => 'Envia notificações por e-mail quando é detectada uma conta duplicada. O e-mail será enviado a todos os utilizadores com permissão para administrar utilizadores.',
	'DAP_IGNORE_INACTIVE'                => 'Ignorar utilizadores inactivos',
	'DAP_IGNORE_INACTIVE_EXPLAIN'        => 'Se activado, as contas serão excluídas das correspondências do utilizador se estiverem inactivas no momento da detecção. Se todas as contas correspondentes estiverem inactivas, o relatório de duplicado não será criado. O mesmo se aplica ao registo de autenticações suspeitas.',
	'DAP_IP_ADRESS'                      => 'Endereço IP',
	'DAP_IP_COMMON_NAMES'                => 'Nomes Comuns de IP',
	'DAP_NO_DUPE_USERS'                  => 'Nenhum utilizador duplicado',
	'DAP_NOTIFICATION_MESSAGE'           => 'O novo utilizador partilha endereços IP e/ou cookies comuns com outros utilizadores. Por favor visita o perfil dele para mais informações detalhadas.

Detalhes do utilizador:

Nome de utilizador: [username]
Endereço IP do utilizador: [user_ip]
E-mail: [user_email]
Registado em: [user_regdate]
Nomes Comuns de IP: [ip_common_names]
Nomes Comuns de Cookie: [c_common_names]',
	'DAP_NOTIFICATION_SUBJECT'      => 'Possível conta duplicada: [username]',
	'DAP_PM_NOTIFICATION'           => 'Activar notificações por MP',
	'DAP_PM_NOTIFICATION_EXPLAIN'   => 'Envia notificações por MP quando é detectada uma conta duplicada. A MP será enviada a todos os utilizadores com permissão para administrar utilizadores.',
	'DAP_POST_NOTIFICATION'         => 'Activar notificações por mensagem',
	'DAP_POST_NOTIFICATION_EXPLAIN' => 'Envia notificações por mensagem para todos os fóruns seleccionados quando é detectada uma conta duplicada. Selecciona vários fóruns mantendo premida a tecla <samp>CTRL</samp> e clicando. Não seleccione fóruns se não quiseres usar esta funcionalidade.',
	'DAP_QUICK_DELETION'            => 'Eliminação rápida',
	'DAP_QUICK_DELETION_EXPLAIN'    => 'Se activado, os nomes duplicados e a respectiva correspondência por cookie terão um ícone de eliminação rápida. Se «Notificar» estiver activado, o utilizador receberá um e-mail após a eliminação. O texto do e-mail pode ser encontrado no ficheiro <em>ext/shredder/dap/language/en/email/user_dap_deleted.txt</em>',
	'DAP_STATUS_BLACKLIST'          => 'Banido',
	'DAP_STATUS_WHITELIST'          => 'Na lista branca',
	'DAP_STATUS_EXCLUSION'          => 'Excluído',
	'DAP_USER_NO_BANNED'            => 'A lista de bloqueio está vazia',
	'DAP_USER_NOTES_ENTRY'          => 'Activar notificações nas notas de utilizador',
	'DAP_USER_NOTES_ENTRY_EXPLAIN'  => 'Adiciona informação às notas de utilizador sobre as correspondências do utilizador, caso sejam encontradas no registo ou no início de sessão no fórum. Registos de autenticações em momentos diferentes mas com os mesmos dados não serão repetidos.',

	'DELETE_ALL_ENTRIES' => 'Eliminar todas as entradas',
	'DAP_DELETE_POSTS'   => 'Eliminar mensagens',

	'IP_CHECK_FULL'                 => 'Verificação completa',
	'IP_CHECK_LIGHT'                => 'Verificação leve',
	'IP_CHECK_NONE'                 => 'Sem verificação',
	'IP_CHECK_REGISTRATION'         => 'Verificação de IP duplicado no registo',
	'IP_CHECK_REGISTRATION_EXPLAIN' => 'Isto permite procurar os mesmos endereços IP no registo, nos registos da base de dados. A opção <strong>Leve</strong> pesquisa apenas as tabelas de sessões e utilizadores; a opção <strong>Completa</strong> pesquisa todas as tabelas da base de dados com registo de IP, pelo que demora mais tempo.',
	'IP_WHOIS_FOR'                  => 'Informação sobre este IP',

	'LOG_EXCLUDES_UPDATED'      => '<strong>Exclusões do registo de suspeitas actualizadas</strong>',
	'LOG_BLACKLIST_BLOCK'       => '<strong>Rejeitado pela lista negra do DAP ao tentar iniciar sessão com os dados de</strong><br />» %s',
	'LOG_CLEAR_DAP'             => '<strong>Registo de autenticações suspeitas limpo</strong>',
	'LOG_CLEAR_DUPE_LIST'       => '<strong>Lista de Utilizadores Duplicados limpa</strong>',
	'LOG_COOKIE_AUTOBAN'        => '<strong>Utilizador banido automaticamente por cookie</strong><br />» %s',
	'LOG_COOKIE_BLACKLIST'      => '<strong>Utilizador adicionado à lista negra de cookies</strong><br />» %s',
	'LOG_COOKIE_BLACKLIST_MANY' => '<strong>Utilizadores adicionados à lista negra de cookies</strong><br />» %s',
	'LOG_COOKIE_WHITELIST'      => '<strong>Utilizador adicionado à lista branca de cookies</strong><br />» %s',
	'LOG_COOKIE_WHITELIST_MANY' => '<strong>Utilizadores adicionados à lista branca de cookies</strong><br />» %s',
	'LOG_COOKIE_EXCLUSION'      => '<strong>Utilizador adicionado às exclusões de cookies</strong><br />» %s',
	'LOG_COOKIE_EXCLUSION_MANY' => '<strong>Utilizadores adicionados às exclusões de cookies</strong><br />» %s',
	'LOG_COOKIE_BLOCK'          => '<strong>Rejeitado por cookie ao tentar iniciar sessão com os dados de</strong><br />» %s',
	'LOG_COOKIE_UNBAN'          => '<strong>Utilizador removido da lista de bloqueio de cookies</strong><br />» %s',
	'LOG_COOKIE_UNBAN_MANY'     => '<strong>Utilizadores removidos da lista de bloqueio de cookies</strong><br />» %s',
	'LOG_LOGIN_WITH_DATA'       => '<strong>Início de sessão bem-sucedido com os dados de</strong><br />» %s',
	'LOG_LOGIN_WITH_DATA_ACP'   => '<strong>Início de sessão bem-sucedido no ACP com os dados de</strong><br />» %s',
	'LOG_STANDARD_BLOCK'        => '<strong>Rejeitado pelo banimento padrão do phpBB ao tentar iniciar sessão com os dados de</strong><br />» %s',
	'LOG_USER_NOTE_AUTH'        => '<strong>Correspondência de cookie com outro utilizador encontrada no navegador do utilizador ao iniciar sessão no fórum</strong><br />» %s',
	'LOG_USER_NOTE_COOKIE'      => '<strong>Correspondência de cookie com outro utilizador encontrada no navegador do utilizador ao registar-se no fórum</strong><br />» %s',
	'LOG_USER_NOTE_IP'          => '<strong>Correspondências de IP com outros utilizadores encontradas ao registar-se no fórum</strong><br />» %s',

	'QUICK_DELETE_NOTIFY' => 'Notificar',
	'QUICK_DELETE_SILENT' => 'Sem notificação',
]);
