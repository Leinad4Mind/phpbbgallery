<?php
/*
* @name language.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;

class language
{
	protected $user;
	protected $phpbb_lang;

	/**
	* Constructor
	*
	* @param ContainerInterface 		$container		Service container interface
	* @param \phpbb\user				$user			User object
	*
	* @access public
	*/
	public function __construct(ContainerInterface $container, \phpbb\user $user)
	{
		$this->user = $user;
		
		if($container->has('language'))
		{
			$this->phpbb_lang = $container->get('language');
		}
	}
	
	public function add($component, $ext_lang = false)
	{
		$ext_name = str_replace(array('\libraries', '\\'), array('', '/'), __NAMESPACE__);
		
		if($this->phpbb_lang)
		{
			return $this->phpbb_lang->add_lang($component, (($ext_lang) ? $ext_name : null));
		}
		
		return $this->user->add_lang_ext((($ext_lang) ? $ext_name : ''), $component);
	}
	
	public function get()
	{
		$args = func_get_args();
		
		if($this->phpbb_lang)
		{
			return call_user_func_array(array($this->phpbb_lang, 'lang'), $args);
		}
		
		return call_user_func_array(array($this->user, 'lang'), $args);
	}
	
	/**
	 * Returns the raw value associated to a language key or the language key no translation is available.
	 * No parameter substitution is performed, can be a string or an array.
	 *
	 * @param string|array	$key	Language key
	 *
	 * @return array|string
	 */
	public function get_raw($key)
	{
		if($this->phpbb_lang)
		{
			return $this->phpbb_lang->lang_raw($key);
		}
		
		$tkey = $key;

		if(is_array($key))
		{
			$lang = &$this->user->lang[array_shift($tkey)];

			foreach ($tkey as $_key)
			{
				$lang = &$lang[$_key];
			}
		}
		else
		{
			$lang = &$this->user->lang[$tkey];
		}

		// Return if language string does not exist
		if(empty($lang) || (!is_string($lang) && !is_array($lang)))
		{
			return $key;
		}

		return $lang;
	}
	
	public function is_set($key)
	{
		if($this->phpbb_lang)
		{
			return $this->phpbb_lang->is_set($key);
		}

		return ($this->get_raw($key) !== $key);
	}
}
