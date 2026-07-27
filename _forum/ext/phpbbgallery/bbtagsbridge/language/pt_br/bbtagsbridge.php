<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Imagens da galeria',
	'BBTAGSBRIDGE_TAGS' => 'Tags',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Adicione até %1$d tags separadas por vírgulas. Cada tag deve conter entre %2$d e %3$d caracteres. Novas tags são enviadas aos moderadores para aprovação.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Cada tag deve conter pelo menos %2$d caracteres.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Cada tag pode conter no máximo %3$d caracteres.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'Você pode adicionar no máximo %1$d tags a uma imagem.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'Novas tags permanecem ocultas até serem aprovadas por um moderador.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'Não foi possível salvar as tags da imagem.',
]);
