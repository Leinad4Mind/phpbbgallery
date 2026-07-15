<?php
/**
*
* Fancy Lazy Topics Loader
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\fltl\event;

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
		if($event['mode'] == 'settings')
		{
			if ($this->request->is_set_post('submit'))
			{
				$this->config->set('fltl_excluded_forums', json_encode($this->request->variable('fltl_excluded_forums', array(0))));
			}

			$display_vars = $event['display_vars'];
			$submit_key = array_search('ACP_SUBMIT_CHANGES', $display_vars['vars']);
			$submit_legend_number = substr($submit_key, 6);
			$display_vars['vars']['legend'.$submit_legend_number] = 'FLTL';
			$new_vars = array(
				'fltl_limit'	=> array('lang' => 'FLTL_LIMIT',	'validate' => 'int:4:20',	'type' => 'number:0:9999', 'explain' => true),

				'fltl_time'	=> array('lang' => 'FLTL_TIME',	'validate' => 'int:0:20',	'type' => 'number:0:9999', 'explain' => true),

				'fltl_type'		=> array('lang' => 'FLTL_TYPE',	'validate' => 'string', 'type' => 'custom', 'function' => __NAMESPACE__.'\admin_listener::type_select',  'explain' => true),
				
				'fltl_excluded_forums'	=> array('lang' => 'FLTL_EXCLUDED_FORUMS',	'validate' => 'string', 'type' => 'custom', 'function' => __NAMESPACE__.'\admin_listener::forum_select', 'explain' => true),
				'legend'.($submit_legend_number + 1)	=> 'ACP_SUBMIT_CHANGES',
			);
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $new_vars, array('after' => $submit_key));
			$event['display_vars'] = $display_vars;
		}
	}

	static function type_select($value, $key)
	{
		global $config;
		$options_aray = array('first', 'last');
		$type_options = '';
		foreach ($options_aray as $value)
		{
			$type_options .= '<option value="' . $value . '"' . (($value == ((isset($config['fltl_type'])) ? 
							$config['fltl_type'] : 'last')) ? ' selected="selected"' : '') . '>' . $value . '</option>';
			
		}
		return '<select style="width:140px;" name="config[fltl_type]" id="fltl_type" title="Sort order">' . $type_options . '</select>';
	}

	static function forum_select($value, $key)
	{
		global $config, $db;
		$forum_excluded_aray = json_decode($config['fltl_excluded_forums'], true);
		$forum_options = '';
		
		$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) 
		{
			$forum_options .= '<option value="' . $row['forum_id'] . '"' . 
								((in_array($row['forum_id'], $forum_excluded_aray)) ? ' selected="selected"' : '') . '>' . $row['forum_name'] . '</option>';
		}
		return '<select multiple style="width:140px;" size="10" name="fltl_excluded_forums[]" id="fltl_excluded_forums" title="Exclude forums">' . $forum_options . '</select>';

	}

}
