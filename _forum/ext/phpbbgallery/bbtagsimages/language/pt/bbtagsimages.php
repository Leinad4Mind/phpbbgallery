<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Imagens da galeria',
	'BBTAGSIMAGES_TAGS' => 'Etiquetas',
	'BBTAGSIMAGES_TAGS_EXPLAIN' => 'Adicione até %1$d etiquetas separadas por vírgulas. Cada etiqueta deve conter entre %2$d e %3$d caracteres. As novas etiquetas são enviadas aos moderadores para aprovação.',
	'BBTAGSIMAGES_TAG_TOO_SHORT' => 'Cada etiqueta deve conter pelo menos %2$d caracteres.',
	'BBTAGSIMAGES_TAG_TOO_LONG' => 'Cada etiqueta não pode conter mais de %3$d caracteres.',
	'BBTAGSIMAGES_TAG_LIMIT' => 'Não pode adicionar mais de %1$d etiquetas a uma imagem.',
	'BBTAGSIMAGES_PENDING_NOTICE' => 'As novas etiquetas permanecem ocultas até serem aprovadas por um moderador.',
	'BBTAGSIMAGES_SAVE_FAILED' => 'Não foi possível guardar as etiquetas da imagem.',
	'BBTAGSIMAGES_SEARCH_TAGS' => 'Pesquisar por etiquetas',
	'BBTAGSIMAGES_SEARCH_TAGS_EXPLAIN' => 'Introduza uma ou mais etiquetas separadas por vírgulas.',
	'BBTAGSIMAGES_MATCH_ALL_TAGS' => 'Corresponder a todas as etiquetas (E)',
	'BBTAGSIMAGES_MATCH_ANY_TAG' => 'Corresponder a qualquer etiqueta (OU)',
	'BBTAGSIMAGES_FILTER_MORE_TAGS' => 'Filtrar por mais etiquetas',
]);
