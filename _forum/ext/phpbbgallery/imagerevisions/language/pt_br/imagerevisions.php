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
	'REPLACE_IMAGE'                => 'Substituir arquivo da imagem',
	'REPLACE_IMAGE_EXPLAIN'        => 'Selecione uma nova imagem. O ID, a descrição, os comentários, as avaliações e as visualizações são preservados.',
	'IMAGE_REVISIONS'              => 'Arquivos anteriores da imagem',
	'IMAGE_REVISIONS_EXPLAIN'      => 'Os arquivos retidos podem ser visualizados e restaurados. Ao restaurar, o arquivo atual permanece no histórico.',
	'RESTORE_REVISION'             => 'Restaurar esta versão',
	'IMAGE_REPLACE_FAILED'         => 'Não foi possível aplicar o arquivo de substituição com segurança.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'Esta revisão da imagem não está mais disponível.',
	'IMAGE_REVISION_RESTORED'      => 'A revisão da imagem foi restaurada com sucesso.',
]);
