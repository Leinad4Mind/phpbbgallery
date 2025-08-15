<?php
/**
*
* @package BBrandom
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\avatarsplus\avatar\driver;

use \Shift\AvatarMaker\Factory\AvatarFactory;

class material extends \phpbb\avatar\driver\driver
{
	public function get_config_name()
	{
		return 'material';
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
		return '<img src="' . $root_path . 'images/avatars/material/' . $row['avatar'] . '.png" ' .
			($row['avatar_width'] ? ('width="' . $row['avatar_width'] . '" ') : '') .
			($row['avatar_height'] ? ('height="' . $row['avatar_height'] . '" ') : '') .
			'alt="' . ((!empty($user->lang[$alt])) ? $user->lang[$alt] : $alt) . '" />';
	}

	public function prepare_form($request, $template, $user, $row, &$error)
	{
		$user->add_lang_ext('sitesplat/avatarsplus', 'common');

		return true;
	}

	public function prepare_form_acp($user)
	{
		$user->add_lang_ext('sitesplat/avatarsplus', 'common');

		return array();
	}

	public function process_form($request, $template, $user, $row, &$error)
	{
		// user selected shape
		$shape = $request->variable('avatar_material_shape', 'random');
		// validate shape
		$shape = (in_array($shape, array('random', 'circle', 'column', 'diamond', 'rectangle', 'rhomb'))) ? $shape : 'random';

		// resolve avatar size
		$size = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);

		// initialize avatar, make it as big as possible
		$avatar = AvatarFactory::createAvatarMaker($shape, $size, class_exists('Imagick') ? 'imagick' : 'gd');
		// load Arial font
		$avatar->setFontFile($this->phpbb_root_path . 'ext/sitesplat/avatarsplus/vendor/shiftedwork/avatarmaker/demo/arial.ttf');
		// delete old material avatar
		$this->delete(array('id' => $row['avatar']));
		// generate new material avatar filename
		$filename = $user->data['user_id'] . '_' . time();
		// save new material avatar
		$avatar->makeAvatar($user->data['username'])->save($this->get_material_url($filename), 100);

		// nothing much to store, but we obey interface
		return array(
			'avatar' 		=> $filename,
			'avatar_width'	=> $size,
			'avatar_height'	=> $size,
		);
	}

	public function delete($row)
	{
		@unlink($this->get_material_url($row['id']));

		return true;
	}

	public function get_template_name()
	{
		return '@sitesplat_avatarsplus/ucp_avatar_options_material.html';
	}

	public function get_acp_template_name()
	{
		return '@sitesplat_avatarsplus/acp_avatar_options_material.html';
	}

	protected function get_material_url($id)
	{
		return $this->phpbb_root_path . 'images/avatars/material/' . $id . '.png';
	}
}
