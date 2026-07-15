<?php
/**
 * @package cBB Debugger
 * @version 1.0.1 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\debugger\tunnel;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;

define('IN_PHPBB', true);
$phpbb_root_path 	= str_replace('ext/' . str_replace('\\', '/', __NAMESPACE__), '', str_replace('\\', '/', __DIR__));
$ext_root_path 		= '../';
$phpEx 				= substr(strrchr(__FILE__, '.'), 1);

require($phpbb_root_path . 'includes/startup.' . $phpEx);
require($phpbb_root_path . 'phpbb/class_loader.' . $phpEx);

$phpbb_class_loader = new \phpbb\class_loader('phpbb\\', "{$phpbb_root_path}phpbb/", $phpEx);
$phpbb_class_loader->register();

$phpbb_class_loader_ext = new \phpbb\class_loader('\\', "{$phpbb_root_path}ext/", $phpEx);
$phpbb_class_loader_ext->register();

$phpbb_config_php_file = new \phpbb\config_php_file($phpbb_root_path, $phpEx);
extract($phpbb_config_php_file->get_all());

if(!defined('PHPBB_INSTALLED'))
{
	exit;
}

// Include files
require($phpbb_root_path . 'includes/functions.' . $phpEx);
require($phpbb_root_path . 'includes/constants.' . $phpEx);
include($phpbb_root_path . 'includes/functions_compatibility.' . $phpEx);
require($phpbb_root_path . 'includes/compatibility_globals.' . $phpEx);
require($ext_root_path . 'libraries/config.' . $phpEx);

set_error_handler(function($errno, $errstr, $errfile, $errline) {
	global $twig;

	// Do not display notices if we suppress them via @
	if(error_reporting() == 0 && $errno != E_USER_ERROR && $errno != E_USER_WARNING && $errno != E_USER_NOTICE)
	{
		return;
	}

	$twig_vars = [
		'S_ERROR' 	=> "[$errno] $errstr<br />$errfile ($errline)",
	];

	echo $twig->render('enable_body.html', $twig_vars);
	exit;
});

// Set up container
try
{
	$phpbb_container_builder = new \phpbb\di\container_builder($phpbb_root_path, $phpEx);
	$phpbb_container_builder
		->with_environment('production')
		->without_extensions();

	$phpbb_container = $phpbb_container_builder
		->with_config($phpbb_config_php_file)
		->with_custom_parameters(['cache.driver.class' => 'phpbb\cache\driver\file'])
		->get_container();
}
catch(\InvalidArgumentException $e)
{
	throw $e;
}

register_compatibility_globals();

$request->enable_super_globals();

$symfony_request 		= Request::createFromGlobals();
$template_path 			= $ext_root_path . 'styles/all/template/';
$twig_vars 				= [];

if(class_exists('Twig_Environment'))
{
	$twig = new \Twig_Environment(new \Twig_Loader_Filesystem($template_path));
}
else
{
	$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader($template_path));
}

// Get display language
$lang_ary 		= $symfony_request->getLanguages();
$lang_path 		= $ext_root_path . 'language/';
$user_lang_name = 'en';

if(!in_array('en', $lang_ary))
{
	$lang_ary[] = 'en';
}

foreach($lang_ary as $lang_name)
{
	$lang_name = explode('_', $lang_name);

	if(file_exists($lang_path . $lang_name[0] . '/enable.php'))
	{
		$user_lang_name = $lang_name[0];
		
		require($lang_path . $lang_name[0] . '/enable.php');

		foreach($lang as $key => $value)
		{
			$twig_vars['L_' . $key] = $value;
		}

		break;
	}
}

// Process
if($request->is_set_post('submit'))
{
	$ext_name 	= 'canidev/debugger';
	$config 	= \canidev\debugger\libraries\config::instance();

	/** @var \phpbb\extension\manager */
	$ext_manager = $phpbb_container->get('ext.manager');

	$ext_manager->load_extensions();

	// Try to enable the extension
	if(!$ext_manager->is_enabled($ext_name))
	{
		$ext_manager->enable($ext_name);
	}

	// Set new config
	$config
		->set('debug_enable', true)
		->set('allowed_ips', '')
		->save();

	// Remove container to force reload
	$finder = new Finder();
	$finder
		->name('container_*')
		->files()
		->ignoreDotFiles(true)
		->ignoreUnreadableDirs(true)
		->ignoreVCS(true)
		->followLinks()
		->in($phpbb_root_path . 'cache');

	foreach($finder as $file)
	{
		@unlink($file->getPathname());
	}

	$twig_vars['S_SUCCESS'] = true;
}

$twig_vars['S_USER_LANG'] 	= $user_lang_name;
$twig_vars['U_ACTION'] 		= $symfony_request->getRequestUri();

echo $twig->render('enable_body.html', $twig_vars);

exit;

?>
