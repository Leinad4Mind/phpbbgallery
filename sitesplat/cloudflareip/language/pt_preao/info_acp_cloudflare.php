<?php

/**
 * Cloudflare IP
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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
	'ACP_CLOUDFLARE'         => 'CloudFlare IP',
	'ACP_CLOUDFLARE_EXPLAIN' => 'Bem-vindo às definições do CloudFlare. Depois de introduzires o teu email, a Chave de API (API Key) e o Domínio do CloudFlare, poderás definir o modo de desenvolvimento e limpar a cache a partir daqui.',
	'SS_HELPER_NOTY'         => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'CLOUDFLARE_NOTICE'      => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. Os endereços de IP encontram-se agora todos normalizados e serão os IPs reais dos utilizadores. Diverte-te!<br />Poderás ser expulso do ACP depois de saíres desta página. Isto é normal, visto que o teu IP atual está a ser normalizado. Se isso acontecer, inicia sessão de novo.<br />As configurações da API do CloudFlare encontram-se no separador <strong>ACP &#62; EXTENSÕES</strong> e, assim que introduzires os dados da API, poderás limpar a cache do CF (CloudFlare) diretamente no separador <strong>ACP &#62; GERAL</strong>. Diverte-te!</p></div>',

	'CLOUDFLARE_FETCH_FAILED'        => 'Não foi possível obter os dados do CloudFlare. Por favor, verifica o teu email, a tua chave de API (API key) e o domínio. Erros devolvidos pelo CloudFlare:<br><br>%s',
	'CLOUDFLARE_SETTINGS_SAVED'      => 'As definições locais do CloudFlare foram guardadas.',
	'CLOUDFLARE_DEV_MODE_FAILED'     => 'A alteração do Modo de Desenvolvimento do CloudFlare falhou:<br><br>%s.',
	'CLOUDFLARE_DEV_MODE_SUCCESS'    => 'A alteração do Modo de Desenvolvimento do CloudFlare foi bem-sucedida.',
	'CLOUDFLARE_CLEAR_CACHE_FAILED'  => 'A limpeza da cache do CloudFlare falhou:<br><br>%s.',
	'CLOUDFLARE_CLEAR_CACHE_SUCCESS' => 'A limpeza da cache do CloudFlare foi bem-sucedida.',

	'CLOUDFLARE_EMAIL'                    => 'Email da conta do CloudFlare',
	'CLOUDFLARE_API_KEY'                  => 'Chave API (Global API Key)',
	'CLOUDFLARE_API_KEY_EXPLAIN'          => 'Inicia sessão na tua conta do CloudFlare e visita a página da tua Conta. Na página "Overview", no canto inferior direito, deverás ver a secção "API". Clica na ligação "Get your API token". No passo seguinte deverás ver o botão "Global API Key". Clica em "View" e copia essa chave de API. Cola-a neste campo.',
	'CLOUDFLARE_DOMAIN'                   => 'Domínio (Domain)',
	'CLOUDFLARE_DOMAIN_EXPLAIN'           => 'Introduz o domínio do teu fórum tal como consta no CF (não é necessário o protocolo completo do URL). Normalmente é algo como: "meudominio.com".',
	'CLOUDFLARE_DEVELOPMENT_MODE'         => 'Modo de Desenvolvimento (Development Mode)',
	'CLOUDFLARE_DEVELOPMENT_MODE_EXPLAIN' => 'O Modo de Desenvolvimento permite-te activar temporariamente o modo de desenvolvimento no teu site, caso precises de fazer alterações. Isto contorna a cache acelerada do CloudFlare e torna o site mais lento, mas é útil se estiveres a alterar conteúdo que fica em cache (como imagens, css ou JavaScript) e quiseres ver essas alterações de imediato. Uma vez activado, o modo de desenvolvimento dura 3 horas e depois desactiva-se automaticamente.',
	'CLOUDFLARE_CLEAR_CACHE'              => 'Limpar Cache',
	'CLOUDFLARE_CLEAR_CACHE_EXPLAIN'      => 'Remove TODOS os ficheiros da cache do CloudFlare',

	'CLOUDFLARE_CF_CLEAR_CACHE' => 'Limpar a cache do CloudFlare',

	'LOG_PURGE_CLOUDFLARE_CACHE' => '<strong>Cache do CloudFlare purgada</strong>',
]);
