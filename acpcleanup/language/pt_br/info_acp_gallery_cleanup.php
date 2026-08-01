<?php

/**
 * @package phpbbgallery/acpcleanup for phpBB.
 * phpBB Gallery - ACP CleanUp Extension [German Translation]
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
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
	'ACP_GALLERY_CLEANUP'                  => 'Limpar galeria',
	'ACP_GALLERY_CLEANUP_EXPLAIN'          => 'Aqui pode excluir alguns vestígios.',
	'CLEAN_AUTHORS_DONE'                   => 'Imagens sem autor válido excluídas.',
	'CLEAN_CHANGED'                        => 'Autor alterado para "Visitante".',
	'CLEAN_COMMENTS_DONE'                  => 'Comentários sem autor válido excluídos.',
	'CLEAN_ENTRIES_DONE'                   => 'Arquivos sem entrada na base de dados excluídos.',
	'CLEAN_GALLERY'                        => 'Limpar galeria',
	'CLEAN_GALLERY_ABORT'                  => 'Limpeza cancelada!',
	'CLEAN_NO_ACTION'                      => 'Nenhuma ação concluída. Algo correu mal!',
	'CLEAN_PERSONALS_DONE'                 => 'Álbuns pessoais sem proprietário válido excluídos.',
	'CLEAN_PERSONALS_BAD_DONE'             => 'Álbuns pessoais de usuários selecionados excluídos.',
	'CLEAN_PRUNE_DONE'                     => 'Imagens expurgadas com sucesso.',
	'CLEAN_PRUNE_NO_PATTERN'               => 'Nenhum padrão de pesquisa.',
	'CLEAN_SOURCES_DONE'                   => 'Imagens sem arquivo excluídas.',
	'CONFIRM_CLEAN'                        => 'Este passo não pode ser desfeito!',
	'CONFIRM_CLEAN_AUTHORS'                => 'Excluir imagens sem autor válido?',
	'CONFIRM_CLEAN_COMMENTS'               => 'Excluir comentários sem autor válido?',
	'CONFIRM_CLEAN_ENTRIES'                => 'Excluir arquivos sem entrada na base de dados?',
	'CONFIRM_CLEAN_PERSONALS'              => 'Excluir álbuns pessoais sem proprietário válido?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_PERSONALS_BAD'          => 'Excluir álbuns pessoais de usuários selecionados?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_SOURCES'                => 'Excluir imagens sem arquivo?',
	'CONFIRM_PRUNE'                        => 'Excluir todas as imagens que cumpram as seguintes condições:<br /><br />%s<br />',
	'PRUNE'                                => 'Expurgar',
	'PRUNE_ALBUMS'                         => 'Expurgar álbuns',
	'PRUNE_CHECK_OPTION'                   => 'Marque esta opção ao expurgar imagens.',
	'PRUNE_COMMENTS'                       => 'Menos de x comentários',
	'PRUNE_PATTERN_ALBUM_ID'               => 'A imagem está num dos seguintes álbuns:<br />» <strong>%s</strong>',
	'PRUNE_PATTERN_COMMENTS'               => 'A imagem tem menos de <strong>%d</strong> comentários.',
	'PRUNE_PATTERN_RATES'                  => 'A imagem tem menos de <strong>%d</strong> classificações.',
	'PRUNE_PATTERN_RATE_AVG'               => 'A imagem tem uma classificação média inferior a <strong>%s</strong>.',
	'PRUNE_PATTERN_TIME'                   => 'A imagem foi enviada antes de "<strong>%s</strong>".',
	'PRUNE_PATTERN_USER_ID'                => 'A imagem foi enviada por um dos seguintes usuários:<br />» <strong>%s</strong>',
	'PRUNE_RATINGS'                        => 'Menos de x classificações',
	'PRUNE_RATING_AVG'                     => 'Classificação média inferior a',
	'PRUNE_RATING_AVG_EXP'                 => 'Apenas expurgar imagens com classificação média inferior a "<samp>x.yz</samp>".',
	'PRUNE_TIME'                           => 'Enviada antes de',
	'PRUNE_TIME_EXP'                       => 'Apenas expurgar imagens que foram enviadas antes de "<samp>AAAA-MM-DD</samp>".',
	'PRUNE_USERNAME'                       => 'Enviada por',
	'PRUNE_USERNAME_EXP'                   => 'Apenas expurgar imagens de certos usuários. Para expurgar de "visitantes", marque a caixa ao lado.',
	'LOG_CLEANUP_DELETE_FILES'             => '%s imagens sem entradas na BD foram excluídas.',
	'LOG_CLEANUP_DELETE_ENTRIES'           => '%s imagens sem arquivos foram excluídas.',
	'LOG_CLEANUP_DELETE_NO_AUTHOR'         => '%s imagens sem autor válido foram excluídas.',
	'LOG_CLEANUP_COMMENT_DELETE_NO_AUTHOR' => '%s comentários sem autor válido foram excluídos.',
	'MOVE_TO_IMPORT'                       => 'Mover imagens para a diretoria Import',
	'MOVE_TO_USER'                         => 'Mover para o usuário',
	'MOVE_TO_USER_EXP'                     => 'Imagens e comentários serão movidos para o usuário definido. Se não selecionar nenhum, será usado o Visitante.',
	'CLEAN_USER_NOT_FOUND'                 => 'O usuário selecionado não existe!',
	'GALLERY_LEGACY_BBCODE_MIGRATE' => 'Migrar BBCodes legados da Galeria',
	'GALLERY_LEGACY_BBCODE_MIGRATE_EXPLAIN' => 'Procura o alias oculto [album] em posts, mensagens privadas e assinaturas. Após a confirmação, cada execução reprocessa até 250 registros para %s e mantém consistentes os metadados dos BBCodes do phpBB. Repita a ação até não restarem registros.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_CONFIRM' => 'Converter o próximo lote de [album] para %2$s? Atualmente restam %1$d registros.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_NONE' => 'Não restam registros com o BBCode legado [album].',
	'GALLERY_LEGACY_BBCODE_MIGRATE_RESULT' => 'Foram convertidos %1$d registros. Não foi possível converter %2$d registros. Restam %3$d registros.',
	'GALLERY_CORE_NOT_FOUND'               => 'A extensão phpBB Gallery Core deve ser instalada e habilitada primeiro.',
	'EXTENSION_ENABLE_SUCCESS'             => 'A extensão foi habilitada com sucesso.',
]);
