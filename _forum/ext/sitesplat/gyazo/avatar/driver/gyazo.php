<?php
/**
*
* Gyazo - forum images uploader
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\gyazo\avatar\driver;

class gyazo extends \phpbb\avatar\driver\driver
{
	protected $config;
	public function __construct(\phpbb\config\config $config, \FastImageSize\FastImageSize $imagesize, $phpbb_root_path, $php_ext, \phpbb\path_helper $path_helper, \phpbb\cache\driver\driver_interface $cache = null)
	{
		parent::__construct($config, $imagesize, $phpbb_root_path, $php_ext, $path_helper, $cache);

		$this->config = $config;
	}

	public function get_config_name()
	{
		return 'gyazo';
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
        return '<img class="avatar" src="' . $row['avatar'] . '" ' .
            ($row['avatar_width'] ? ('width="' . $row['avatar_width'] . '" ') : '') .
            ($row['avatar_height'] ? ('height="' . $row['avatar_height'] . '" ') : '') .
            'alt="' . ((!empty($user->lang[$alt])) ? $user->lang[$alt] : $alt) . '" />';
	}

	public function prepare_form($request, $template, $user, $row, &$error)
	{
		$user->add_lang_ext('sitesplat/gyazo', 'gyazo');

		return true;
	}

	public function prepare_form_acp($user)
	{
		$user->add_lang_ext('sitesplat/gyazo', 'gyazo');

		return array();
	}

	public function process_form($request, $template, $user, $row, &$error)
	{
        $upload = $request->file('gyazo');
        if (empty($upload['tmp_name']))
        {
            return false;
        }

		$access_token = $this->config['gyazo_clientid'];
		$filename = $upload['tmp_name'];
		$pvars = array(
			'access_token'	=> $access_token,
			'imagedata'		=> new \CURLFile($filename),
		);

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_URL => 'https://upload.gyazo.com/api/upload',
			CURLOPT_TIMEOUT => 30,
			CURLOPT_POST => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POSTFIELDS => $pvars
		));

        $json_returned = curl_exec($curl);
        curl_close ($curl); 

        $pms = json_decode($json_returned, true);
		if (!empty($pms['image_id'])) 
        {
			// lets force https seeing as gyazo supports it
			$ssl = str_replace('http:', 'https:', $pms['url']);
            return array(
          //    'avatar' 		=> $pms['data']['link'],
				'avatar'        =>  "{$ssl}",
                'avatar_width'	=> 0,
                'avatar_height'	=> 0,
            );
        }
        else
        {
            return false;
        }
	}

	public function get_template_name()
	{
		return '@sitesplat_gyazo/ucp_avatar_options_gyazo.html';
	}

	public function get_acp_template_name()
	{
		return '@sitesplat_gyazo/acp_avatar_options_gyazo.html';
	}
}
