<?php
/**
 * BBCore DB Addon
 * @copyright (c) 2020 SiteSplat. All rights reserved.
 * @license Proprietary
 */

if (!defined('IN_PHPBB')) {
	return;
}

if (empty($addon_lang)) {
	$addon_lang = [];
}

$addon_lang = array_merge($addon_lang, [
	'DBXTRA_TITLE'			=> 'BBCore Database Manager',
	'DBXTRA_ENGINE_DESC'	=> 'The two most common types of MySQL/MariaDB storage engines are <strong>MyISAM</strong> and <strong>InnoDB</strong>. MariaDB also supports an engine named <strong>Aria</strong> that is extremely similar to MyISAM, and they are grouped with MyISAM tables in this addon.<br><br>
								MyISAM tables can be easily migrated and do not use a lot of memory or disk space. However, they have a tendency to become fragmented when updated frequently, which can eventually result in a crashed table. InnoDB tables are generally faster and more stable, but they are not easily migrated, and they use twice as much memory and disk space as MyISAM tables.
								MyISAM tables are also better when queries use the LIMIT clause, which is used to create pagination.<br><br>
								For phpBB, the _config and _sessions tables should be InnoDB because they are updated frequently. The _topics, _posts, and _privmsgs tables should be MyISAM because they extensively use the LIMIT clause.
								All other tables can use the default storage engine.',
	'DBXTRA_NO_INNODB'		=> '<strong>The table "%s" should be using the InnoDB engine.</strong><br>',
	'DBXTRA_NO_MYISAM'		=> '<strong>The table "%s" should be using the MyISAM engine.</strong><br>',
	'DBXTRA_FIX_INNODB'		=> 'Convert To InnoDB',
	'DBXTRA_FIX_MYISAM'		=> 'Since these three tables can be quite large, it is unsafe to convert them to MyISAM from within phpBB. The conversion can be done using phpMyAdmin, or preferably using the <strong>mysql</strong> application at the command line.',
	'DBXTRA_OPTIMIZE'		=> 'The <strong>Optimize MyISAM</strong> and <strong>Optimize InnoDB</strong> buttons will rebuild and defragment tables, resulting in faster access and less disk space usage.
								You may see one or both buttons, depending on the size and configuration of your database. The buttons will not be displayed if your tables are too large to support optimization from within phpBB.
								Due to MySQL/MariaDB limitations, the <strong>Optimize InnoDB</strong> button will be displayed after it has been used. Do not click it a second time! <strong>Optimizing tables should be done outside phpBB, preferably using phpMyAdmin or the mysql command line.</strong>',
	'DBXTRA_ANALYZE'		=> 'The <strong>Analyze</strong> button will analyze and adjust the index usage in tables, oftentimes resulting in faster queries. While much safer than the Optimize procedure, please consider using phpMyAdmin for this procedure if your database is larger than 1GB.',
	'DBXTRA_DOWNLOAD'		=> 'You can download a GZip archive of your full database by clicking the <strong>Download</strong> button. Unlike phpBB, all tables in the database will be in the archive. Please be aware that this can take a long time with large databases, so please consider using other options to obtain your database if your internet connection speed is less than 20mbps, or if your database is larger than 1GB.',
	'DBXTRA_BTN_OPTINNO'	=> 'Optimize InnoDB',
	'DBXTRA_BTN_OPTISAM'	=> 'Optimize MyISAM',
	'DBXTRA_BTN_ANALYZE'	=> 'Analyze',
	'DBXTRA_BTN_DOWNLOAD'	=> 'Download',
	'DBXTRA_OK_OPTIMIZE'	=> 'Tables have been optimized.',
	'DBXTRA_OK_ANALYZE'		=> 'Tables have been analyzed.',
	'DBXTRA_OK_INNODB'		=> 'Storage engine(s) have been converted to InnoDB.',
]);
