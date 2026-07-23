<?php

/**
 * BBtracking
 * @copyright (c) 2017, Sitesplat
 * @license private
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
	'ACP_BBTRACKING'          => 'BBtracking',
	'ACP_BBTRACKING_EXPLAIN'  => 'Aqui você pode adicionar usuários a monitorar (ou grupos inteiros). Os usuários ou grupos serão então monitorados em todo o fórum quando forem disparadas ações específicas que possam ser úteis para compreender o comportamento do usuário. <br />',
	'ACP_BBTRACKING_SETTINGS' => 'Configurações do BBtracking',
	'ACP_BBTRACKING_LOGS'     => 'Registros do BBtracking',
	'ACP_BBTRACKING_LOGS_EXPLAIN' => 'Os movimentos monitorados dos usuários ou grupos podem ser vistos abaixo.',

	'USER_UNTRACKED' => 'O usuário deixou de ser monitorado.',
	'TRACKED_UPDATED' => 'A lista de monitoramento foi atualizada.',

	'ADD_USER'               => 'Adicionar usuário',
	'TRACKED_USERS'          => 'Usuários monitorados',
	'TRACKED_USERS_EXPLAIN'  => 'Adicionar usuários individuais para serem monitorados/rastreados',
	'TRACKED_GROUPS'         => 'Grupos monitorados',
	'TRACKED_GROUPS_EXPLAIN' => 'Selecione um grupo específico para ser monitorado/rastreado',

	'TRACKING_TYPE' => 'Tipo de monitoramento',
	'ALL'           => 'Tudo',

	'TRACKING_TYPE_ACCOUNT_SETTINGS'       => '<b>Definições da conta alteradas.</b><br>» Novo nome de usuário: %s. Novo email: %s. Nome de usuário alterado: %s. Email alterado: %s. Senha alterada: %s.',
	'TRACKING_TYPE_VIEWFORUM'              => '<b>Visitou <a href="%s">o fórum ID %d (início %d)</a>.</b>',
	'TRACKING_TYPE_VIEWTOPIC'              => '<b>Visitou <a href="%s">o tópico ID %d (início %d)</a> no <a href="%s">fórum ID %d</a>.</b>',
	'TRACKING_TYPE_MEMBERLIST_VIEWPROFILE' => '<b>Visualizou <a href="%s">o perfil do usuário ID %d</a>.</b>',
	'TRACKING_TYPE_EDIT_POST'              => '<b>Editou <a href="%s">a mensagem ID %d</a>.</b>',
	'TRACKING_TYPE_LOGIN'                  => '<b>Iniciou sessão (Log in).</b>',
	'TRACKING_TYPE_LOGOUT'                 => '<b>Terminou sessão (Log out).</b>',
	'TRACKING_TYPE_SEND_PM'                => '<b>Enviou MP para os IDs de usuário: %s.</b>',

	'TRACKING_TYPE_ACCOUNT_SETTINGS_LABEL'       => 'Definições da conta alteradas',
	'TRACKING_TYPE_VIEWFORUM_LABEL'              => 'Visita a viewforum',
	'TRACKING_TYPE_VIEWTOPIC_LABEL'              => 'Visita a viewtopic',
	'TRACKING_TYPE_MEMBERLIST_VIEWPROFILE_LABEL' => 'Visualização do perfil de membro',
	'TRACKING_TYPE_EDIT_POST_LABEL'              => 'Edição de mensagem',
	'TRACKING_TYPE_LOGIN_LABEL'                  => 'Iniciar sessão (Login)',
	'TRACKING_TYPE_LOGOUT_LABEL'                 => 'Terminar sessão (Logout)',
	'TRACKING_TYPE_SEND_PM_LABEL'                => 'Envio de MP',

	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBTRACKING_NOTICE' => '<div class="phpinfo"><p>As definições desta extensão podem ser encontradas no separador "EXTENSÕES".<br />Nota: outras opções da extensão encontram-se em: ACP > Fóruns: "selecione o seu fórum" e clique no ícone da engrenagem verde para entrar no modo de edição. Em seguida, verifique "Guardar revisões de mensagens" e "Limpar automaticamente as revisões". <br/>Além disso, não se esqueça de verificar as "Permissões de fórum de grupos" no separador de permissões "Ações".<br /> Por fim, os usuários (que têm permissões) podem utilizar a opção de revisão de mensagens na visualização do tópico (viewtopic), no menu suspenso de mensagem individual.</p></div>',

	'ACP_PRIMEPOSTREVISIONS_ENABLE'         => 'Armazenar revisões de mensagens',
	'ACP_PRIMEPOSTREVISIONS_ENABLE_EXPLAIN' => 'Manter um histórico de revisões de todas as edições de mensagens.',

	'ACP_PRIMEPOSTREVISIONS_AUTOPRUNE'         => 'Limpar automaticamente (Auto-prune) as revisões',
	'ACP_PRIMEPOSTREVISIONS_AUTOPRUNE_EXPLAIN' => 'Excluir automaticamente revisões de mensagens mais antigas do que o número de dias fornecido. Defina como 0 para desabilitar.',

	'LOG_PRIMEPOSTREVISIONS_AUTOPRUNE' => '<strong>Revisões de mensagens excluídas automaticamente</strong><br />» Revisões excluídas: %d',
]);
