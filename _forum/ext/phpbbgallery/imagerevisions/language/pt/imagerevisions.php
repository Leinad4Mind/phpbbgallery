<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'REPLACE_IMAGE'                => 'Substituir ficheiro da imagem',
	'REPLACE_IMAGE_EXPLAIN'        => 'Seleciona uma nova imagem. O ID, a descrição, os comentários, as avaliações e as visualizações são preservados.',
	'IMAGE_REVISIONS'              => 'Ficheiros anteriores da imagem',
	'IMAGE_REVISIONS_EXPLAIN'      => 'Os ficheiros retidos podem ser pré-visualizados e restaurados. Ao restaurar, o ficheiro atual permanece no histórico.',
	'RESTORE_REVISION'             => 'Restaurar esta versão',
	'IMAGE_REPLACE_FAILED'         => 'Não foi possível aplicar o ficheiro de substituição em segurança.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'Esta revisão da imagem já não está disponível.',
	'IMAGE_REVISION_RESTORED'      => 'A revisão da imagem foi restaurada com sucesso.',
]);
