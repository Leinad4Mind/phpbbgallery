<?php

/**
 * @package Upload Image for phpBB.
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_UPLOAD_IMAGE_TITLE'         => 'Carregar Imagens',
	'ACP_IMAGE_TITLE'                => 'Carregar Imagem',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN' => 'Carregar Imagens permite-lhe carregar imagens na pasta de imagens do seu fórum. A pasta %1$s é usada para as imagens e é criada automaticamente quando ativa esta extensão.<br />Copie o caminho da imagem simplesmente clicando e use-o onde quiser mostrar a sua imagem. Tenha cuidado ao eliminar imagens, pois não há verificação se a imagem ainda está a ser usada.',
	'IMAGE_LIST'                     => 'Pasta de imagens',
	'IMAGE_PATH'                     => 'Caminho da imagem',
	'IMAGE_NAME'                     => 'Nome da imagem',
	'FORMAT'                         => 'Formato',
	'SIZE'                           => 'Tamanho',
	'FOLDER_SIZE'                    => 'Tamanho da pasta',
	'IMG_FOLDER'                     => 'Mudar a pasta de imagens para onde as imagens são carregadas',
	'ACP_IMAGE_COPY_PATH'            => 'Copiar caminho da imagem',
	'IMAGE_DELETE'                   => 'Eliminar',
	'ACP_IMAGE_DELETE_CONFIRM'       => 'Tem a certeza que deseja eliminar a imagem?',
	'ACP_IMAGE_DELETE_SUCCESS'       => 'Imagem eliminada',
	'ACP_IMAGE_DELETED_LOG'          => '<strong>Imagem eliminada</strong><br />» %1s',
	'UPLOADIMAGE_NOTICE'             => '<div class="phpinfo"><p class="entry">Esta extensão reside em %1$s » %2$s » %3$s.<br />Carregue imagens do tamanho que deseja usar!</p></div>',
	'FH_HELPER_NOTICE'               => 'A aplicação ajudante forumhulp não existe!<br />Descarregue <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
]);
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Pré-visualização de imagens',
			'DESCRIPTION_2' => 'Carregue até 10 imagens',
			'DESCRIPTION_3' => 'Informação da imagem',
			'DESCRIPTION_4' => 'Cópia fácil de caminhos',
		],
		'note' => [
			'NOTICE_1' => 'Tamanho de formato livre',
			'NOTICE_2' => 'Pronto para 3.2.',
		]
	]
]);
