<?php
/**
*
* Imgur - forum images uploader
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\imgur\avatar\driver;

class imgur extends \phpbb\avatar\driver\driver
{
	protected $config;
	public function __construct(\phpbb\config\config $config, \FastImageSize\FastImageSize $imagesize, $phpbb_root_path, $php_ext, \phpbb\path_helper $path_helper, \phpbb\cache\driver\driver_interface $cache = null)
	{
		parent::__construct($config, $imagesize, $phpbb_root_path, $php_ext, $path_helper, $cache);

		$this->config = $config;
	}

	public function get_config_name()
	{
		return 'imgur';
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
        return '<img src="' . $row['avatar'] . '" ' .
            ($row['avatar_width'] ? ('width="' . $row['avatar_width'] . '" ') : '') .
            ($row['avatar_height'] ? ('height="' . $row['avatar_height'] . '" ') : '') .
            'alt="' . ((!empty($user->lang[$alt])) ? $user->lang[$alt] : $alt) . '" />';
	}

	public function prepare_form($request, $template, $user, $row, &$error)
	{
		$user->add_lang_ext('sitesplat/imgur', 'imgur');

		return true;
	}

	public function prepare_form_acp($user)
	{
		$user->add_lang_ext('sitesplat/imgur', 'imgur');

		return array();
	}

	public function process_form($request, $template, $user, $row, &$error)
	{
        $client_id = $this->config['imgur_clientid'];
        $upload = $request->file('imgur');
        $filename = $upload['tmp_name'];
        $handle = fopen($filename, 'r');
        $data = fread($handle, filesize($filename));
        $pvars = array('image' => base64_encode($data));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'https://api.imgur.com/3/image.json',
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => array("Authorization: Client-ID $client_id"),
            CURLOPT_POSTFIELDS => $pvars
        ));
        $json_returned = curl_exec($curl);
        curl_close ($curl); 

        $pms = json_decode($json_returned, true);
        if (!empty($pms['data']['link']))
        {
			// lets force https seeing as imgur supports it
			$ssl = str_replace('http:', 'https:', $pms['data']['link']);
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
		return '@sitesplat_imgur/ucp_avatar_options_imgur.html';
	}

	public function get_acp_template_name()
	{
		return '@sitesplat_imgur/acp_avatar_options_imgur.html';
	}
}
