<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'GALLERY_CORE_NOT_FOUND'		=> 'O phpBB Gallery Core não está instalado! Baixe-o e instale-o antes desta extensão.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'A extensão foi ativada com sucesso.',

	'EXPORT_SELECTION'				=> 'O que exportar',
	'EXPORT_ALBUMS'					=> 'Álbuns',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Escolha um ou mais álbuns. Mantenha o Ctrl pressionado para selecionar vários.',
	'EXPORT_ALL_ALBUMS'				=> 'Exportar a galeria inteira, ignorando a seleção acima',
	'EXPORT_DELIVERY'				=> 'Destino do arquivo',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Um arquivo deixado no servidor é gravado em %s e nunca é removido automaticamente, então você pode buscá-lo por FTP quando quiser.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Disponibilizar para download',
	'EXPORT_DELIVERY_SERVER'		=> 'Deixar no servidor',
	'EXPORT_LIMITS'					=> 'Limites',
	'EXPORT_LIMITS_EXPLAIN'			=> 'No máximo %1$d imagens e %2$s por exportação, gravando %3$d imagens por vez.',
	'EXPORT_SETTINGS'				=> 'Configurações de exportação',
	'EXPORT_MAX_IMAGES'				=> 'Máximo de imagens por exportação',
	'EXPORT_MAX_IMAGES_EXPLAIN'		=> 'Número máximo de imagens permitido em uma exportação. O limite de segurança é %d.',
	'EXPORT_MAX_SIZE_MIB'			=> 'Tamanho máximo por exportação (MiB)',
	'EXPORT_MAX_SIZE_MIB_EXPLAIN'	=> 'Tamanho máximo combinado dos arquivos originais. O limite de segurança é %d MiB.',
	'EXPORT_BATCH_SIZE'				=> 'Imagens por lote',
	'EXPORT_BATCH_SIZE_EXPLAIN'		=> 'Número de imagens gravadas em cada requisição. Valores menores reduzem o uso de memória e o risco de timeout. O limite de segurança é %d.',
	'EXPORT_SETTINGS_SAVED'			=> 'As configurações de exportação foram salvas.',
	'EXPORT_START'					=> 'Iniciar exportação',
	'EXPORT_CONTINUE'				=> 'Continuar',
	'EXPORT_DOWNLOAD'				=> 'Baixar',

	'EXPORT_STARTED'				=> [
		1	=> 'A exportação de %d imagem foi iniciada.',
		2	=> 'A exportação de %d imagens foi iniciada.',
	],
	'EXPORT_PROGRESS'				=> 'Exportando %1$d de %2$d imagens…',
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
	'EXPORT_JOB_DELETED'			=> 'A exportação foi excluída.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Essa exportação não existe ou não pertence a você.',
	'EXPORT_STATUS_READY'			=> 'Pronta',
	'EXPORT_STATUS_RUNNING'			=> 'Em andamento',

	'EXPORT_UCP_EXPLAIN'			=> 'Aqui você pode baixar as imagens que enviou, com os nomes que a galeria mostra em vez dos nomes com que ficam salvas no disco. Até %d imagens por exportação.',
	'EXPORT_UCP_DISABLED'			=> 'O administrador do fórum desativou a exportação das suas próprias imagens.',

	'EXPORT_NO_IMAGES'				=> 'Não há imagens para exportar.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Uma exportação pode abranger no máximo %d imagens. Exporte menos álbuns por vez.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Uma exportação pode ter no máximo %s. Exporte menos álbuns por vez.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'Não há espaço livre suficiente no servidor para esta exportação.',
	'EXPORT_ARCHIVE_FAILED'			=> 'Não foi possível gravar o arquivo.',
	'EXPORT_ARCHIVE_MISSING'		=> 'O arquivo desta exportação não está mais no servidor.',
	'EXPORT_STATE_FAILED'			=> 'Não foi possível salvar o estado desta exportação. Verifique se a pasta de exportação tem permissão de escrita.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'A imagem %1$d foi ignorada: o arquivo “%2$s” não está no servidor.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'A imagem %1$d foi ignorada: não foi possível ler o arquivo “%2$s”.',
	'EXPORT_ERROR_ARCHIVE'			=> 'Não foi possível gravar o arquivo “%s”.',
]);
