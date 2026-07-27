<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Imagens da galeria',
	'BBTAGSBRIDGE_TAGS' => 'Etiquetas',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Adicione até %1$d etiquetas separadas por vírgulas. Cada etiqueta deve conter entre %2$d e %3$d caracteres. As novas etiquetas são enviadas aos moderadores para aprovação.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Cada etiqueta deve conter pelo menos %2$d caracteres.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Cada etiqueta não pode conter mais de %3$d caracteres.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'Não pode adicionar mais de %1$d etiquetas a uma imagem.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'As novas etiquetas permanecem ocultas até serem aprovadas por um moderador.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'Não foi possível guardar as etiquetas da imagem.',
]);
