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
	'ACP_UPLOAD_IMAGE_TITLE' => 'Carregar imagens',
	'ACP_IMAGE_TITLE' => 'Carregar imagem',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN' => 'Carrega ficheiros GIF, JPEG e PNG para a pasta images/%1$s do fórum. Usa o botão de cópia para copiar o caminho de uma imagem. A eliminação não verifica se a imagem ainda é referenciada noutro local.',
	'IMAGE_LIST' => 'Pasta de imagens',
	'IMAGE_PATH' => 'Caminho da imagem',
	'IMAGE_NAME' => 'Nome da imagem',
	'FORMAT' => 'Dimensões',
	'SIZE' => 'Tamanho',
	'FOLDER_SIZE' => 'Tamanho da pasta',
	'IMG_FOLDER' => 'Pasta de carregamento',
	'ACP_IMAGE_COPY_PATH' => 'Copiar caminho da imagem',
	'IMAGE_DELETE' => 'Eliminar',
	'ACP_IMAGE_DELETE_CONFIRM' => 'Tens a certeza de que pretendes eliminar esta imagem?',
	'ACP_IMAGE_DELETE_SUCCESS' => 'Imagem eliminada.',
	'ACP_IMAGE_DELETED_LOG' => '<strong>Imagem eliminada</strong><br />» %1$s',
	'UPLOADIMAGE_NOTICE' => '<div class="phpinfo"><p class="entry">Esta extensão está disponível em %1$s » %2$s » %3$s.</p></div>',
	'FH_HELPER_NOTICE' => 'É necessário o Forumhulp Helper. Instala e ativa <a href="https://github.com/ForumHulp/helper" target="_blank" rel="noopener noreferrer">forumhulp/helper</a>.',
	'DESCRIPTION_PAGE' => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Notas da extensão',
	'ext_details' => [
		'details' => [
			'DESCRIPTION_1' => 'Pré-visualização de imagens',
			'DESCRIPTION_2' => 'Até 10 carregamentos em fila',
			'DESCRIPTION_3' => 'Dimensões e tamanho dos ficheiros',
			'DESCRIPTION_4' => 'Cópia do caminho com um clique',
		],
		'note' => [
			'NOTICE_1' => 'O tamanho efetivo de carregamento é limitado pelo PHP e pelo phpBB.',
			'NOTICE_2' => 'Compatível com phpBB 3.3 e PHP 8.1 ou superior.',
		],
	],
]);
