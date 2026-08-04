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
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Ativar revisões de imagens',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Permite aos editores substituir ficheiros e restaurar versões retidas. Cada revisão utiliza armazenamento adicional.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Revisões retidas por imagem',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Escolhe entre 1 e 50. Os ficheiros mais antigos são eliminados automaticamente.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'As definições das revisões de imagens foram atualizadas.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Revisões de imagens neste álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Cada definição pode herdar o valor efetivo do álbum antecessor mais próximo ou da definição global.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Herdar',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Definição efetiva: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Valor efetivo: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Revisões por álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Esta visão geral, apenas de leitura, segue a hierarquia de álbuns da Galeria. Usa Editar para alterar um álbum ou subálbum.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Herdado',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Definição direta',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Definido como %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'Não existem álbuns públicos na Galeria.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Pode gerir as definições das revisões de imagens da Galeria',
]);
