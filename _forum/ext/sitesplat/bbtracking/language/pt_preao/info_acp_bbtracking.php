<?php

/**
 * BBtracking
 * @copyright (c) 2017, Sitesplat
 * @license private
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
	'ACP_BBTRACKING'          => 'BBtracking',
	'ACP_BBTRACKING_EXPLAIN'  => 'Aqui podes adicionar utilizadores a monitorizar (ou grupos inteiros). Os utilizadores ou grupos serão então monitorizados em todo o fórum quando forem despoletadas acções específicas que possam ser úteis para compreender o comportamento do utilizador. <br />',
	'ACP_BBTRACKING_SETTINGS' => 'Configurações do BBtracking',
	'ACP_BBTRACKING_LOGS'     => 'Registos do BBtracking',
	'ACP_BBTRACKING_LOGS_EXPLAIN' => 'Os movimentos monitorizados dos utilizadores ou grupos podem ser vistos abaixo.',

	'USER_UNTRACKED' => 'O utilizador deixou de ser monitorizado.',
	'TRACKED_UPDATED' => 'A lista de monitorização foi actualizada.',

	'ADD_USER'               => 'Adicionar utilizador',
	'TRACKED_USERS'          => 'Utilizadores monitorizados',
	'TRACKED_USERS_EXPLAIN'  => 'Adicionar utilizadores individuais para serem monitorizados/rastreados',
	'TRACKED_GROUPS'         => 'Grupos monitorizados',
	'TRACKED_GROUPS_EXPLAIN' => 'Selecciona um grupo específico para ser monitorizado/rastreado',

	'TRACKING_TYPE' => 'Tipo de monitorização',
	'ALL'           => 'Tudo',

	'TRACKING_TYPE_ACCOUNT_SETTINGS'       => '<b>Definições da conta alteradas.</b><br>» Novo nome de utilizador: %s. Novo email: %s. Nome de utilizador alterado: %s. Email alterado: %s. Palavra-passe alterada: %s.',
	'TRACKING_TYPE_VIEWFORUM'              => '<b>Visitou <a href="%s">o fórum ID %d (início %d)</a>.</b>',
	'TRACKING_TYPE_VIEWTOPIC'              => '<b>Visitou <a href="%s">o tópico ID %d (início %d)</a> no <a href="%s">fórum ID %d</a>.</b>',
	'TRACKING_TYPE_MEMBERLIST_VIEWPROFILE' => '<b>Visualizou <a href="%s">o perfil do utilizador ID %d</a>.</b>',
	'TRACKING_TYPE_EDIT_POST'              => '<b>Editou <a href="%s">a mensagem ID %d</a>.</b>',
	'TRACKING_TYPE_LOGIN'                  => '<b>Iniciou sessão (Log in).</b>',
	'TRACKING_TYPE_LOGOUT'                 => '<b>Terminou sessão (Log out).</b>',
	'TRACKING_TYPE_SEND_PM'                => '<b>Enviou MP para os IDs de utilizador: %s.</b>',

	'TRACKING_TYPE_ACCOUNT_SETTINGS_LABEL'       => 'Definições da conta alteradas',
	'TRACKING_TYPE_VIEWFORUM_LABEL'              => 'Visita a viewforum',
	'TRACKING_TYPE_VIEWTOPIC_LABEL'              => 'Visita a viewtopic',
	'TRACKING_TYPE_MEMBERLIST_VIEWPROFILE_LABEL' => 'Visualização do perfil de membro',
	'TRACKING_TYPE_EDIT_POST_LABEL'              => 'Edição de mensagem',
	'TRACKING_TYPE_LOGIN_LABEL'                  => 'Iniciar sessão (Login)',
	'TRACKING_TYPE_LOGOUT_LABEL'                 => 'Terminar sessão (Logout)',
	'TRACKING_TYPE_SEND_PM_LABEL'                => 'Envio de MP',

	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBTRACKING_NOTICE' => '<div class="phpinfo"><p>As definições desta extensão podem ser encontradas no separador "EXTENSÕES".<br />Nota: outras opções da extensão encontram-se em: ACP > Fóruns: "selecciona o teu fórum" e clica no ícone da engrenagem verde para entrares no modo de edição. Em seguida, verifica "Guardar revisões de mensagens" e "Limpar automaticamente as revisões". <br/>Além disso, não te esqueças de verificar as "Permissões de fórum de grupos" no separador de permissões "Acções".<br /> Por fim, os utilizadores (que têm permissões) podem utilizar a opção de revisão de mensagens na visualização do tópico (viewtopic), no menu suspenso de mensagem individual.</p></div>',

	'ACP_PRIMEPOSTREVISIONS_ENABLE'         => 'Armazenar revisões de mensagens',
	'ACP_PRIMEPOSTREVISIONS_ENABLE_EXPLAIN' => 'Manter um histórico de revisões de todas as edições de mensagens.',

	'ACP_PRIMEPOSTREVISIONS_AUTOPRUNE'         => 'Limpar automaticamente (Auto-prune) as revisões',
	'ACP_PRIMEPOSTREVISIONS_AUTOPRUNE_EXPLAIN' => 'Elimina automaticamente revisões de mensagens mais antigas do que o número de dias fornecido. Define como 0 para desactivar.',

	'LOG_PRIMEPOSTREVISIONS_AUTOPRUNE' => '<strong>Revisões de mensagens eliminadas automaticamente</strong><br />» Revisões eliminadas: %d',
]);
