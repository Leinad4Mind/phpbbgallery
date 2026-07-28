<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Imagens da galeria',
	'BBTAGSIMAGES_TAGS' => 'Tags',
	'BBTAGSIMAGES_TAGS_EXPLAIN' => 'Adicione até %1$d tags separadas por vírgulas. Cada tag deve conter entre %2$d e %3$d caracteres. Novas tags são enviadas aos moderadores para aprovação.',
	'BBTAGSIMAGES_TAG_TOO_SHORT' => 'Cada tag deve conter pelo menos %2$d caracteres.',
	'BBTAGSIMAGES_TAG_TOO_LONG' => 'Cada tag pode conter no máximo %3$d caracteres.',
	'BBTAGSIMAGES_TAG_LIMIT' => 'Você pode adicionar no máximo %1$d tags a uma imagem.',
	'BBTAGSIMAGES_PENDING_NOTICE' => 'Novas tags permanecem ocultas até serem aprovadas por um moderador.',
	'BBTAGSIMAGES_SAVE_FAILED' => 'Não foi possível salvar as tags da imagem.',
	'BBTAGSIMAGES_SEARCH_TAGS' => 'Pesquisar por tags',
	'BBTAGSIMAGES_SEARCH_TAGS_EXPLAIN' => 'Insira uma ou mais tags separadas por vírgulas.',
	'BBTAGSIMAGES_MATCH_ALL_TAGS' => 'Corresponder a todas as tags (E)',
	'BBTAGSIMAGES_MATCH_ANY_TAG' => 'Corresponder a qualquer tag (OU)',
	'BBTAGSIMAGES_FILTER_MORE_TAGS' => 'Filtrar por mais tags',
]);
