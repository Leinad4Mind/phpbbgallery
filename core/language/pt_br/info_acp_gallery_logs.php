<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_LOG_GALLERY_MOD'                   => 'Registro de moderação',
	'ACP_LOG_GALLERY_MOD_EXP'               => 'Registro de moderação',
	'ACP_LOG_GALLERY_ADM'                   => 'Registro de administração',
	'ACP_LOG_GALLERY_ADM_EXP'               => 'Registro de administração',
	'ACP_LOG_GALLERY_SYSTEM'                => 'Registro do sistema',
	'ACP_LOG_GALLERY_SYSTEM_EXP'            => 'Registro do sistema',
	'LOG_GALLERY_SHOW_LOGS'                 => 'Mostrar apenas',
	'SORT_USER_ID'                          => 'ID do usuário',
	'LOG_ALBUM_ADD'                         => '<strong>Novo álbum criado</strong><br />» %s',
	'LOG_ALBUM_DEL_ALBUM'                   => '<strong>Álbum excluído</strong><br />» %s',
	'LOG_ALBUM_DEL_ALBUMS'                  => '<strong>Álbum e seus subálbuns excluídos</strong><br />» %s',
	'LOG_ALBUM_DEL_MOVE_ALBUMS'             => '<strong>Álbum excluído e sub-álbuns movidos</strong> para %1$s<br />» %2$s',
	'LOG_ALBUM_DEL_MOVE_IMAGES'             => '<strong>Álbum excluído e imagens movidas</strong> para %1$s<br />» %2$s',
	'LOG_ALBUM_DEL_MOVE_IMAGES_ALBUMS'      => '<strong>Álbum excluído e imagens e sub-álbuns movidos</strong> para %1$s<br />» %2$s',
	'LOG_ALBUM_DEL_MOVE_IMAGES_MOVE_ALBUMS' => '<strong>Álbum excluído; imagens movidas</strong> para %1$s <strong>e subálbuns</strong> para %2$s<br />» %3$s',
	'LOG_ALBUM_DEL_IMAGES'                  => '<strong>Álbum e suas imagens excluídos</strong><br />» %s',
	'LOG_ALBUM_DEL_IMAGES_ALBUMS'           => '<strong>Álbum, imagens e subálbuns excluídos</strong><br />» %s',
	'LOG_ALBUM_DEL_IMAGES_MOVE_ALBUMS'      => '<strong>Álbum e imagens excluídos, sub-álbuns movidos</strong> para %1$s<br />» %2$s',
	'LOG_ALBUM_EDIT'                        => '<strong>Detalhes do álbum editados</strong><br />» %s',
	'LOG_ALBUM_MOVE_DOWN'                   => '<strong>Álbum movido para baixo</strong> %1$s<br />» %2$s',
	'LOG_ALBUM_MOVE_UP'                     => '<strong>Álbum movido para cima</strong> %1$s<br />» %2$s',
	'LOG_ALBUM_SYNC'                        => '<strong>Álbum sincronizado</strong><br />» %s',
	'LOG_CLEAR_GALLERY'                     => '<strong>Registro da Galeria limpo</strong>',
	'LOG_GALLERY_APPROVED'                  => '<strong>Imagens aprovadas</strong><br />» %s',
	'LOG_GALLERY_COMMENT_DELETED'           => '<strong>Comentário excluído</strong><br />» %s',
	'LOG_GALLERY_COMMENT_EDITED'            => '<strong>Comentário editado</strong><br />» %s',
	'LOG_GALLERY_DELETED'                   => '<strong>Imagens excluídas</strong><br />» %s',
	'LOG_GALLERY_EDITED'                    => '<strong>Imagens editadas</strong><br />» %s',
	'LOG_GALLERY_LOCKED'                    => '<strong>Imagens bloqueadas</strong><br />» %s',
	'LOG_GALLERY_UNLOCKED'                  => '<strong>Imagens desbloqueadas</strong><br />» %s',
	'LOG_GALLERY_MOVED'                     => '<strong>Imagens movidas</strong><br />» de %1$s para %2$s',
	'LOG_GALLERY_REPORT_CLOSED'             => '<strong>Denúncia fechado</strong><br />» %s',
	'LOG_GALLERY_REPORT_DELETED'            => '<strong>Denúncia excluído</strong><br />» %s',
	'LOG_GALLERY_REPORT_OPENED'             => '<strong>Denúncia aberto</strong><br />» %s',
	'LOG_GALLERY_UNAPPROVED'                => '<strong>Imagens desaprovadas</strong><br />» %s',
	'LOG_GALLERY_DISAPPROVED'               => '<strong>Imagens reprovadas</strong><br />» %s',
	'LOGVIEW_VIEWALBUM'                     => 'Ver álbum',
	'LOGVIEW_VIEWIMAGE'                     => 'Ver imagem',
]);
