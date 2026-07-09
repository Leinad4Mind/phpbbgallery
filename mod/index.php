<?php
/**
 * ---------------------------------------------------------------------
   
   phpBBDumper
   https://www.phpbb3-support.square7.ch/

   Copyright (c) 2025 by Mahony
   ----------------------------------------------------------------------
   Based on:

   MyOOS [Dumper]
    Copyright (c) 2013 - 2023 by the MyOOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   MySqlDumper
   https://www.mysqldumper.de

   Copyright (C)2004-2011 Daniel Schlichtholz (admin@mysqldumper.de)
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ----------------------------------------------------------------------
 */

define('OOS_VALID_MOD', true);

if (!@ob_start('ob_gzhandler')) {
    @ob_start();
}

require './inc/functions.php';
$page = $_GET['page'] ?? 'main.php';
if (!file_exists('./work/config/phpbbdumper.php')) {
    header('location: install.php');
    ob_end_flush();
    exit();
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow" />
    <title>phpBBDumper</title>
</head>

<frameset border=0 cols="190,*">
    <frame name="MyOOS_Dumper_menu" src="menu.php" scrolling="no" noresize
        frameborder="0" marginwidth="0" marginheight="0">
    <frame name="MyOOS_Dumper_content" src="<?php echo $page; ?>" scrolling="auto" frameborder="0" marginwidth="0" marginheight="0">
</frameset><noframes></noframes>
</html>
