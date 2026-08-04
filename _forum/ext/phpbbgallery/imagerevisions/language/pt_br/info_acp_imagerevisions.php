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
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Revisões de imagens neste álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Cada configuração pode herdar o valor efetivo do álbum pai mais próximo ou da configuração global.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Herdar',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Configuração efetiva: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Valor efetivo: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Revisões por álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Esta visão geral, somente leitura, segue a hierarquia de álbuns da Galeria. Use Editar para alterar um álbum ou subálbum.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Herdado',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Configuração direta',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Definido como %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'Não há álbuns públicos na Galeria.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Pode gerenciar as configurações das revisões de imagens da Galeria',
]);
