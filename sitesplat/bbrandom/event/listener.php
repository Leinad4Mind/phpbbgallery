<?php
/**
*
* @package BBrandom
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbrandom\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $config;

	/**
	* Constructor
	*
	*/
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_add_modify_data' => 'user_default',
		);
	}
	
	public function user_default($event)
	{
		global $phpbb_root_path;

		$sql_ary = $event['sql_ary'];
		$valid_user = in_array($sql_ary['user_type'], array(0,3));

		if ($valid_user && $this->config['allow_avatar_local'] && $this->config['default_cuavatar'])
		{
			$path = $phpbb_root_path . $this->config['avatar_gallery_path'] . '/../random/';
			try
			{
				$iterator = new \RecursiveIteratorIterator(
						new \RecursiveDirectoryIterator(
							$path, 
							\FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS
						), 
						\RecursiveIteratorIterator::SELF_FIRST);
			}
			catch (\Exception $e)
			{
				return array();
			}
			
			$cuavatar = array();
			foreach ($iterator as $file_info)
			{
				$cuavatar[] = $file_info->getFilename();
			}
			
			if (sizeof($cuavatar))
			{
				$sql_ary['user_avatar'] = '../random/' . $cuavatar[array_rand($cuavatar, 1)];
				$sql_ary['user_avatar_height'] = $this->config['avatar_max_height'];
				$sql_ary['user_avatar_width'] = $this->config['avatar_max_width'];
				$sql_ary['user_avatar_type'] = 'avatar.driver.local';
			
				$event['sql_ary'] = $sql_ary;
			}
		} else if ($valid_user && $this->config['allow_avatar_rgravatar'] && $this->config['default_rgravatar'])
		{
			$sql_ary['user_avatar'] = $sql_ary['user_email'];
			$sql_ary['user_avatar_height'] = $this->config['avatar_max_height'];
			$sql_ary['user_avatar_width'] = $this->config['avatar_max_width'];
			$sql_ary['user_avatar_type'] = 'avatar.driver.rgravatar';
		
			$event['sql_ary'] = $sql_ary;
		}
	}
}
