<?php

/**
 * @package Double Account Preventer for phpBB.
 * @copyright (c) 2014 www.phpbb-work.ru
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'ACP_CAT_DAP_MOD'                => 'Double Account Preventer',
	'ACP_DAP_ADD_NAME'               => 'Adicionar usuário a',
	'ACP_DAP_ADD_TO_BLACKLIST'       => 'Lista Negra',
	'ACP_DAP_ADD_TO_WHITELIST'       => 'Lista Branca',
	'ACP_DAP_ADD_TO_EXCLUSION'       => 'Exclusão',
	'ACP_DAP_BLACKLIST'              => 'Banir por Cookie',
	'ACP_DAP_BLACKLIST_EXPLAIN'      => 'Aqui você pode banir usuários por Cookie.<br />A cor vermelha do nome de usuário significa usuário na lista negra. Quando o usuário faz login com um nome em vermelho, esta extensão cria um cookie especial no navegador dele, e se este existir, o usuário não consegue ver o fórum nesse <strong>navegador</strong>. A cor verde do nome de usuário significa usuário na lista branca: quando o usuário faz login com um nome em verde, o cookie de banimento é removido do navegador dele. A cor azul do nome de usuário significa uma exceção à verificação de banimento. <strong>Nota:</strong> se o usuário recusar a aceitação de cookies no navegador, o banimento por cookie não funcionará com ele. Mas com um nome na lista negra, não conseguirá fazer login de qualquer forma.',
	'ACP_DAP_BLACKLIST_UPDATED'      => 'A lista de banidos foi atualizada com sucesso.',
	'ACP_DAP_COOKIE_BAN'             => 'Banir um ou mais nomes de usuário',
	'ACP_DAP_COOKIE_BAN_EXPLAIN'     => 'Você pode banir vários usuários de uma vez inserindo cada nome em uma nova linha. Use a funcionalidade «Procurar um membro» para procurar e adicionar automaticamente um ou mais usuários.',
	'ACP_DAP_COOKIE_BAN_SETTINGS'    => 'Configurações de Banimento por Cookie',
	'ACP_DAP_COOKIE_UNBAN'           => 'Desbanir ou remover exclusão de nomes de usuário',
	'ACP_DAP_COOKIE_UNBAN_EXPLAIN'   => 'Você pode desbanir (ou remover a exclusão de) vários usuários de uma vez usando a combinação apropriada de mouse e teclado do seu computador e navegador.',
	'ACP_DAP_DELETE_BY_TIME'         => 'Excluir entradas mais antigas que',
	'ACP_DAP_DELETE_FROM_BLOCKLIST'  => 'Excluir da lista de bloqueio',
	'ACP_DAP_DELETE_USER'            => 'Excluir usuário',
	'ACP_DAP_DUPE_LOG'               => 'Registro de autenticações suspeitas',
	'ACP_DAP_DUPE_LOG_EXPLAIN'       => 'Quando a verificação de cookie está habilitada, aqui fica a lista de eventos em que um usuário faz login com dados de outro usuário no cookie do seu navegador, o que pode indicar uma conta duplicada ou uma autenticação ilegal. Isto pode ajudar a rastrear duplicados já registrados no seu fórum. Se o usuário tentar se autenticar estando presente na lista de bloqueio por cookie, você verá o status atual dele abaixo do nome, na coluna da esquerda.',
	'ACP_DAP_DUPE_USER_LIST'         => 'Lista de Usuários Duplicados',
	'ACP_DAP_DUPE_USER_LIST_EXPLAIN' => 'Lista de todos os usuários marcados no registro como contas duplicadas.<br /><strong>Observação:</strong> o método de detecção por IP não garante que o usuário identificado seja o mesmo computador que compartilha os nomes comuns, pois algumas redes têm computadores diferentes com o mesmo IP. O método de detecção por <strong>Cookie</strong> dá uma garantia quase total no caso de encontrar correspondências. Leia <a href="http://www.phpbb-work.ru/double-account-preventer-ext-t92.html">aqui</a> mais informações (somente em russo).',
	'ACP_DAP_EXCLUDES_MANAGE'        => 'Gerenciamento de exclusões do registro de suspeitas',
	'ACP_DAP_EXCLUDE_USERS'          => 'Usuários a excluir',
	'ACP_DAP_EXCLUDED_USERS'         => 'Pares excluídos',
	'ACP_DAP_EXCLUDED_USERS_EXPLAIN' => 'O registro «usuário1 - usuário2» é idêntico ao registro «usuário2 - usuário1». Use combinações adequadas de teclado e mouse para escolher e excluir vários pares da lista de uma vez.',
	'ACP_DAP_EXCLUDED_USERS_LIST'    => 'Lista de exclusões',
	'ACP_DAP_FORUM_ID_ERROR'         => 'Muitos fóruns selecionados. Tente selecionar menos.',
	'ACP_DAP_NO_EXCLUDES'            => 'A lista de exclusões está vazia',
	'ACP_DAP_NO_MATCHES'             => 'Nenhum registro para excluir foi encontrado.',
	'ACP_DAP_NO_USERS_SELECTED'      => 'Nenhum par selecionado para exclusão.',
	'ACP_DAP_NOTIFICATIONS'          => 'Configurações de Notificações',
	'ACP_DAP_NOTIFICATIONS_EXPLAIN'  => 'Configure as notificações do Double Account Preventer.',
	'ACP_DAP_NO_PERMISSIONS'         => 'Você não tem as permissões necessárias para realizar esta operação.',
	'ACP_DAP_PM_NOTIFICATION'        => 'Notificações por MP',
	'ACP_DAP_POST_NOTIFICATION'      => 'Notificações por mensagem',
	'ACP_DAP_QUICK_ACTIONS'          => 'Ações rápidas',
	'ACP_DAP_SAVED_SETTINGS'         => 'Configurações do Double Account Preventer salvas.',
	'ACP_DAP_SETTINGS'               => 'Configurações do Double Account Preventer',
	'ACP_DAP_SETTINGS_EXPLAIN'       => 'Configure as várias verificações para prevenir contas duplicadas.<br />Versão da Extensão: <strong>%s</strong>. Consulte a <a style="font-weight: bold;" href="http://www.phpbb-work.ru/double-account-preventer-ext-t92.html" onclick="window.open(this.href);return false;">página de suporte</a> para a versão mais recente ou para obter ajuda com esta extensão.',
	'ACP_DAP_SETTINGS_UPDATED'       => '<strong>Configurações do Double Account Preventer alteradas</strong>',
	'ACP_DAP_USER_ID_ERROR'          => 'Não existe usuário com o ID informado.',
	'ACP_DAP_USERNAME'               => 'Nome de Usuário / Status do Banimento',
	'ACP_DAP_USER_DELETED'           => 'Usuário excluído com sucesso',

	'BAN_TRIGGERED_BY_DAP' => 'Foi emitido um banimento sobre o seu nome de usuário.',

	'CANNOT_REMOVE_ANONYMOUS' => 'Você não pode remover a conta de usuário convidado.',
	'CANNOT_REMOVE_FOUNDER'   => 'Você não tem permissão para remover uma conta de fundador.',
	'CANNOT_REMOVE_YOURSELF'  => 'Você não tem permissão para remover sua própria conta de usuário.',

	'COOKIE_CHECK_REGISTRATION'         => 'Verificação de Cookie',
	'COOKIE_CHECK_REGISTRATION_EXPLAIN' => 'Procura um cookie com dados de outro usuário no navegador do usuário, no registro e no login. Se existir, o usuário será marcado como conta duplicada.',

	'DAP_ALERT_USER_ID'                  => 'ID do usuário de alerta',
	'DAP_ALERT_USER_ID_EXPLAIN'          => 'ID de usuário a ser usado para enviar notificações por mensagem e MPs. Use apenas um ID de usuário.',
	'DAP_CANNOT_BAN_ANONYMOUS'           => 'Você não tem permissão para banir a conta de convidado.',
	'DAP_CANNOT_BAN_BOT'                 => 'Você não tem permissão para banir uma conta de bot.',
	'DAP_CANNOT_BAN_FOUNDER'             => 'Você não tem permissão para banir uma conta de fundador.',
	'DAP_CANNOT_BAN_YOURSELF'            => 'Você não tem permissão para banir a si mesmo.',
	'DAP_CONTACT_ADMIN_MESSAGE'          => 'Por favor, entre em contato com o %2$sAdministrador do Fórum%3$s para mais informações.',
	'DAP_COOKIE_AUTOBAN_ENABLED'         => 'Habilitar Banimento Automático',
	'DAP_COOKIE_AUTOBAN_ENABLED_EXPLAIN' => 'Se um usuário fizer login ou se registrar com um nome de usuário não banido mas com um cookie de banimento no navegador, e o nome de usuário não estiver nas exclusões ou na lista branca, a nova conta será automaticamente adicionada à Lista Negra.',
	'DAP_COOKIE_BAN_ENABLED'             => 'Habilitar Banimento por Cookie',
	'DAP_COOKIE_BAN_ENABLED_EXPLAIN'     => 'Habilita ou desabilita os recursos de Banimento por Cookie.',
	'DAP_COOKIE_BAN_MESSAGE'             => 'Motivo do banimento',
	'DAP_COOKIE_BAN_MESSAGE_EXPLAIN'     => 'Mensagem exibida quando um usuário é banido por cookie. Deixe em branco se você tiver um fórum multilíngue e quiser exibir o texto da variável <samp>DAP_COOKIE_BAN_MESSAGE_TEXT</samp> localizada em <em>ext/shredder/dap/language/en/info_acp_dap.php</em>',
	'DAP_COOKIE_BAN_MESSAGE_TEXT'        => 'As regras do fórum são para serem cumpridas.',
	'DAP_COOKIE_COMMON_NAMES'            => 'Nomes Comuns de Cookie',
	'DAP_COOKIE_DENY_MESSAGE'            => 'Mensagem de recusa de registro',
	'DAP_COOKIE_DENY_MESSAGE_EXPLAIN'    => 'Mensagem exibida quando um usuário é impedido de se registrar por cookie. Deixe em branco se você tiver um fórum multilíngue e quiser exibir o texto da variável <samp>DAP_COOKIE_DENY_REGISTER_TEXT</samp> localizada em <em>ext/shredder/dap/language/en/info_acp_dap.php</em>',
	'DAP_COOKIE_DENY_REGISTER'           => 'Recusar registro a usuários banidos',
	'DAP_COOKIE_DENY_REGISTER_EXPLAIN'   => 'O usuário terá o registro recusado se for encontrado um cookie de banimento em seu navegador.',
	'DAP_COOKIE_DENY_REGISTER_TEXT'      => 'Você não pode se registrar neste fórum.',
	'DAP_EXCLUDE_NAMES_EXPLAIN'          => 'Para especificar vários nomes de usuário diferentes, insira cada um em uma nova linha.',
	'DAP_EXCLUDES_NAMES'                 => 'Nomes de usuários-exclusões',
	'DAP_EXCLUDES_NAMES_EXPLAIN'         => 'A cada usuário da lista superior será atribuído o nome-exclusão ou vários nomes deste campo. Os pares excluídos não serão registrados como autenticações suspeitas se for encontrado nos navegadores um cookie com o nome de um dos usuários no navegador do outro.',
	'DAP_EXCLUDES_UPDATE_SUCCESSFUL'     => 'Lista de exclusões atualizada com sucesso.',
	'DAP_DUPLICATES_PER_PAGE'            => 'Número de duplicados por página',
	'DAP_DUPLICATES_PER_PAGE_EXPLAIN'    => 'Número de usuários marcados como duplicados exibidos por página na Lista de Usuários Duplicados.',
	'DAP_EMAIL_NOTIFICATION'             => 'Habilitar notificações por e-mail',
	'DAP_EMAIL_NOTIFICATION_EXPLAIN'     => 'Envia notificações por e-mail quando uma conta duplicada é detectada. O e-mail será enviado a todos os usuários com permissão para administrar usuários.',
	'DAP_IGNORE_INACTIVE'                => 'Ignorar usuários inativos',
	'DAP_IGNORE_INACTIVE_EXPLAIN'        => 'Se habilitado, as contas serão excluídas das correspondências do usuário se estiverem inativas no momento da detecção. Se todas as contas correspondentes estiverem inativas, o relatório de duplicado não será criado. O mesmo se aplica ao registro de autenticações suspeitas.',
	'DAP_IP_ADRESS'                      => 'Endereço IP',
	'DAP_IP_COMMON_NAMES'                => 'Nomes Comuns de IP',
	'DAP_NO_DUPE_USERS'                  => 'Nenhum usuário duplicado',
	'DAP_NOTIFICATION_MESSAGE'           => 'O novo usuário compartilha endereços IP e/ou cookies comuns com outros usuários. Por favor, visite o perfil dele para mais informações detalhadas.

Detalhes do usuário:

Nome de usuário: [username]
Endereço IP do usuário: [user_ip]
E-mail: [user_email]
Registrado em: [user_regdate]
Nomes Comuns de IP: [ip_common_names]
Nomes Comuns de Cookie: [c_common_names]',
	'DAP_NOTIFICATION_SUBJECT'      => 'Possível conta duplicada: [username]',
	'DAP_PM_NOTIFICATION'           => 'Habilitar notificações por MP',
	'DAP_PM_NOTIFICATION_EXPLAIN'   => 'Envia notificações por MP quando uma conta duplicada é detectada. A MP será enviada a todos os usuários com permissão para administrar usuários.',
	'DAP_POST_NOTIFICATION'         => 'Habilitar notificações por mensagem',
	'DAP_POST_NOTIFICATION_EXPLAIN' => 'Envia notificações por mensagem para todos os fóruns selecionados quando uma conta duplicada é detectada. Selecione vários fóruns segurando a tecla <samp>CTRL</samp> e clicando. Não selecione fóruns se você não quiser usar este recurso.',
	'DAP_QUICK_DELETION'            => 'Exclusão rápida',
	'DAP_QUICK_DELETION_EXPLAIN'    => 'Se habilitado, os nomes duplicados e sua correspondência por cookie terão um ícone de exclusão rápida. Se «Notificar» estiver habilitado, o usuário receberá um e-mail após a exclusão. O texto do e-mail pode ser encontrado no arquivo <em>ext/shredder/dap/language/en/email/user_dap_deleted.txt</em>',
	'DAP_STATUS_BLACKLIST'          => 'Banido',
	'DAP_STATUS_WHITELIST'          => 'Na lista branca',
	'DAP_STATUS_EXCLUSION'          => 'Excluído',
	'DAP_USER_NO_BANNED'            => 'A lista de bloqueio está vazia',
	'DAP_USER_NOTES_ENTRY'          => 'Habilitar notificações nas notas de usuário',
	'DAP_USER_NOTES_ENTRY_EXPLAIN'  => 'Adiciona informações às notas de usuário sobre as correspondências do usuário, caso sejam encontradas no registro ou no login no fórum. Registros de autenticações em momentos diferentes mas com os mesmos dados não serão repetidos.',

	'DELETE_ALL_ENTRIES' => 'Excluir todas as entradas',
	'DAP_DELETE_POSTS'   => 'Excluir mensagens',

	'IP_CHECK_FULL'                 => 'Verificação completa',
	'IP_CHECK_LIGHT'                => 'Verificação leve',
	'IP_CHECK_NONE'                 => 'Sem verificação',
	'IP_CHECK_REGISTRATION'         => 'Verificação de IP duplicado no registro',
	'IP_CHECK_REGISTRATION_EXPLAIN' => 'Isto permite procurar os mesmos endereços IP no registro, nos registros do banco de dados. A opção <strong>Leve</strong> pesquisa apenas as tabelas de sessões e usuários; a opção <strong>Completa</strong> pesquisa todas as tabelas do banco de dados com registro de IP, por isso demora mais tempo.',
	'IP_WHOIS_FOR'                  => 'Informações sobre este IP',

	'LOG_EXCLUDES_UPDATED'      => '<strong>Exclusões do registro de suspeitas atualizadas</strong>',
	'LOG_BLACKLIST_BLOCK'       => '<strong>Rejeitado pela lista negra do DAP ao tentar fazer login com os dados de</strong><br />» %s',
	'LOG_CLEAR_DAP'             => '<strong>Registro de autenticações suspeitas limpo</strong>',
	'LOG_CLEAR_DUPE_LIST'       => '<strong>Lista de Usuários Duplicados limpa</strong>',
	'LOG_COOKIE_AUTOBAN'        => '<strong>Usuário banido automaticamente por cookie</strong><br />» %s',
	'LOG_COOKIE_BLACKLIST'      => '<strong>Usuário adicionado à lista negra de cookies</strong><br />» %s',
	'LOG_COOKIE_BLACKLIST_MANY' => '<strong>Usuários adicionados à lista negra de cookies</strong><br />» %s',
	'LOG_COOKIE_WHITELIST'      => '<strong>Usuário adicionado à lista branca de cookies</strong><br />» %s',
	'LOG_COOKIE_WHITELIST_MANY' => '<strong>Usuários adicionados à lista branca de cookies</strong><br />» %s',
	'LOG_COOKIE_EXCLUSION'      => '<strong>Usuário adicionado às exclusões de cookies</strong><br />» %s',
	'LOG_COOKIE_EXCLUSION_MANY' => '<strong>Usuários adicionados às exclusões de cookies</strong><br />» %s',
	'LOG_COOKIE_BLOCK'          => '<strong>Rejeitado por cookie ao tentar fazer login com os dados de</strong><br />» %s',
	'LOG_COOKIE_UNBAN'          => '<strong>Usuário removido da lista de bloqueio de cookies</strong><br />» %s',
	'LOG_COOKIE_UNBAN_MANY'     => '<strong>Usuários removidos da lista de bloqueio de cookies</strong><br />» %s',
	'LOG_LOGIN_WITH_DATA'       => '<strong>Login bem-sucedido com os dados de</strong><br />» %s',
	'LOG_LOGIN_WITH_DATA_ACP'   => '<strong>Login bem-sucedido no ACP com os dados de</strong><br />» %s',
	'LOG_STANDARD_BLOCK'        => '<strong>Rejeitado pelo banimento padrão do phpBB ao tentar fazer login com os dados de</strong><br />» %s',
	'LOG_USER_NOTE_AUTH'        => '<strong>Correspondência de cookie com outro usuário encontrada no navegador do usuário ao fazer login no fórum</strong><br />» %s',
	'LOG_USER_NOTE_COOKIE'      => '<strong>Correspondência de cookie com outro usuário encontrada no navegador do usuário ao se registrar no fórum</strong><br />» %s',
	'LOG_USER_NOTE_IP'          => '<strong>Correspondências de IP com outros usuários encontradas ao se registrar no fórum</strong><br />» %s',

	'QUICK_DELETE_NOTIFY' => 'Notificar',
	'QUICK_DELETE_SILENT' => 'Sem notificação',
]);
