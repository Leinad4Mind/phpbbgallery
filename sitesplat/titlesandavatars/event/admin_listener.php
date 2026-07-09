<?php
/**
*
* BBAvatars
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\titlesandavatars\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class admin_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add' => 'add_config',
		);
	}

	/* @var \phpbb\config\config*/
	protected $config;

	protected $request;
	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template			$template	Template object
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\controller\helper $helper, \phpbb\template\template $template)
	{
		$this->config = $config;
		$this->request = $request;
		$this->helper = $helper;
		$this->template = $template;
	}

	public function add_config($event)
	{
		if ($event['mode'] == 'avatar')
		{
			$display_vars = $event['display_vars'];

			$add_config_var['titles_avatar_setting'] =
				array(
					'lang' 		=> 'TAT_SHOW_AVATARS',
					'validate'	=> 'int',
					'type'		=> 'custom', 
					'function' => __NAMESPACE__.'\admin_listener::type_select',
					'explain'	=> true
				);
			$add_config_var['titles_avatar_memberlist'] =
				array(
					'lang' 		=> 'TAT_SHOW_AVATARS_ML',
					'validate'	=> 'bool',
					'type'		=> 'radio:yes_no', 
					'explain'	=> false
				);
			$add_config_var['titles_avatar_participants'] =
				array(
					'lang' 		=> 'TAT_SHOW_AVATARS_PP',
					'validate'	=> 'bool',
					'type'		=> 'radio:yes_no', 
					'explain'	=> false
				);
			$add_config_var['titles_avatar_online'] =
				array(
					'lang' 		=> 'TAT_SHOW_AVATARS_OL',
					'validate'	=> 'bool',
					'type'		=> 'radio:yes_no', 
					'explain'	=> false
				);
				
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_config_var, array('after' =>'allow_avatar'));
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}

	static function type_select($value, $key)
	{
		global $config, $user;
		$options_aray = array(0 => $user->lang['TAT_BOTH'], 1 => $user->lang['TAT_FIRST'], 2 => $user->lang['TAT_LAST']);
		$type_options = '';
		foreach ($options_aray as $key => $value)
		{
			$selected = ($key == $config['titles_avatar_setting']) ? ' selected="selected"' : '';
			$type_options .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
			
		}
		return '<select style="width:140px;" name="config[titles_avatar_setting]" id="titles_avatar_setting">' . $type_options . '</select>';
	}

}
