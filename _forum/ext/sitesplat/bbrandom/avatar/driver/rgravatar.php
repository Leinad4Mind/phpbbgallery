<?php
/**
*
* @package BBrandom
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbrandom\avatar\driver;

/**
* Handles avatars hosted at gravatar
*/
class rgravatar extends \phpbb\avatar\driver\driver
{
	/**
	* The URL for the Gravatar service
	*/
	const GRAVATAR_URL = '//secure.gravatar.com/avatar/';
	const ADORABLE_URL = '//api.adorable.io/avatars/';

	public function get_config_name()
	{
		return 'rgravatar';
	}

	/**
	* {@inheritdoc}
	*/
	public function get_data($row)
	{
		return array(
			'src' => $row['avatar'],
			'width' => $row['avatar_width'],
			'height' => $row['avatar_height'],
		);
	}

	/**
	* {@inheritdoc}
	*/
	public function get_acp_template_name()
	{
		return '@sitesplat_bbrandom/acp_avatar_options_' . $this->get_config_name() . '.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function prepare_form_acp($user)
	{
		return array(
			'default_rgravatar'			=> array('lang' => 'DEFAULT_RGRAVATAR',			'validate' => 'bool',	'type' => 'radio:yes_no', 'explain' => true),
			'default_cuavatar'			=> array('lang' => 'DEFAULT_CUAVATAR',			'validate' => 'bool',	'type' => 'radio:yes_no', 'explain' => true),
			'default_rgravatar_style'	=> array('lang' => 'DEFAULT_RGRAVATAR_STYLE',	'validate' => 'string',	'type' => 'select', 'function' => [$this, 'rgravatar_select'], 'params' => ['{CONFIG_VALUE}'], 'explain' => false),
		);
	}

	/**
	* {@inheritdoc}
	*/
	public function get_custom_html($user, $row, $alt = '')
	{
		return '<img class="avatar" src="' . $this->get_rgravatar_url($row) . '" ' .
			($row['avatar_width'] ? ('width="' . $row['avatar_width'] . '" ') : '') .
			($row['avatar_height'] ? ('height="' . $row['avatar_height'] . '" ') : '') .
			'alt="' . ((!empty($user->lang[$alt])) ? $user->lang[$alt] : $alt) . '" />';
	}

	/**
	* {@inheritdoc}
	*/
	public function prepare_form($request, $template, $user, $row, &$error)
	{
		global $phpbb_container;
		
		$user->add_lang_ext('sitesplat/bbrandom', 'bbrandom');
		$url = $phpbb_container->get('controller.helper')->route('sitesplat_bbrandom_controller', array('route' => 'detail'));
  
		$template->assign_vars(array(
			'AVATAR_RGRAVATAR_WIDTH'	=> (($row['avatar_type'] == $this->get_name() || $row['avatar_type'] == 'rgravatar') && $row['avatar_width']) ? $row['avatar_width'] : $request->variable('avatar_rgravatar_width', 0),
			'AVATAR_RGRAVATAR_HEIGHT'	=> (($row['avatar_type'] == $this->get_name() || $row['avatar_type'] == 'rgravatar') && $row['avatar_height']) ? $row['avatar_height'] : $request->variable('avatar_rgravatar_heigh', 0),
			'AVATAR_INFO'				=> '<a href="' . $url . '" class="simpledialog extrainfo"><i class="fa fa-info-circle"></i></a>',
		));
		
		return true;
	}

	/**
	* {@inheritdoc}
	*/
	public function process_form($request, $template, $user, $row, &$error)
	{
		$row['avatar'] = md5(mt_rand());
	// based on email address
	//	$row['avatar'] = $user->data['user_email'];
		$row['avatar_width'] = $request->variable('avatar_rgravatar_width', 0);
		$row['avatar_height'] = $request->variable('avatar_rgravatar_height', 0);

		if (!function_exists('validate_string'))
		{
			require($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
		}

		$validate_array = validate_data(array('name' => $row['avatar']), array(
						'name'		=> array('string', false, 6, 60),
					));
		$error = array_merge($error, $validate_array);

		if (!empty($error))
		{
			return false;
		}

		// Make sure getimagesize works...
		if (function_exists('getimagesize') && ($row['avatar_width'] <= 0 || $row['avatar_height'] <= 0))
		{
			/**
			* default to the minimum of the maximum allowed avatar size if the size
			* is not or only partially entered
			*/
			$row['avatar_width'] = $row['avatar_height'] = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);
			$url = $this->get_rgravatar_url($row);

			if (($row['avatar_width'] <= 0 || $row['avatar_height'] <= 0) && (($image_data = getimagesize($url)) === false))
			{
				$error[] = 'UNABLE_GET_IMAGE_SIZE';
				return false;
			}

			if (!empty($image_data) && ($image_data[0] <= 0 || $image_data[1] <= 0))
			{
				$error[] = 'AVATAR_NO_SIZE';
				return false;
			}

			$row['avatar_width'] = ($row['avatar_width'] && $row['avatar_height']) ? $row['avatar_width'] : $image_data[0];
			$row['avatar_height'] = ($row['avatar_width'] && $row['avatar_height']) ? $row['avatar_height'] : $image_data[1];
		}

		if ($row['avatar_width'] <= 0 || $row['avatar_height'] <= 0)
		{
			$error[] = 'AVATAR_NO_SIZE';
			return false;
		}

		if ($this->config['avatar_max_width'] || $this->config['avatar_max_height'])
		{
			if ($row['avatar_width'] > $this->config['avatar_max_width'] || $row['avatar_height'] > $this->config['avatar_max_height'])
			{
				$error[] = array('AVATAR_WRONG_SIZE', $this->config['avatar_min_width'], $this->config['avatar_min_height'], $this->config['avatar_max_width'], $this->config['avatar_max_height'], $row['avatar_width'], $row['avatar_height']);
				return false;
			}
		}

		if ($this->config['avatar_min_width'] || $this->config['avatar_min_height'])
		{
			if ($row['avatar_width'] < $this->config['avatar_min_width'] || $row['avatar_height'] < $this->config['avatar_min_height'])
			{
				$error[] = array('AVATAR_WRONG_SIZE', $this->config['avatar_min_width'], $this->config['avatar_min_height'], $this->config['avatar_max_width'], $this->config['avatar_max_height'], $row['avatar_width'], $row['avatar_height']);
				return false;
			}
		}
		
		return array(
			'avatar' 		=> $row['avatar'],
			'avatar_width'	=> $row['avatar_width'],
			'avatar_height'	=> $row['avatar_height'],
		);
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_bbrandom/ucp_avatar_options_rgravatar.html';
	}
	
	/**
	* Build rgravatar URL for output on page
	*
	* @param array $row User data or group data that has been cleaned with
	*        \phpbb\avatar\manager::clean_row
	* @return string rgravatar URL
	*/
	protected function get_rgravatar_url($row)
	{
		global $user;
		$avatarname = $row['avatar']; //'Yive'; //'clone1018';

		if ($avatarname)
		{
			if ($this->config['default_rgravatar_style'] == 'adorable')
			{
				$url = self::ADORABLE_URL;
				$url .= max($row['avatar_width'], $row['avatar_height']) . '/';
				$url .= md5(strtolower(trim($row['avatar']))) . '.png';
			}
			else
			{
				$url = self::GRAVATAR_URL;
				$url .=  md5(strtolower(trim($row['avatar'])));
				$url .= '?d=' . $this->config['default_rgravatar_style'] . '&amp;s=' . max($row['avatar_width'], $row['avatar_height']);
			}
		} else
		{
			$url = 	'styles/' . $user->style['style_path'] . '/theme/images/no_avatar.gif';
		}

		return $url;
	}

	public function rgravatar_select($default = '')
	{
		$style_options = '';
		foreach (['identicon', 'retro', 'adorable', 'robohash'] as $id)
		{
			$selected = ($id == $default) ? ' selected="selected"' : '';
			$style_options .= '<option value="' . $id . '"' . $selected . '>' . $id . '</option>';
		}

		return $style_options;
	}
}
