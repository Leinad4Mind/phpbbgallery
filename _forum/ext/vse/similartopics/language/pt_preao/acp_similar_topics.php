<?php

/**
 * Precise Similar Topics [English]
 * @copyright (c) 2013 Matt Friedman
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'PST_TITLE_ACP'      => 'Precise Similar Topics',
	'PST_EXPLAIN'        => 'O Precise Similar Topics apresenta uma lista de tópicos semelhantes (relacionados) na parte inferior da página do tópico actual.',
	'PST_LEGEND1'        => 'Configurações gerais',
	'PST_ENABLE'         => 'Activar Tópicos Semelhantes',
	'PST_LEGEND2'        => 'Configurações de carregamento',
	'PST_LIMIT'          => 'Número de Tópicos Semelhantes a exibir',
	'PST_LIMIT_EXPLAIN'  => 'Aqui podes definir quantos tópicos semelhantes exibir. O valor por defeito é 5 tópicos.',
	'PST_TIME'           => 'Período de pesquisa',
	'PST_TIME_EXPLAIN'   => 'Esta opção permite limitar os resultados de Tópicos Semelhantes a tópicos mais recentes (evitando reviver tópicos antigos). Por exemplo, se definires "30 dias", o sistema só mostrará tópicos semelhantes dos últimos 30 dias. O valor por defeito é 1 ano. Define 99 anos se quiseres desactivar esta funcionalidade.',
	'PST_YEARS'          => 'Anos',
	'PST_MONTHS'         => 'Meses',
	'PST_WEEKS'          => 'Semanas',
	'PST_DAYS'           => 'Dias',
	'PST_CACHE'          => 'Duração da cache de Tópicos Semelhantes',
	'PST_CACHE_EXPLAIN'  => 'Os Tópicos Semelhantes em cache expiram após este tempo, em segundos. Define 0 se quiseres desactivar a cache de Tópicos Semelhantes.',
	'PST_SENSE'          => 'Sensibilidade de pesquisa',
	'PST_SENSE_EXPLAIN'  => 'Define a sensibilidade de pesquisa para um valor entre 1 e 10. Usa um número mais baixo se não estiveres a ver nenhum tópico semelhante. Definições recomendadas: para tabelas "phpbb_topics" que usem InnoDB, usa 1; para MyISAM, usa 5.',
	'PST_LEGEND3'        => 'Configurações do fórum',
	'PST_NOSHOW_LIST'    => 'Não exibir em',
	'PST_NOSHOW_TITLE'   => 'Não exibir Tópicos Semelhantes em',
	'PST_IGNORE_SEARCH'  => 'Não pesquisar em',
	'PST_IGNORE_TITLE'   => 'Não pesquisar Tópicos Semelhantes em',
	'PST_STANDARD'       => 'Padrão',
	'PST_ADVANCED'       => 'Avançado',
	'PST_ADVANCED_TITLE' => 'Clica para configurar definições avançadas de Tópicos Semelhantes para',
	'PST_ADVANCED_EXP'   => 'Aqui podes seleccionar fóruns específicos de onde extrair os Tópicos Semelhantes. Só os Tópicos Semelhantes encontrados nos fóruns que seleccionares aqui serão exibidos em <strong>%s</strong>.<br /><br />Não selecciones nenhum fórum se quiseres que sejam exibidos Tópicos Semelhantes de todos os fóruns pesquisáveis neste fórum.<br /><br />Selecciona vários fóruns mantendo premida a tecla <samp>CTRL</samp> (ou <samp>⌘CMD</samp> no Mac) e clicando.',
	'PST_ADVANCED_FORUM' => 'Configurações avançadas de fórum',
	'PST_DESELECT_ALL'   => 'Desmarcar todos',
	'PST_LEGEND4'        => 'Configurações opcionais',
	'PST_WORDS'          => 'Palavras especiais a ignorar',
	'PST_WORDS_EXPLAIN'  => 'Adiciona palavras especiais, próprias do teu fórum, que devem ser ignoradas ao procurar tópicos semelhantes. (Nota: as palavras já consideradas comuns na tua língua já são ignoradas por defeito.) Separa cada palavra com um espaço. Não sensível a maiúsculas/minúsculas.',
	'PST_SAVED'          => 'As configurações de Tópicos Semelhantes foram actualizadas',
	'PST_FORUM_INFO'     => '<strong>Não exibir em</strong>: não mostra Tópicos Semelhantes nos fóruns seleccionados.<br /><strong>Não pesquisar em</strong>: não pesquisa Tópicos Semelhantes nos fóruns seleccionados.',
	'PST_NO_COMPAT'      => 'O Similar Topics não é compatível com o teu fórum. O Similar Topics só funciona com uma base de dados MySQL ou PostgreSQL.',
	'PST_ERR_CONFIG'     => 'Foram marcados demasiados fóruns na lista de fóruns. Por favor, tenta novamente com uma seleção menor.',
]);
