<?php

/**
 * @package phpbbgallery/acpimport for phpBB.
 * phpBB Gallery - ACP Import Extension
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_IMPORT_ALBUMS'          => 'Importar Imagens',
	'ACP_IMPORT_ALBUMS_EXPLAIN'  => 'Aqui pode importar em massa imagens do sistema de ficheiros. Antes de importar as imagens, por favor redimensione-as manualmente.',
	'IMPORT_ARCHIVES'            => 'Arquivos ZIP',
	'IMPORT_ARCHIVES_SELECT'     => 'Escolhe os arquivos que queres descompactar. As imagens são colocadas na pasta de importação, onde depois podes escolher as que queres importar. Os arquivos descompactados são eliminados.',
	'IMPORT_EXTRACT'             => 'Extrair',
	'IMPORT_NO_ARCHIVES'         => 'Não há arquivos ZIP na pasta de importação.',
	'IMPORT_ZIP_ALL_EXTRACTED'   => 'Foram extraídas %1$d imagens de %2$d arquivos. Escolhe abaixo as que queres importar.',
	'IMPORT_ZIP_EXTRACTED'       => 'Foram extraídas %1$d imagens de “%2$s”.',
	'IMPORT_ZIP_FAILED'          => 'Não foi possível extrair o arquivo “%s”.',
	'IMPORT_ZIP_MAX_IMAGES'      => 'Imagens por arquivo',
	'IMPORT_ZIP_MAX_IMAGES_EXPLAIN' => 'Quantas imagens um único arquivo pode fornecer. Um arquivo nunca é lido para além de 1000 entradas, pelo que esse é também o valor máximo útil.',
	'IMPORT_ZIP_SETTINGS'        => 'Arquivos ZIP',
	'IMPORT_ZIP_SETTINGS_SAVED'  => 'As definições dos arquivos foram guardadas.',
	'IMPORT_ALBUM'               => 'Álbum para onde importar imagens:',
	'IMPORT_DEBUG_MES'           => '%1$s imagens importadas. Faltam %2$s imagens.',
	'IMPORT_DIR_EMPTY'           => 'A pasta %s está vazia. Tem de carregar as imagens antes de as poder importar.',
	'IMPORT_FINISHED'            => 'Todas as %1$s imagens foram importadas com sucesso.',
	'IMPORT_FINISHED_ERRORS'     => '%1$s imagens foram importadas com sucesso, mas ocorreram os seguintes erros:<br /><br />',
	'IMPORT_MISSING_ALBUM'       => 'Por favor, selecione um álbum para onde importar as imagens.',
	'IMPORT_SELECT'              => 'Escolha as imagens que deseja importar. As imagens importadas com sucesso serão eliminadas. Todas as outras imagens continuarão disponíveis.',
	'IMPORT_SCHEMA_CREATED'      => 'O esquema de importação foi criado com sucesso, aguarde enquanto as imagens são importadas.',
	'IMPORT_INVALID_IMAGE'       => 'O ficheiro selecionado «%s» não é uma imagem permitida da pasta de importação.',
	'IMPORT_SCHEMA_WRITE_FAILED' => 'Não foi possível guardar o estado da importação em segurança.',
	'IMPORT_TOO_MANY_IMAGES'     => 'Pode importar, no máximo, %d imagens de cada vez.',
	'IMPORT_UNREADABLE_FILES'    => 'Foram ignorados %d ficheiros com nomes ilegíveis.',
	'IMPORT_USER'                => 'Enviadas por',
	'IMPORT_USER_EXP'            => 'Pode atribuir as imagens a outro utilizador aqui.',
	'IMPORT_USERS_PEGA'          => 'Enviar para a galeria pessoal dos utilizadores.',
	'MISSING_IMPORT_SCHEMA'      => 'O esquema de importação especificado (%s) não pôde ser encontrado.',
	'NO_FILE_SELECTED'           => 'Tem de selecionar pelo menos um ficheiro.',
	'GALLERY_CORE_NOT_FOUND'     => 'A extensão phpBB Gallery Core deve ser instalada e ativada primeiro.',
	'EXTENSION_ENABLE_SUCCESS'   => 'A extensão foi ativada com sucesso.',
]);
