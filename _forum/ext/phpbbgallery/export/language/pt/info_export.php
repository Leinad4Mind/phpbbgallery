<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> 'O phpBB Gallery Core não está instalado! Transfere-o e instala-o antes desta extensão.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'A extensão foi ativada com sucesso.',

	'EXPORT_SELECTION'				=> 'O que exportar',
	'EXPORT_ALBUMS'					=> 'Álbuns',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Escolhe um ou mais álbuns. Mantém o Ctrl premido para selecionar vários.',
	'EXPORT_ALL_ALBUMS'				=> 'Exportar a galeria inteira, ignorando a seleção acima',
	'EXPORT_DELIVERY'				=> 'Destino do arquivo',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Um arquivo deixado no servidor é escrito em %s e nunca é removido automaticamente, para que o possas ir buscar por FTP quando quiseres.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Disponibilizar para transferência',
	'EXPORT_DELIVERY_SERVER'		=> 'Deixar no servidor',
	'EXPORT_LIMITS'					=> 'Limites',
	'EXPORT_LIMITS_EXPLAIN'			=> 'No máximo %1$d imagens e %2$s por exportação, escritas %3$d imagens de cada vez.',
	'EXPORT_SETTINGS'				=> 'Definições de exportação',
	'EXPORT_MAX_IMAGES'				=> 'Máximo de imagens por exportação',
	'EXPORT_MAX_IMAGES_EXPLAIN'		=> 'Número máximo de imagens permitido numa exportação. O limite de segurança é %d.',
	'EXPORT_MAX_SIZE_MIB'			=> 'Tamanho máximo por exportação (MiB)',
	'EXPORT_MAX_SIZE_MIB_EXPLAIN'	=> 'Tamanho máximo combinado dos ficheiros originais. O limite de segurança é %d MiB.',
	'EXPORT_BATCH_SIZE'				=> 'Imagens por lote',
	'EXPORT_BATCH_SIZE_EXPLAIN'		=> 'Número de imagens escritas em cada pedido. Valores menores reduzem o uso de memória e o risco de timeout. O limite de segurança é %d.',
	'EXPORT_SETTINGS_SAVED'			=> 'As definições de exportação foram guardadas.',
	'EXPORT_START'					=> 'Iniciar exportação',
	'EXPORT_CONTINUE'				=> 'Continuar',
	'EXPORT_DOWNLOAD'				=> 'Transferir',

	'EXPORT_STARTED'				=> [
		1	=> 'Começou a exportação de %d imagem.',
		2	=> 'Começou a exportação de %d imagens.',
	],
	'EXPORT_PROGRESS'				=> 'Exportadas %1$d de %2$d imagens…',
	'EXPORT_FINISHED'				=> [
		1	=> 'A exportação terminou com %d imagem.',
		2	=> 'A exportação terminou com %d imagens.',
	],

	'EXPORT_JOBS'					=> 'Exportações',
	'EXPORT_NO_JOBS'				=> 'Ainda não existe nenhuma exportação.',
	'EXPORT_JOB_ARCHIVE'			=> 'Arquivo',
	'EXPORT_JOB_CREATED'			=> 'Iniciada',
	'EXPORT_JOB_PROGRESS'			=> 'Progresso',
	'EXPORT_JOB_SIZE'				=> 'Tamanho',
	'EXPORT_JOB_ACTION'				=> 'Ação',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> 'Não foi possível adicionar %d imagem.',
		2	=> 'Não foi possível adicionar %d imagens.',
	],
	'EXPORT_JOB_DELETED'			=> 'A exportação foi eliminada.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Essa exportação não existe ou não te pertence.',
	'EXPORT_STATUS_READY'			=> 'Pronta',
	'EXPORT_STATUS_RUNNING'			=> 'Em curso',

	'EXPORT_UCP_EXPLAIN'			=> 'Aqui podes transferir as imagens que enviaste, com os nomes que a galeria mostra em vez dos nomes com que ficam guardadas no disco. Até %d imagens por exportação.',
	'EXPORT_UCP_DISABLED'			=> 'O administrador do fórum desativou a exportação das tuas próprias imagens.',

	'EXPORT_NO_IMAGES'				=> 'Não há imagens para exportar.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Uma exportação pode abranger no máximo %d imagens. Exporta menos álbuns de cada vez.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Uma exportação pode ter no máximo %s. Exporta menos álbuns de cada vez.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'Não há espaço livre suficiente no servidor para esta exportação.',
	'EXPORT_ARCHIVE_FAILED'			=> 'Não foi possível escrever o arquivo.',
	'EXPORT_ARCHIVE_MISSING'		=> 'O arquivo desta exportação já não está no servidor.',
	'EXPORT_STATE_FAILED'			=> 'Não foi possível guardar o estado desta exportação. Verifica se a pasta de exportação tem permissões de escrita.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'A imagem %1$d foi ignorada: o ficheiro “%2$s” não está no servidor.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'A imagem %1$d foi ignorada: não foi possível ler o ficheiro “%2$s”.',
	'EXPORT_ERROR_ARCHIVE'			=> 'Não foi possível escrever o arquivo “%s”.',
]);
