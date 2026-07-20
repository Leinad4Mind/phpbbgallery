<?php

/**
 * @package sitesplat BBlinks for phpBB.
 * @copyright (c) 2017 SiteSplat All rights reserved
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
	'BBLINKS_TITLE'         => 'BBlinks',
	'BBLINKS_SETTING_SAVED' => 'As configurações do BBlinks foram guardadas.',

	'BBLINKS_ENABLE'                              => 'Habilitar BBlinks',
	'BBLINKS_ENABLE_MODAL'                        => 'Habilitar o "modal/pop-up" em links externos',
	'BBLINKS_ENABLE_MODAL_EXPLAIN'                => 'Um "modal/pop-up" de confirmação será exibido e aparecerá depois que o usuário clique num link externo.',
	'BBLINKS_SKIP_LINK_TYPES'                     => 'Ignorar tipos de links',
	'BBLINKS_SKIP_LINK_TYPES_EXPLAIN'             => 'Não processa links dos seguintes tipos de arquivo. Separar por pipe (|). Exemplo: \'pdf|jpg|png\'.',
	'BBLINKS_INTERNAL_LINK_TYPES'                 => 'Tipos de links internos',
	'BBLINKS_INTERNAL_LINK_TYPES_EXPLAIN'         => 'Os tipos de links especificados serão sempre e desde o princípio considerados links internos. Separar por pipe (|). Exemplo: \'pdf|jpg|png\'.',
	'BBLINKS_EXTERNAL_LINK_TYPES'                 => 'Tipos de links externos',
	'BBLINKS_EXTERNAL_LINK_TYPES_EXPLAIN'         => 'Os tipos de links especificados serão sempre e desde o princípio considerados links externos. Separar por pipe (|). Exemplo: \'zip|rar|7z\'.',
	'BBLINKS_FORBIDDEN_DOMAINS'                   => 'Domínios não permitidos/proibidos',
	'BBLINKS_FORBIDDEN_DOMAINS_EXPLAIN'           => 'Lista de domínios cujos links devem ser removidos, separados por ponto e vírgula (;). Exemplo: \'http://www.google.com\'',
	'BBLINKS_FORBIDDEN_NEW_URL'                   => 'Novo URL não permitido/proibido',
	'BBLINKS_FORBIDDEN_NEW_URL_EXPLAIN'           => 'A inserção de URL substituirá todos os links removidos. Exemplo: \'http://www.google.com\' ou \'#top\'',
	'BBLINKS_INTERNAL_LINK_CLASS'                 => 'Classe (Class) do link interno',
	'BBLINKS_EXTERNAL_LINK_CLASS'                 => 'Classe (Class) do link externo',
	'BBLINKS_INTERNAL_LINK_TARGET'                => 'Destino (Target) do link interno',
	'BBLINKS_EXTERNAL_LINK_TARGET'                => 'Destino (Target) do link externo',
	'BBLINKS_INTERNAL_LINK_REL'                   => 'Relação (Rel) do link interno',
	'BBLINKS_EXTERNAL_LINK_REL'                   => 'Relação (Rel) do link externo',
	'BBLINKS_LINK_REL_EXPLAIN'                    => 'Pode ver e consultar todas as recomendações aqui: <a href="https://webmasters.googleblog.com/2019/09/evolving-nofollow-new-ways-to-identify.html" target="_blank">googleblog.com</a> e: <a href="https://support.google.com/webmasters/answer/96569" target="_blank">support.google.com</a>',
	'BBLINKS_HIDE_LINKS_FROM_GUESTS'              => 'Ocultar e esconder todos os links para visitantes',
	'BBLINKS_HIDE_LINKS_FROM_GUESTS_TEXT'         => 'Texto de aviso de links escondidos/ocultos para visitantes',
	'BBLINKS_HIDE_LINKS_FROM_GUESTS_TEXT_EXPLAIN' => 'O texto do link escondido será substituído e trocado por esta mensagem em texto.',
	'BBLINKS_SKIP_PREFIX_TYPES'                   => 'Ignorar e ultrapassar tipos de prefixo',
	'BBLINKS_SKIP_PREFIX_TYPES_EXPLAIN'           => 'Não adicionará nenhum prefixo de link externo a estes tipos de arquivo.',
	'BBLINKS_EXTERNAL_PREFIX'                     => 'Prefixo de link externo',
	'BBLINKS_EXTERNAL_PREFIX_EXPLAIN'             => 'Exemplo: \'http://anonym.to?\'',
	'BBLINKS_INTERNAL_LINK_DOMAINS'               => 'Domínios de links internos',
	'BBLINKS_INTERNAL_LINK_DOMAINS_EXPLAIN'       => 'Lista de domínios a serem tidos em conta como locais e próprios, os mesmos deverão ser divididos e separados por ponto e vírgula (;). Exemplo: \'http://www.alternate-domain.com\'',
	'BBLINKS_CPF_LINK_NEW_WINDOW'                 => 'Abrir as ligações preenchidas nos "Campos de Perfil Personalizados" noutra janela',
	'BBLINKS_SIGNATURE'                           => 'Aplicar também as definições acima nas assinaturas de perfil',

	'ACP_LOCALURLTOTEXT_TITLE'         => 'Tradução do URL Local em Texto',
	'ACP_LOCALURLTOTEXT_SETTINGS'      => 'Configurações',
	'ACP_LOCALURLTOTEXT_SETTING_SAVED' => 'As configurações foram salvas e guardadas com sucesso!',
	'ACP_LOCALURLTOTEXT_FORUM'         => 'Espaço reservado (Placeholder) para o link do texto de um fórum',
	'ACP_LOCALURLTOTEXT_FORUM_EXPLAIN' => 'Insira o seu espaço reservado (Placeholder), poderá ser introduzido código e sintaxe de formatação HTML. Variáveis disponíveis: {FORUM_NAME}',
	'ACP_LOCALURLTOTEXT_TOPIC'         => 'Espaço reservado (Placeholder) para o link do texto de um tópico',
	'ACP_LOCALURLTOTEXT_TOPIC_EXPLAIN' => 'Insira o seu espaço reservado (Placeholder), poderá ser introduzido código e sintaxe de formatação HTML. Variáveis disponíveis: {TOPIC_TITLE}, {FORUM_NAME}',
	'ACP_LOCALURLTOTEXT_POST'          => 'Espaço reservado (Placeholder) para o link do texto de uma publicação',
	'ACP_LOCALURLTOTEXT_POST_EXPLAIN'  => 'Insira o seu espaço reservado (Placeholder), poderá ser introduzido código e sintaxe de formatação HTML. Variáveis disponíveis: {USER_NAME}, {USER_COLOUR}, {POST_SUBJECT}, {TOPIC_TITLE}, {POST_OR_TOPIC_TITLE}, {FORUM_NAME}',
	'ACP_LOCALURLTOTEXT_USER'          => 'Espaço reservado (Placeholder) para o link do texto de um usuário',
	'ACP_LOCALURLTOTEXT_USER_EXPLAIN'  => 'Insira o seu espaço reservado (Placeholder), poderá ser introduzido código e sintaxe de formatação HTML. Variáveis disponíveis: {USER_NAME}, {USER_COLOUR}',
	'ACP_LOCALURLTOTEXT_PAGE'          => 'Espaço reservado (Placeholder) para o texto base da conexão de uma Página (Extension Pages)',
	'ACP_LOCALURLTOTEXT_PAGE_EXPLAIN'  => 'Este espaço destina-se única e exclusivamente a atuar e abranger as páginas originadas pela extensão: <a href="https://www.phpbb.com/customise/db/extension/pages/" target="_blank">Pages extension</a>. Insira um espaço reservado, sendo aceite e possível ser implementado e usado código tipo HTML. Variáveis disponíveis: {PAGE_TITLE}',
	'ACP_LOCALURLTOTEXT_CPF'           => 'Substituir ligações nos seus Campos de perfil personalizados',
	'ACP_LOCALURLTOTEXT_CPF_EXPLAIN'   => 'Selecione e ative se pretender que a extensão tenha poderes também para atuar sobre as hiperligações ou endereços do Fórum que constem nos Campos de perfil personalizados. Tendo em atenção de que a mesma só atuará perante os Campos que sejam e tenham como base apenas o tipo "URL (Link)".',
]);
