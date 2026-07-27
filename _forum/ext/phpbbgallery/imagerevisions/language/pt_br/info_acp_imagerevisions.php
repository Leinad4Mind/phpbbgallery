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
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Configure o histórico opcional de substituição e restauração de imagens.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Configurações das revisões',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Ativar revisões de imagens',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Permite substituir arquivos e restaurar versões retidas. Cada revisão utiliza armazenamento adicional.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Revisões retidas por imagem',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Escolha entre 1 e 50. Os arquivos mais antigos são excluídos automaticamente.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'As configurações das revisões de imagens foram atualizadas.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Pode gerenciar as configurações das revisões de imagens da Galeria',
]);
