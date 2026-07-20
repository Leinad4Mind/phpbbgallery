<?php

/**
 * @package Ext Common Core for phpBB.
 * [English [En]]
 * @version 1.1.2 20/09/2023
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

// @ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'COPY_TO_LIST'         => 'Copiar para a lista atual',
	'CREATE_SERVER_COPY'   => 'Criar cópia neste servidor',
	'DELETE_FROM_LIST'     => 'Remover da lista',
	'DELETE_ICON'          => 'Excluir ícone',
	'DELETE_IMAGE'         => 'Excluir imagem',
	'DELETE_PERMANENTLY'   => 'Excluir permanentemente',
	'ICON_PREVIEW'         => 'Pré-visualização do ícone',
	'IMAGE_DESCRIPTION'    => 'Descrição',
	'IMAGE_DETAILS'        => 'Detalhes da imagem',
	'IMAGE_DIMENSIONS'     => '<%width%> × <%height%> pixels',
	'IMAGE_SAVE_ERROR'     => 'Não foi possível guardar a imagem',
	'IMAGE_TITLE'          => 'Título',
	'IMAGE_URL'            => 'Url',
	'INSERT_ON_ENTRY'      => 'Inserir no texto',
	'FILES_DELETED'        => 'Arquivos eliminados',
	'FILES_DRAG'           => 'Arrasta e larga os arquivos para enviar',
	'FILES_DROP'           => 'Larga os arquivos para enviar',
	'FILES_REMOVE_CONFIRM' => 'Está prestes a Excluir permanentemente os arquivos selecionados.<br />Queres continuar?',
	'FORMAT_INVALID'       => 'Formato inválido',
	'MAX_IMAGESIZE'        => 'As imagens serão redimensionadas para %d x %d pixels.',
	'MAX_FILESIZE'         => 'Tamanho máximo do arquivo: %s.',
	'MEDIA_UPDATED'        => 'Alterações guardadas',
	'OR'                   => 'ou',
	'PROCCESS'             => 'Processar',
	'SELECT_ICON'          => 'Selecionar novo ícone',
	'SELECT_IMAGE'         => 'Selecionar nova imagem',
	'SELECT_FILE'          => 'Selecionar arquivo',
	'SELECT_FILES'         => 'Selecionar arquivos',
	'SELECTED_COUNT'       => '<span class="value">0</span> selecionados',
	'SET_ICON'             => 'Definir ícone',
	'SET_IMAGE'            => 'Definir imagem',
	'UPDATE'               => 'Atualizar',
	'UPLOADING_FILES'      => 'A enviar os arquivos...',

	'CURRENT_LIST' => 'Lista atual',
	'GALLERY'      => 'Galeria',
	'ICONS'        => 'Ícones',
	'INSERT_URL'   => 'Inserir do URL',
	'UPLOAD_IMAGE' => 'Enviar Imagem',

	'ICON_BRAND'           => 'Marca',
	'ICON_DIRECTIONAL'     => 'Direcional',
	'ICON_FILE_TYPE'       => 'Tipo de arquivo',
	'ICON_GENDER'          => 'Género',
	'ICON_HAND'            => 'Mão',
	'ICON_MEDICAL'         => 'Medicina',
	'ICON_PAYMENT'         => 'Pagamento e Moeda',
	'ICON_TEXT_EDITOR'     => 'Editor de Texto',
	'ICON_TRANSPORTATION'  => 'Transporte',
	'ICON_VIDEO_PLAYER'    => 'Reprodutor de Vídeo',
	'ICON_WEB_APPLICATION' => 'Aplicação Web',
]);
