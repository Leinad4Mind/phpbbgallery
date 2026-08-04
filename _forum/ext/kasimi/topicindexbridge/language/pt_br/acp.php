<?php
/**
 * Topic Index Bridge language file.
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'TOPICINDEX_BRIDGE_TITLE'                    => 'Topic Index Bridge',
	'TOPICINDEX_BRIDGE_EXPLAIN'                  => 'Ative cada integração opcional de forma independente. Uma integração só é executada quando a dependência está ativa.',
	'TOPICINDEX_BRIDGE_FORUMINFO'                => 'Informações do fórum e ícones dos tópicos',
	'TOPICINDEX_BRIDGE_QTE'                      => 'Atributos do Quick Title Edition',
	'TOPICINDEX_BRIDGE_BBPREFIX'                 => 'Prefixos BBPrefix',
	'TOPICINDEX_BRIDGE_BBEMOJI'                  => 'BBEmoji nos títulos dos tópicos',
	'TOPICINDEX_BRIDGE_TOPICIMAGEPREVIEW'        => 'Topic Image Preview',
	'TOPICINDEX_BRIDGE_USERTOPICS'               => 'Índices de tópicos por usuário',
	'TOPICINDEX_BRIDGE_ACTIVE'                   => 'Disponível e ativa.',
	'TOPICINDEX_BRIDGE_INACTIVE'                 => 'Disponível, mas desativada.',
	'TOPICINDEX_BRIDGE_UNAVAILABLE'              => 'A extensão ou o serviço necessário não está disponível.',
	'TOPICINDEX_BRIDGE_LEGACY_ACTIVE'            => 'Uma bridge Kasimi antiga está ativa; este módulo foi suspenso para impedir conteúdo duplicado.',
	'TOPICINDEX_BRIDGE_PROFILE_LIST'             => 'Lista de tópicos nos perfis',
	'TOPICINDEX_BRIDGE_PROFILE_LIST_EXPLAIN'     => 'Lista externa usada pelo link exibido nos perfis.',
	'TOPICINDEX_BRIDGE_SELF_LIST'                => 'Lista de tópicos do usuário atual',
	'TOPICINDEX_BRIDGE_SELF_LIST_EXPLAIN'        => 'Lista externa usada pelo link rápido do usuário autenticado.',
]);
