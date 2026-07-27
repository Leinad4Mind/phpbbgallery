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
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Revisões de imagens',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Configura o histórico opcional de substituição e restauro de imagens.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Definições das revisões',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Activar revisões de imagens',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Permite aos editores substituir ficheiros e restaurar versões retidas. Cada revisão utiliza armazenamento adicional.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Revisões retidas por imagem',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Escolhe entre 1 e 50. Os ficheiros mais antigos são eliminados automaticamente.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'As definições das revisões de imagens foram actualizadas.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Pode gerir as definições das revisões de imagens da Galeria',
]);
