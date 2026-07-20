<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
   'INSTALL_NOTICE' => '<div class="phpinfo"><p>Nenhuma configuração é necessária. Irá verificar nos bastidores se tem BBPrefix | BBEmoji | Special Best Answer instalados e tornará magicamente compatível com eles.</p></div></p></div>',
   'PHP_ERROR'      => 'Esta extensão requer PHP 7.3.0 (ou superior).',
   'PHPBB_ERROR'    => 'Esta extensão requer phpBB 3.3.0 (ou superior).',
]);
