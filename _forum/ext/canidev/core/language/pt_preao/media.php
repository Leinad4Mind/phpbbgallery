<?php

/**
 * @package Ext Common Core for phpBB.
 * [English [En]]
 * @version 1.1.2 20/09/2023
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'COPY_TO_LIST'         => 'Copiar para a lista actual',
	'CREATE_SERVER_COPY'   => 'Criar cópia neste servidor',
	'DELETE_FROM_LIST'     => 'Remover da lista',
	'DELETE_ICON'          => 'Eliminar ícone',
	'DELETE_IMAGE'         => 'Eliminar imagem',
	'DELETE_PERMANENTLY'   => 'Eliminar permanentemente',
	'ICON_PREVIEW'         => 'Pré-visualização do ícone',
	'IMAGE_DESCRIPTION'    => 'Descrição',
	'IMAGE_DETAILS'        => 'Detalhes da imagem',
	'IMAGE_DIMENSIONS'     => '<%width%> × <%height%> pixels',
	'IMAGE_SAVE_ERROR'     => 'Não foi possível guardar a imagem',
	'IMAGE_TITLE'          => 'Título',
	'IMAGE_URL'            => 'Url',
	'INSERT_ON_ENTRY'      => 'Inserir no texto',
	'FILES_DELETED'        => 'Ficheiros eliminados',
	'FILES_DRAG'           => 'Arrasta e larga os ficheiros para enviar',
	'FILES_DROP'           => 'Larga os ficheiros para enviar',
	'FILES_REMOVE_CONFIRM' => 'Estás prestes a Eliminar permanentemente os ficheiros seleccionados.<br />Queres continuar?',
	'FORMAT_INVALID'       => 'Formato inválido',
	'MAX_IMAGESIZE'        => 'As imagens serão redimensionadas para %d x %d pixels.',
	'MAX_FILESIZE'         => 'Tamanho máximo do ficheiro: %s.',
	'MEDIA_UPDATED'        => 'Alterações guardadas',
	'OR'                   => 'ou',
	'PROCCESS'             => 'Processar',
	'SELECT_ICON'          => 'Seleccionar novo ícone',
	'SELECT_IMAGE'         => 'Seleccionar nova imagem',
	'SELECT_FILE'          => 'Seleccionar ficheiro',
	'SELECT_FILES'         => 'Seleccionar ficheiros',
	'SELECTED_COUNT'       => '<span class="value">0</span> seleccionados',
	'SET_ICON'             => 'Definir ícone',
	'SET_IMAGE'            => 'Definir imagem',
	'UPDATE'               => 'Actualizar',
	'UPLOADING_FILES'      => 'A enviar os ficheiros...',

	'CURRENT_LIST' => 'Lista actual',
	'GALLERY'      => 'Galeria',
	'ICONS'        => 'Ícones',
	'INSERT_URL'   => 'Inserir do URL',
	'UPLOAD_IMAGE' => 'Enviar Imagem',

	'ICON_BRAND'           => 'Marca',
	'ICON_DIRECTIONAL'     => 'Direcional',
	'ICON_FILE_TYPE'       => 'Tipo de ficheiro',
	'ICON_GENDER'          => 'Género',
	'ICON_HAND'            => 'Mão',
	'ICON_MEDICAL'         => 'Medicina',
	'ICON_PAYMENT'         => 'Pagamento e Moeda',
	'ICON_TEXT_EDITOR'     => 'Editor de Texto',
	'ICON_TRANSPORTATION'  => 'Transporte',
	'ICON_VIDEO_PLAYER'    => 'Reprodutor de Vídeo',
	'ICON_WEB_APPLICATION' => 'Aplicação Web',
]);
