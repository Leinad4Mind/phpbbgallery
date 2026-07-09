<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\ucp;

use phpbb\config\config;
use sitesplat\tfa\helper\session_helper;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use phpbb\db\driver\driver_interface;

class tfa_module
{
	public $u_action;
	public $page_title;
	public $tpl_name;
	private $config;
	private $user;
	private $db;
	private $template;
	private $request;
	private $session_helper;

	/**
	 * {@inheritdoc}
	 */
	private function setup(config $config, user $user, driver_interface $db, template $template, request_interface $request, session_helper $session_helper, $registration_table)
	{
		$this->config = $config;
		$this->user = $user;
		$this->db = $db;
		$this->template = $template;
		$this->request = $request;
		$this->session_helper = $session_helper;
		$this->registration_table = $registration_table;
	}

	/**
	 * {@inheritdoc}
	 */
	public function main($id, $mode)
	{
		global $config, $user, $db, $template;
		global $request, $phpbb_container;

		$user->add_lang('posting');
		$user->add_lang_ext('sitesplat/tfa', array('common', 'ucp_tfa'));

		$this->setup($config, $user, $db, $template, $request, $phpbb_container->get('sitesplat.tfa.sessionhelper'), $phpbb_container->getParameter('sitesplat.tfa.tables.registration'));

		$this->createPage();
	}

	/**
	 * {@inheritdoc}
	 */
	private function register_security_key()
	{
		try
		{
			require_once './ext/sitesplat/tfa/helper/loader.php';
        	\Loader::register('lib','RobThree\\Auth');
        
       		$tfa = new \RobThree\Auth\TwoFactorAuth($this->config['server_name']);

			$error = array();
			$submit = $this->request->variable('register', false, false, \phpbb\request\request_interface::POST);

			if ($submit)
			{
				$secret = $this->request->variable('secret', '');
				$code	= $this->request->variable('register', '');
	  
				if ($tfa->verifyCode($secret, $code) === true)
				{
					$sql_ary = array(
						'user_id' 		=> $this->user->data['user_id'],
						'secret'		=> $secret,
						'registered' 	=> time(),
						'last_used' 	=> time(),
					);
				
					$sql = 'INSERT INTO ' . $this->registration_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
					$this->db->sql_query($sql);

					meta_refresh(3, $this->u_action);
					$message = $this->user->lang('TFA_KEY_ADDED') . '<br /><br />' . $this->user->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>');
					trigger_error($message);
				}
			}
			
			$secret = $tfa->createSecret();
			$code = $tfa->getCode($secret);
		
			$this->template->assign_vars(array(
				'S_UCP_ACTION'    			=> $this->u_action,
				'TFA_QR_CODE'				=> $tfa->getQRCodeImageAsDataUri(generate_board_url(), $secret),
				'TFA_SECRET'				=> $secret,
				'L_TFA_ADD_OTP_KEY_EXPLAIN'	=> $this->user->lang('TFA_ADD_OTP_KEY_EXPLAIN', chunk_split($secret, 4, ' ')),
				'S_HIDDEN_FIELDS_MODULE'	=> build_hidden_fields(array(
					'secret'	=> $secret,
				)),
			));
			$this->tpl_name = 'tfa_otp_ucp_new';
			
		}
		catch (\Exception $e)
		{
			$error[] = $e->getMessage();
		}

		return $error;
	}

	/**
	 * {@inheritdoc}
	 */
	private function createPage()
	{
		$error = array();
		$s_hidden_fields = '';

		add_form_key('ucp_tfa_keys');

		$module_row = $this->request->variable('md', 'tfa', true, \phpbb\request\request_interface::POST);

		// Set desired template
		$this->tpl_name = 'ucp_tfa';
		$this->page_title = 'UCP_TFA';

		if (!empty($module_row))
		{
			switch ($module_row)
			{
				case $this->user->lang('DELETE_MARKED'):
					if (!check_form_key('ucp_tfa_keys'))
					{
						$error[] = 'FORM_INVALID';
					} else
					{
						$this->delete_keys();
					}
					break;

				case $this->user->lang('TFA_NEW'):
					$error = array_merge($this->register_security_key(), $error);

					if (!sizeof($error))
					{
						return;
					}
					break;

				default:
			}
		}

		// Replace "error" strings with their real, localised form
		$error = array_map(array(
			$this->user,
			'lang',
		), $error);

		$sql = 'SELECT *
				FROM ' . $this->registration_table . '
				WHERE user_id = ' . (int) $this->user->data['user_id'] . ' 
				ORDER BY registration_id ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('keys', array(
				'ID'            => $row['registration_id'],
				'REGISTERED'    => $this->user->format_date($row['registered']),
				'LAST_USED'     => $row['last_used'] ? $this->user->format_date($row['last_used']) : false,
				'LOGGED_IN'		=> @gethostbyaddr($row['ip_address'])
			));
		}
		$this->db->sql_freeresult($result);
		
		$this->template->assign_vars(array(
			'ERROR'           => (sizeof($error)) ? implode('<br />', $error) : '',
			'L_TITLE'         => $this->user->lang('UCP_TFA'),
			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_UCP_ACTION'    => $this->u_action,
		));
	}

	/**
	 * {@inheritdoc}
	 */
	private function delete_keys()
	{
		$keys = $this->request->variable('keys', array(0 => 0));
		if (!empty($keys))
		{
			foreach ($keys as $row)
			{
				$sql = 'DELETE FROM ' . $this->registration_table . '
						WHERE user_id = ' . (int) $this->user->data['user_id'] . '
						AND registration_id =' . (int) $row;
				$this->db->sql_query($sql);
			}
		}
		meta_refresh(3, $this->u_action);
		$message = $this->user->lang('TFA_KEYS_DELETED') . '<br /><br />' . $this->user->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>');
		trigger_error($message);
	}
}
