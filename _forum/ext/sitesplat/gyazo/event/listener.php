<?php
/**
*
* Gyazo - forum images uploader
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\gyazo\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/* @var */
	protected $config;
	protected $user;
	protected $template;
	protected $request;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template, \phpbb\request\request $request)
	{
		$this->config	= $config;
		$this->user		= $user;
		$this->template	= $template;
		$this->request	= $request;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.modify_posting_parameters'		=> 'modify_posting_parameters',
			'core.posting_modify_message_text'		=> 'posting_modify_message_text',
			'core.posting_modify_template_vars'		=> 'load_language_on_posting',
			'core.acp_attachments_config_edit_add'	=> 'load_config_on_setup',
		);
	}

	public function modify_posting_parameters($event)
	{
		$event['refresh'] = $event['refresh'] || $this->request->is_set_post('add_image');
	}

	public function posting_modify_message_text($event)
	{
		$upload = $this->request->file('imgur');
		if (!empty($upload) && $upload['name'] != 'none' && trim($upload['name'])) 
		{
			$access_token = $this->config['gyazo_access_token'];
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
				$this->template->assign_vars(array(
					'GYAZO_IMAGE'		=>  "\n[img]{$pms['url']}[/img]",
					'GYAZO_DIRECT_IMG'	=>  "\n[img]{$pms['url']}[/img]",
					'GYAZO_DIRECT_LINK'	=>  "\n{$pms['url']}",
				));
			}
			else 
			{
				$error = $event['error'];
				$error[] = $pms['data']['error'];
				$event['error'] = $error;
			}
		}
	}

	public function load_language_on_posting($event)
	{
		$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
		$this->template->assign_vars(array(
			'IN_GYAZO'	=> ($this->config['gyazo_access_token']) ? true : false,
		));

		$page_data = $event['page_data'];
		$page_data['S_FORM_ENCTYPE'] = ' enctype="multipart/form-data"';
		$event['page_data'] = $page_data;
	}

	public function load_config_on_setup($event)
	{
		if ($event['mode'] == 'attach')
		{
			$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
			$display_vars = $event['display_vars'];

			$add_clientid_var = array(
				'gyazo_access_token' =>
					array(
						'lang'		=> 'GYAZO_ACCESS_TOKEN',
						'validate'	=> 'string',
						'type'		=> 'text:25:100',
						'explain'	=> true),
			);

			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_clientid_var, array('after' =>'upload_path'));
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}
}
