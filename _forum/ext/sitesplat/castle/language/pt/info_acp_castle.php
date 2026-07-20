<?php

/**
 * Castle
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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

$lang = array_merge($lang, [
	'ACP_CASTLE_TITLE'                            => 'BBCastle',
	'ACP_CASTLE_TITLE_EXPLAIN'                    => 'BBCastle, Uma solução completa de aquisição de conta ponta a ponta. O BBCastle entende o comportamento do utilizador em toda a web, telemóvel e APIs. Dependendo do risco associado a um dispositivo individual, o BBcastle aciona automaticamente notificações de segurança, desafios e fluxos de trabalho de redefinição de conta.',
	'ACP_CASTLE_SETTING_SAVED'                    => 'As configurações do Castle foram guardadas.',
	'CASTLE_APP_ID'                               => 'ID da App Castle',
	'CASTLE_APP_ID_EXPLAIN'                       => 'Insira a sua ID de aplicação (App ID) do Castle aqui. Pode encontrá-la nas suas <a href="https://dashboard.castle.io/settings/general">configurações do painel do Castle</a>.',
	'CASTLE_API_SECRET'                           => 'Chave Secreta da API (API Secret) do Castle',
	'CASTLE_API_SECRET_EXPLAIN'                   => 'Insira a sua Chave Secreta da API do Castle aqui. Pode encontrá-la nas suas <a href="https://dashboard.castle.io/settings/general">configurações do painel do Castle</a>.',
	'CASTLE_HOOK_CONFIGURED'                      => 'Webhook do Castle configurado',
	'CASTLE_HOOK_CONFIGURED_EXPLAIN'              => 'De modo a usar a Autenticação Adaptativa do Castle (nova camada de autenticação), o Castle necessita de saber a morada URL do seu fórum para o poder informar em relação a inícios de sessão perigosos/maliciosos.<br><ol><li>Vá até à página das <a href="https://dashboard.castle.io/settings/webhooks">Definições Webhooks do Castle</a></li><li>Clique em Adicionar novo terminal (Add new endpoint)</li><li>Defina este endereço URL como Endereço URL do Terminal (Endpoint URL): <samp>%s</samp></li><li>Clique em Guardar (Save)</li><li>Assinale/ative esta caixa de verificação</li>',
	'CASTLE_FEEDBACK_REDIRECT_CONFIGURED'         => 'Redirecionamento de feedback do Castle configurado',
	'CASTLE_FEEDBACK_REDIRECT_CONFIGURED_EXPLAIN' => 'De modo a usar a página de destino (landing page) personalizada quando o utilizador é notificado sobre uma atividade suspeita, o Castle necessita de saber o endereço URL do seu fórum.<br><ol><li>Vá até à página de <a href="https://dashboard.castle.io/settings/appearance">Configurações de Aparência do Castle</a></li><li>Defina este URL como URL de redirecionamento de feedback (Feedback Redirect URL): <samp>%s</samp></li><li>Clique em Guardar (Save)</li><li>Assinale/ative esta caixa de verificação</li>',

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'CASTLE_NOTICE'  => '<div class="phpinfo"><p>As configurações desta extensão encontram-se em <strong>ACP &#187; EXTENSÕES &#187; Castle</strong>.</p></div>',
]);
