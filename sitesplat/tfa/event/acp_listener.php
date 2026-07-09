<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\event;

use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use sitesplat\tfa\helper\session_helper_interface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class acp_listener implements EventSubscriberInterface
{
	protected $helper;
	protected $template;
	protected $user;

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(helper $helper, template $template, user $user)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add' => 'add_config',
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function add_config($event)
	{
		if ($event['mode'] == 'registration')
		{
			$display_vars = $event['display_vars'];

			$add_config_var['tfa_setting'] =
				array(
					'lang' 		=> 'TFA_SETTING',
					'validate'	=> 'int',
					'type'		=> 'custom', 
					'function' => __NAMESPACE__.'\acp_listener::type_select',
					'explain'	=> true
				);
				
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_config_var, array('after' =>'chg_passforce'));
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	static function type_select($value, $key)
	{
		global $user;
		$tfa_ary = array(
			'TFA_DISABLED'					=> session_helper_interface::MODE_DISABLED,
			'TFA_NOT_REQUIRED'				=> session_helper_interface::MODE_NOT_REQUIRED,
			'TFA_REQUIRED_FOR_ACP_LOGIN'	=> session_helper_interface::MODE_REQUIRED_FOR_ACP_LOGIN,
			'TFA_REQUIRED_FOR_ADMIN'		=> session_helper_interface::MODE_REQUIRED_FOR_ADMIN,
			'TFA_REQUIRED_FOR_MODERATOR'	=> session_helper_interface::MODE_REQUIRED_FOR_MODERATOR,
			'TFA_REQUIRED'					=> session_helper_interface::MODE_REQUIRED,
		);
		$tfa_options = '<select style="width:230px;" name="config[tfa_setting]" id="tfa_setting" title="' . $user->lang['TFA'] . '">';
		foreach ($tfa_ary as $key => $data)
		{
			$selected = ($data == $value) ? ' selected="selected"' : '';
			$tfa_options .= '<option value="' . $data . '"' . $selected . '>' . $user->lang($key) . '</option>';
		}
		return $tfa_options . '</select>';
	}
}
