<?php

/**
 * BBcodeOrder+
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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
	'BBCODEORDER_EXPLAIN'      => '<hr><h3>Uso e Dicas:</h3> <br /><strong>BBCode Padrão:</strong> Os bbcodes padrão têm novas opções, como a possibilidade de serem ordenados ou escondidos. Infelizmente não podem ser editados diretamente a partir daqui como os BBCodes personalizados.<br /><strong>BBCodes Personalizados:</strong> BBCodes personalizados também podem ser ordenados, ter um ícone personalizado, definir permissão de grupo, etc. <br /><strong>Uso Geral:</strong> Podes adicionar "divisores", que basicamente dividem os grupos de botões. Eles são marcados como "-" e podes adicionar quantos quiseres, os quais também podem ser movidos/ordenados. (podes também usar arrastar & largar) <br /> Podes criar diferentes grupos de botões ou botões individuais. <br />Há também um divisor especial marcado como "--", que indica o início da caixa de seleção na interface principal. <br />Qualquer bbcode ordenado abaixo deste divisor especial será apresentado na opção da caixa de seleção, sim, até mesmo os bbcodes padrão :-). Cor e tipo de letra são exceções, porque não podes colocar uma caixa de seleção dentro de outra caixa de seleção. <br /> Flash e Tamanho da fonte geralmente só causam confusão e, idealmente, seria melhor tê-los ocultos para haver mais espaço para outros elementos.<br /> <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=11" target="blank" title="">Smart Snappy Reply</a> é suportado nativamente também.',
	'NEW_DIVIDER'              => 'Adicionar um novo divisor',
	'HIDE'                     => 'Esconder',
	'SHOW'                     => 'Mostrar',
	'BBCODE_HIDDEN'            => 'O BBCode foi oculto.',
	'BBCODES_ORDERED'          => 'A ordem do BBCode foi actualizada.',
	'BBCODES_DIVIDERS_PROBLEM' => 'Não podes posicionar o divisor após o início da caixa de seleção.',
	'BBCODE_ICON'              => 'Ícone',
	'BBCODE_ICON_EXPLAIN'      => '<a href="https://fontawesome.io/icons/">Ícone Font Awesome</a> sem prefixo fa-.',
	'BBCODE_GROUP'             => 'Gerir grupos que podem utilizar este BBCode',
	'BBCODE_GROUP_EXPLAIN'     => 'Se não forem selecionados grupos, então todos os utilizadores podem usar este BBCode. Usa CTRL+CLICK (ou CMD+CLICK no Mac) para selecionar/desmarcar mais de um grupo.',
	'BBCODEORDER_IMGUR_UPLOAD' => 'Clica para fazer upload para IMGUR',
	'BBCODEORDER_GYAZO_UPLOAD' => 'Clica para fazer upload para GYAZO',

	'BBCODE_B'        => 'Negrito',
	'BBCODE_I'        => 'Itálico',
	'BBCODE_U'        => 'Sublinhado',
	'BBCODE_L'        => 'Lista',
	'BBCODE_O'        => 'Lista Ordenada',
	'BBCODE_LISTITEM' => 'Item da Lista',
	'BBCODE_C'        => 'Código',
	'BBCODE_Q'        => 'Citação',
	'BBCODE_IMG'      => 'Imagem',
	'BBCODE_URL'      => 'URL',
	'BBCODE_FLASH'    => 'FLASH',
]);
