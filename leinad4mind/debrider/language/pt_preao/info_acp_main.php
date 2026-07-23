<?php

/**
 * @copyright (c) 2014-2020 Leinad4Mind, Feneck91, etc.
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'ACP_ENABLE'                               => 'Activar Debrider',
	'ACP_API_KEY'                              => 'Chave API',
	'ACP_MAIN_MODULE_TITLE'                    => 'Debrider',
	'ACP_DEBRIDER'                             => 'Debrider',
	'ACP_DEBRIDER_SETTING_SAVED'               => 'Configurações guardadas',
	'ACP_PROVIDER'                             => 'Fornecedor',
	'ACP_PROVIDER_REALDEBRID'                  => 'Real Debrid',
	'ACP_PROVIDER_ALLDEBRID'                   => 'All Debrid',
	'ACP_USE_PROXY'                            => 'Usar proxy',
	'ACP_PROXY_CREDENTIALS'                    => 'Credenciais de proxy',
	'ACP_PROXY_CREDENTIALS_EXPLAIN'            => 'Insere o formato Utilizador:Palavra-passe',
	'ACP_PROXY_TYPE'                           => 'Tipo de proxy',
	'ACP_PROXY_TYPE_CURLPROXY_HTTP'            => 'HTTP Proxy. Padrão',
	'ACP_PROXY_TYPE_CURLPROXY_HTTPS'           => 'HTTPS Proxy. (Para OpenSSL, GnuTLS e NSS)',
	'ACP_PROXY_TYPE_CURLPROXY_HTTP_1_0'        => 'HTTP 1.0 Proxy. (Para qualquer túnel CONNECT)',
	'ACP_PROXY_TYPE_CURLPROXY_SOCKS4'          => 'SOCKS4 Proxy',
	'ACP_PROXY_TYPE_CURLPROXY_SOCKS4A'         => 'SOCKS4a Proxy. Proxy resolve hostname URL',
	'ACP_PROXY_TYPE_CURLPROXY_SOCKS5'          => 'SOCKS5 Proxy',
	'ACP_PROXY_TYPE_CURLPROXY_SOCKS5_HOSTNAME' => 'SOCKS5 Proxy. Proxy resolve hostname URL',
	'ACP_PROXY_HOST'                           => 'Proxy host',
	'ACP_PROXY_HOST_EXPLAIN'                   => 'Insere no formato Host:Porta',
	'DEBRIDER_PRESELECTED'                     => 'Pré-seleccionado',
	'DEBRIDER_CAN_ENABLE'                      => 'Podes activar debrider?',
	'DEBRIDER_CAN_ENABLE_EXPLAIN'              => 'Se sim, a opção aparecerá nos tópicos mas desmarcada, se não, não aparecerá e se pré-seleccionado aparecerá já seleccionada',
	'DEBRIDER_MYSQL_UPDATE'                    => 'Ajuda MySQL',
	'DEBRIDER_MYSQL_UPDATE_EXPLAIN'            => 'Corre esta consulta mysql depois de escolher quais fóruns devem ter o debrider activado nos tópicos.<br>O can_debrider_enabled = 2 significa pré-seleccionado, = 1 significa sim, = 0 significa não.',
	'DEBRIDER_MYSQL_UPDATE_CODE'               => 'UPDATE phpbb_topics SET debrider_enabled = 1 WHERE forum_id IN (SELECT forum_id from phpbb_forums WHERE can_debrider_enabled = 2)',
	'INSTALL_NOTICE'                           => '<div class="phpinfo"><p>Precisas de definir as permissões de Utilizadores, para seleccionar quais grupos de utilizadores podem ver Botões Debrid nos tópicos.<br>Define permissões para Moderadores, para que possam ver a opção "Activar Debrider" na Criação do Tópico.<br>E por fim escolhe quais fóruns devem ter esta funcionalidade.</p></div></p></div>',
	'PHP_ERROR'                                => 'Esta extensão requer PHP 7.1.0 (ou superior).',
	'PHPBB_ERROR'                              => 'Esta extensão requer phpBB 3.3.0 (ou superior).',
]);
