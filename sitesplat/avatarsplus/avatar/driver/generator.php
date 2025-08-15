<?php
/**
*
* @package BBavatar+
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\avatarsplus\avatar\driver;

class generator extends \phpbb\avatar\driver\driver
{
	protected $config;
	protected $extension_manager;
	public function __construct(\phpbb\config\config $config, \FastImageSize\FastImageSize $imagesize, $phpbb_root_path, $php_ext, \phpbb\path_helper $path_helper, \phpbb\cache\driver\driver_interface $cache = null, \phpbb\extension\manager $extension_manager)
	{
		parent::__construct($config, $imagesize, $phpbb_root_path, $php_ext, $path_helper, $cache);

		$this->config = $config;
		$this->extension_manager = $extension_manager;
	}

	public function get_config_name()
	{
		return 'generator';
	}

	public function get_data($row)
	{
		return array(
			'src' => $row['avatar'],
			'width' => $row['avatar_width'],
			'height' => $row['avatar_height'],
		);
	}

	public function get_custom_html($user, $row, $alt = '')
	{
		$root_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->path_helper->get_web_root_path();

		// return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
		return '<img class="avatar" src="' . $root_path . 'images/avatars/generator/' . $row['avatar'] . '.png" ' .
			($row['avatar_width'] ? ('width="' . $row['avatar_width'] . '" ') : '') .
			($row['avatar_height'] ? ('height="' . $row['avatar_height'] . '" ') : '') .
			'alt="' . ((!empty($user->lang[$alt])) ? $user->lang[$alt] : $alt) . '" />';
	}

	public function prepare_form($request, $template, $user, $row, &$error)
	{
		$user->add_lang_ext('sitesplat/avatarsplus', 'common');

		$template->assign_vars(array(
			'ROOT_PATH'					=> $this->phpbb_root_path,
			'S_IN_AVATAR_GENERATOR'		=> true,
			'S_MAX_AVATAR_SIZE'			=> min($this->config['avatar_max_width'], $this->config['avatar_max_height']),
			'S_ENABLE_GENERATOR_SHARE'	=> $this->extension_manager->is_enabled('sitesplat/bbopengraph') ? 'false' : 'true',
			'U_BOARD_URL'				=> generate_board_url(),
			'BBOPENGRAPH_APPID'			=> isset($this->config['bbopengraph_fb_app_id']) ? $this->config['bbopengraph_fb_app_id'] : '',
		));

		return true;
	}

	public function prepare_form_acp($user)
	{
		$user->add_lang_ext('sitesplat/avatarsplus', 'common');

		return array();
	}

	public function process_form($request, $template, $user, $row, &$error)
	{
		$size = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);

		$data = $request->variable('imgdata', '');
		// generate new material avatar filename
		$filename = $user->data['user_id'] . '_' . time();

		//cheking, that file is exactly png
		if ($data)
		{
			list($type, $data) = explode(';', $data);
			list($base, $data) = explode(',', $data);
			
			/*cheking that image data is base64 of png*/
			if ($type === 'data:image/png' && $base === 'base64')
			{
				$data = base64_decode($data);
				$this->delete(array('id' => $row['avatar']));
				file_put_contents($this->get_generator_url($filename), $data);
			}
		}

		// nothing much to store, but we obey interface
		return array(
			'avatar' 		=> $filename,
			'avatar_width'	=> $size,
			'avatar_height'	=> $size,
		);
	}

	public function delete($row)
	{
		@unlink($this->get_generator_url($row['id']));

		return true;
	}

	public function get_template_name()
	{
		return '@sitesplat_avatarsplus/ucp_avatar_options_generator.html';
	}

	public function get_acp_template_name()
	{
		return '@sitesplat_avatarsplus/acp_avatar_options_generator.html';
	}

	protected function get_generator_url($id)
	{
		return $this->phpbb_root_path . 'images/avatars/generator/' . $id . '.png';
	}
}
