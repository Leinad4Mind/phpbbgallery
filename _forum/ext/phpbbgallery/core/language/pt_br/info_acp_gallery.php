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
	'ACP_GALLERY_ALBUM_MANAGEMENT'       => 'Gestão de álbuns',
	'ACP_GALLERY_ALBUM_PERMISSIONS'      => 'Permissões',
	'ACP_GALLERY_ALBUM_PERMISSIONS_COPY' => 'Copiar permissões',
	'ACP_GALLERY_CONFIGURE_GALLERY'      => 'Configurar galeria',
	'ACP_GALLERY_LOGS'                   => 'Registro da galeria',
	'ACP_GALLERY_LOGS_EXPLAIN'           => 'Apresenta todas as ações dos moderadores na galeria, incluindo aprovar, desaprovar, bloquear, desbloquear, fechar denúncias e excluir imagens.',
	'ACP_GALLERY_MANAGE_ALBUMS'          => 'Gerenciar Álbuns',
	'ACP_GALLERY_OVERVIEW'               => 'Visão Geral',
	'GALLERY'                            => 'Galeria',
	'GALLERY_EXPLAIN'                    => 'Galeria de imagens',
	'GALLERY_HELPLINE_ALBUM'             => 'Imagem da galeria: [image]image_id[/image]. Este BBCode permite adicionar uma imagem da galeria à sua mensagem.',
	'GALLERY_POPUP'                      => 'Galeria',
	'GALLERY_POPUP_HELPLINE'             => 'Abrir uma janela onde você pode selecionar suas imagens recentes e enviar novas imagens.',
	'GALLERY_COPYRIGHT'                  => 'Powered by <a href="https://github.com/satanasov/phpbbgallery">phpBB Gallery</a> &copy; 2014–2026',
	'GALLERY_TRANSLATION_INFO'           => 'Tradução brasileira por Leinad4Mind.',
	'IMAGES'                             => 'Imagens',
	'IMG_BUTTON_UPLOAD_IMAGE'            => 'Enviar imagem',
	'PERSONAL_ALBUM'                     => 'Álbum pessoal',
	'PHPBB_GALLERY'                      => 'phpBB Gallery',
	'TOTAL_IMAGES_SPRINTF'               => [
		'Total de imagens <strong>0</strong>',
		'Total de imagens <strong>%d</strong>',
	],
]);
