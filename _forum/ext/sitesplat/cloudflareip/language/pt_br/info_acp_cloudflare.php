<?php

/**
 * Cloudflare IP
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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
	'ACP_CLOUDFLARE'         => 'CloudFlare IP',
	'ACP_CLOUDFLARE_EXPLAIN' => 'Bem-vindo às configurações do CloudFlare. Depois de inserir o seu email, a Chave de API (API Key) e o Domínio do CloudFlare, você poderá definir o modo de desenvolvimento e limpar a cache a partir daqui.',
	'SS_HELPER_NOTY'         => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'CLOUDFLARE_NOTICE'      => '<div class="phpinfo"><p>Não existem configurações específicas para esta extensão. Os endereços de IP agora estão todos normalizados e serão os IPs reais dos usuários. Divirta-se!<br />Você pode ser desconectado do ACP depois de sair desta página. Isso é normal, pois o seu IP atual está sendo normalizado. Se isso acontecer, faça login novamente.<br />As configurações da API do CloudFlare estão na aba <strong>ACP &#62; EXTENSÕES</strong> e, assim que você inserir os dados da API, poderá limpar a cache do CF (CloudFlare) diretamente na aba <strong>ACP &#62; GERAL</strong>. Divirta-se!</p></div>',

	'CLOUDFLARE_FETCH_FAILED'        => 'Não foi possível obter os dados do CloudFlare. Por favor, verifique o seu email, a sua chave de API (API key) e o domínio. Erros retornados pelo CloudFlare:<br><br>%s',
	'CLOUDFLARE_SETTINGS_SAVED'      => 'As configurações locais do CloudFlare foram salvas.',
	'CLOUDFLARE_DEV_MODE_FAILED'     => 'A alteração do Modo de Desenvolvimento do CloudFlare falhou:<br><br>%s.',
	'CLOUDFLARE_DEV_MODE_SUCCESS'    => 'A alteração do Modo de Desenvolvimento do CloudFlare foi bem-sucedida.',
	'CLOUDFLARE_CLEAR_CACHE_FAILED'  => 'A limpeza da cache do CloudFlare falhou:<br><br>%s.',
	'CLOUDFLARE_CLEAR_CACHE_SUCCESS' => 'A limpeza da cache do CloudFlare foi bem-sucedida.',

	'CLOUDFLARE_EMAIL'                    => 'Email da conta do CloudFlare',
	'CLOUDFLARE_API_KEY'                  => 'Chave API (Global API Key)',
	'CLOUDFLARE_API_KEY_EXPLAIN'          => 'Faça login na sua conta do CloudFlare e visite a página da sua Conta. Na página "Overview", no canto inferior direito, você verá a seção "API". Clique no link "Get your API token". No próximo passo você verá o botão "Global API Key". Clique em "View" e copie essa chave de API. Cole-a neste campo.',
	'CLOUDFLARE_DOMAIN'                   => 'Domínio (Domain)',
	'CLOUDFLARE_DOMAIN_EXPLAIN'           => 'Digite o domínio do seu fórum como consta no CF (não é necessário o protocolo completo da URL). Normalmente é algo como: "meudominio.com".',
	'CLOUDFLARE_DEVELOPMENT_MODE'         => 'Modo de Desenvolvimento (Development Mode)',
	'CLOUDFLARE_DEVELOPMENT_MODE_EXPLAIN' => 'O Modo de Desenvolvimento permite que você ative temporariamente o modo de desenvolvimento no seu site, caso precise fazer alterações. Isso ignora a cache acelerada do CloudFlare e deixa o site mais lento, mas é útil se você estiver alterando conteúdo que fica em cache (como imagens, css ou JavaScript) e quiser ver essas alterações imediatamente. Uma vez ativado, o modo de desenvolvimento dura 3 horas e depois se desativa automaticamente.',
	'CLOUDFLARE_CLEAR_CACHE'              => 'Limpar Cache',
	'CLOUDFLARE_CLEAR_CACHE_EXPLAIN'      => 'Remove TODOS os arquivos da cache do CloudFlare',

	'CLOUDFLARE_CF_CLEAR_CACHE' => 'Limpar a cache do CloudFlare',

	'LOG_PURGE_CLOUDFLARE_CACHE' => '<strong>Cache do CloudFlare purgada</strong>',
]);
