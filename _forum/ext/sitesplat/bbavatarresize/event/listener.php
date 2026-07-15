<?php
/**
*
* @package Avatar Resize
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbavatarresize\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use \phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\user;
use phpbb\request\request_interface;
use phpbb\template\template;
use Symfony\Component\DependencyInjection\ContainerInterface;
use phpbb\controller\helper;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $config;
	protected $db;
	protected $user;
	protected $request;
	protected $template;
	protected $container;
	protected $helper;
	protected $php_ext;
	protected $root_path;

	/**
	* Constructor
	*
	*/
	public function __construct(config $config, driver_interface $db, user $user, request_interface $request, template $template, ContainerInterface $container, helper $helper, $php_ext, $root_path)
	{
		$this->config		= $config;
		$this->db			= $db;
		$this->user			= $user;
		$this->request		= $request;
		$this->template		= $template;
		$this->container	= $container;
		$this->helper		= $helper;
		$this->php_ext		= $php_ext;
		$this->root_path	= $root_path;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.avatar_driver_upload_move_file_before' => 'resize_image',
		);
	}
	
	public function resize_image($event)
	{
		$filedata = $event['filedata'];
		$image = file_get_contents($filedata['filename']);
		$imagename = $event['destination'] . '/tmp_' . $event['prefix'] . $event['row']['id'] . '.' . $filedata['extension'];
		file_put_contents($imagename, $image);		
		$imagesize = getimagesize($imagename);
		
		if ($imagesize[0] > $this->config['avatar_max_width'] && $imagesize[1] > $this->config['avatar_max_height'] && in_array($filedata['extension'], array('jpg', 'jpeg', 'png')))
		{
			$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_langname = 'UCP_IR'";
			$result = $this->db->sql_query($sql, 3600);
			$allowed_i = array();
	
			while ($row = $this->db->sql_fetchrow($result))
			{
				$allowed_i[] = $row['module_id'];
			}
			$this->db->sql_freeresult($result);
				
			$ucp_mode = '-sitesplat-BBCore-ucp-ir_module'; //'-sitesplat-helper-ucp-ir_module';
			$allowed_i[] = $ucp_mode;
			if ($this->user->page['page_name'] === 'ucp.' . $this->php_ext && in_array($this->request->variable('i', ''), $allowed_i))
			{
				return;
			}
		
			$url = append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=' . $ucp_mode . '&app=avatar' . '&file=' . urlencode($imagename));
			redirect(append_sid($url, false, true, $this->user->data['session_id']));
			exit();
		} else
		{
			unlink($imagename);
		}
	}
}
