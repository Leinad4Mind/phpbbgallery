<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 *
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
	'ERRORPAGES_LOG' => 'Registar erros do servidor',
	'ERRORPAGES_LOG_EXPLAIN' => 'Regista os erros HTTP 5xx no registo de erros do ACP. Os erros de cliente 4xx habituais não são registados.',
	'ERRORPAGES_EXPLAIN' => 'Explicar as páginas de erro',
	'ERRORPAGES_EXPLAIN_EXPLAIN' => 'Apresenta uma explicação curta e sem dados sensíveis por baixo do título do erro.',
]);
