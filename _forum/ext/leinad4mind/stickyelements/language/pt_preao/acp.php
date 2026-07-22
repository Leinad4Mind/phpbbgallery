<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'STICKYELEMENTS_ADD'                => 'Adicionar elemento fixo',
	'STICKYELEMENTS_EDIT'               => 'Editar elemento fixo',
	'STICKYELEMENTS_CREATED'            => 'O teu elemento fixo foi adicionado.',
	'STICKYELEMENTS_MODIFIED'           => 'O teu elemento fixo foi actualizado.',
	'STICKYELEMENTS_DELETED'            => 'O elemento fixo selecionado foi removido.',
	'STICKYELEMENTS_ONLY_INDEX'         => 'Exibir apenas no Índice',
	'STICKYELEMENTS_ONLY_INDEX_EXPLAIN' => 'Se não, o elemento fixo é exibido em todas as páginas.',
	'STICKYELEMENTS_TEXT'               => 'Texto',
	'STICKYELEMENTS_TEXT_EXPLAIN'       => 'BBCodes são permitidos.',
	'STICKYELEMENTS_COLOR'              => 'Cor de fundo',
]);
