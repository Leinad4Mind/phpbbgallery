<?php
/**
*
* Gyazo - forum images uploader
* @copyright (c) 2015 SiteSplat All rights reserved
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
			'core.ucp_profile_modify_signature'		=> 'ucp_profile_modify_signature',
			'core.acp_board_config_edit_add'		=> 'load_signature_config',
		);
	}

	public function modify_posting_parameters($event)
	{
		$event['refresh'] = $event['refresh'] || isset($_POST['add_image']);
	}

	public function posting_modify_message_text($event)
	{
		$upload = $this->request->file('gyazo');
		if (!empty($upload) && $upload['name'] != 'none' && trim($upload['name'])) 
		{
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
				$this->template->assign_vars(array(
				//	'GYAZO_IMAGE'		=>  "\n[img]{$pms['data']['link']}[/img]",
				    'GYAZO_IMAGE'       =>  "\n[img]{$ssl}[/img]",
//					'GYAZO_IMAGE_MD'    =>  "\n[GYAZO Screenshot]({$ssl})",
				//	'GYAZO_DIRECT_IMG'	=>  "\n[img]{$pms['data']['link']}[/img]",
					'GYAZO_DIRECT_IMG'	=>  "\n[img]{$ssl}[/img]",
				//	'GYAZO_DIRECT_LINK'	=>  "\n{$pms['data']['link']}",
				    'GYAZO_DIRECT_LINK'	=>  "\n{$ssl}",
//					'GYAZO_DELETEHASH'	=>  $pms['data']['deletehash'],
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
			'IN_GYAZO'	=> ($this->config['gyazo_clientid']) ? true : false,
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
				'gyazo_clientid' =>
					array(
						'lang'		=> 'GYAZO_CLIENT_ID',
						'validate'	=> 'string',
						'type'		=> 'text:25:100',
						'explain'	=> true),
			);

			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_clientid_var, array('after' =>'upload_path'));
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}

	public function ucp_profile_modify_signature($event)
	{
		$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
		$this->template->assign_vars(array(
			'IN_GYAZO'			=> ($this->config['gyazo_clientid'] && $this->config['gyazo_signature']) ? true : false,
			'S_FORM_ENCTYPE'	=> ' enctype="multipart/form-data"',
		));

		$this->posting_modify_message_text($event);
	}

	public function load_signature_config($event)
	{
		if ($event['mode'] == 'signature')
		{
			$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
			$display_vars = $event['display_vars'];

			$add_signature_var = array(
				'gyazo_signature' =>
					array(
						'lang'		=> 'GYAZO_SIGNATURE',
						'validate'	=> 'bool',
						'type'		=> 'radio:yes_no',
						'explain'	=> false),
			);

			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_signature_var, array('after' =>'allow_sig_links'));
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}
}
