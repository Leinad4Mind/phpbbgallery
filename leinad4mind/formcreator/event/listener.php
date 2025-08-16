<?php
/**
*
* @package phpBB Extension - Form Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\formcreator\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $table_formcreator;

	/** @var \phpbb\files\factory */
	protected $files_factory;

	/**
	* Constructor
	*
	* @param \phpbb\user						$user
	* @param \phpbb\template\template			$template
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\config\config				$config
	* @param \phpbb\auth\auth					$auth
	* @param \phpbb\controller\helper			$helper
	* @param \phpbb\cache\service		 		$cache
	* @param \phpbb\request\request		 		$request
	* @param string								$root_path
	* @param string								$php_ext
	* @param string								$table_formcreator
	* @param \phpbb\files\factory				$files_factory
	*
	*/
	public function __construct(
		\phpbb\user $user,
		\phpbb\template\template $template,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\config\config $config,
		\phpbb\auth\auth $auth,
		\phpbb\controller\helper $helper,
		\phpbb\cache\service $cache,
		\phpbb\request\request $request,
		$root_path,
		$php_ext,
		$table_formcreator,
		\phpbb\files\factory $files_factory = null)
	{
		$this->user					= $user;
		$this->template				= $template;
		$this->db					= $db;
		$this->config				= $config;
		$this->auth 				= $auth;
		$this->helper 				= $helper;
		$this->cache 				= $cache;
		$this->request 				= $request;
		$this->root_path 			= $root_path;
		$this->php_ext 				= $php_ext;
		$this->table_formcreator 	= $table_formcreator;
		$this->files_factory 		= $files_factory;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.permissions'						=> 'add_permission',
			'core.posting_modify_message_text'		=> 'modify_message_text',
			'core.posting_modify_template_vars'		=> 'posting_modify_template_vars',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'leinad4mind/formcreator',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_form_creator'] = array('lang' => 'ACL_A_FORM_CREATOR', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function modify_message_text($event)
	{
		if ($event['mode'] == 'post' || $event['mode'] == 'edit' && $event['post_id'] == $event['post_data']['topic_first_post_id'])
		{
			$message = $this->request->variable('message', '', true);

			if ($message === '' || $this->request->is_set_post('form_creator_preview'))
			{
				$mode 			= $event['mode'];
				$forum_id 		= $event['forum_id'];
				$submit 		= $event['submit'];
				$preview 		= $event['preview'];
				$refresh 		= $event['refresh'];
				$message_parser = $event['message_parser'];
				$files 			= $this->request->get_super_global(\phpbb\request\request::FILES);

				$message = $this->grab_form_data($forum_id);
				foreach ($files as $key => $name)
				{
					$message_parser->parse_attachments($key, $mode, $forum_id, $submit, $preview, $refresh);
				}

				$message_parser->message = $message;
			}
		}
	}

	public function posting_modify_template_vars($event)
	{
		if ($event['mode'] == 'post' || $event['mode'] == 'edit' && $event['post_id'] == $event['post_data']['topic_first_post_id'])
		{
			$forum_id = $event['forum_id'];

			$this->build_form($forum_id);
		}
	}

	private function build_form($forum_id)
	{
		global $mode;

		$class = 'class="inputbox autowidth form-control input-sm"';
		$entry = "";

		$sql = 'SELECT id, form_id, ndx_order, name, hint, type, mandatory, options, forum_name, forum_id, forum_show_form, forum_force_form
			FROM ' . $this->table_formcreator . ' m, ' . FORUMS_TABLE . ' f
			WHERE m.form_id = ' . (int) $forum_id . '
				AND m.form_id = f.forum_id
			ORDER BY ndx_order ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['mandatory'])
			{
				$mandatory = " required ";
			}
			else
			{
				$mandatory = "";
			}

			$clean_name = 'templatefield_' . str_replace(' ', '_', $row['name']);

			// make things even easier to read //
			$name = "name='{$clean_name}'";
			$id = "id='{$clean_name}'";
			$placeholder = "placeholder='" . htmlspecialchars($row['hint'], ENT_QUOTES) . "' ";
			$tabindex = "tabindex='{$row['ndx_order']}' ";

			$type = "type='{$row['type']}' ";

			$size='size="40" ';
			$maxlength = 'maxlength="255" ';
			$cols='rows="3"';
			$rows='cols="76"';

			switch (strtolower($row['type']))
			{
				case 'email':
				case 'password':
				case 'url':
				case 'text':
				case 'file':
					$value = $this->request->variable($clean_name, '', true);
					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><input ' . $type . $name . $id . $placeholder . $mandatory . $size . $maxlength . $tabindex . $class . ' value="' . $value . '" /></div></div>';
				break;

				case 'textbox':
					$value = $this->request->variable($clean_name, '', true);
					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><textarea ' . $type . $name . $id . $rows . $cols . $tabindex . $placeholder . $mandatory . $class . '" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">' . $value . '</textarea></div></div>';
				break;

				case 'selectbox':
					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><select ' . $type . $name . $id . $tabindex . $mandatory . $class . '>';
					$entry .= '<option value="">----------------</option>';
					$select_option = explode(',', $row['options']);
					$selected = $this->request->variable($clean_name, false);
					foreach ($select_option as $value)
					{
						 $entry .='<option value="' . $value . '"' . ($value == $selected ? ' selected' : '') . '>'. $value .'</option>';
					}
					$entry .= '</select></div></div>';
				break;

				case 'radiobuttons':
					$radio_option = explode(',', $row['options']);
					$entry = '';
					$checked = $this->request->variable($clean_name, false);
					foreach ($radio_option as $value)
					{
						$entry .='<input type="radio" ' . $tabindex . $mandatory . $name . $id . '" value="' . $value . '"' . ($value == $checked ? ' checked' : '') . ' />&nbsp;'. $value . '&nbsp;&nbsp;';
					}
				break;

				case 'checkbox':
					$check_option = explode(',', $row['options']);
					$entry = '';
					$checked = $this->request->variable($clean_name, ['']);
					foreach ($check_option as $value)
					{
						$entry .='<input ' . $type . $tabindex . $mandatory . ' name="' . $clean_name .'[]"' . $id . '" value="'. $value .'"' . (in_array($value, $checked) ? ' checked' : '') . ' />&nbsp;'. $value .'&nbsp;&nbsp;';
					}
				break;

				default:
				break;
			}

			$mandatory = '';

			if ($row['mandatory'])
			{
				$mandatory = '<span class="mandatory">*</span>';
			}

			$this->template->assign_block_vars('form_creator_template', array(
				'NDX_ORDER' 	=> $row['ndx_order'],
				'NAME'			=> $row['name'],
				'CLEAN_NAME'	=> $clean_name,
				'HINT'			=> $row['hint'],
				'OPTIONS'		=> $row['options'],
				'TYPE'			=> $entry,
				'MANDATORY' 	=> $mandatory,
			));

			$this->template->assign_vars(array(
				'MODE'			=> $mode,
				'S_FORM_CREATOR'	=> true,
				'S_SHOW_FORM'	=> !$this->request->is_set_post('preview') && $row['forum_show_form'] || $this->request->is_set_post('form_creator_preview'),
				'S_FORCE_FORM'	=> $row['forum_force_form'],
			));
		}
		$this->db->sql_freeresult($result);
	}

	private function grab_form_data($forum_id)
	{
		$appform_post = '';
		$file_count = 0;
		$form_data = $names = array();

		$this->config['title_colour'] = (isset($this->config['title_colour'])) ? $this->config['title_colour'] : '#FF0000';

		$sql = 'SELECT *
			FROM ' . $this->table_formcreator . '
			WHERE form_id = ' . (int) $forum_id . '
			ORDER BY ndx_order ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$form_data[] = array(
				'id'			=> $row['id'],
				'form_id'		=> $row['form_id'],
				'hint'			=> $row['hint'],
				'options'		=> $row['options'],
				'mandatory'		=> $row['mandatory'],
				'name'			=> $row['name'],
				'type'			=> $row['type'],
				'ndx_order'		=> $row['ndx_order'],
				'name_before'	=> $row['name_before'],
				'name_after'	=> $row['name_after'],
				'value_before'	=> $row['value_before'],
				'value_after'	=> $row['value_after'],
			);

			if ($row['type'] == 'file')
			{
				$files[] = $row['name'];
			}
		}
		$this->db->sql_freeresult($result);

		$fileupload = $this->files_factory->get('upload');

		if (isset($files))
		{
			foreach ($files as $name)
			{
				$temp = $fileupload->handle_upload('files.types.form', 'upload');

				if ($temp->get('realname'))
				{
					$names[] = $temp->get('realname');
				}
			}
		}

		foreach ($form_data as $row)
		{
			$name = "templatefield_" . str_replace(' ', '_', $row['name']);

			if (isset($row['type']))
			{
				switch ($row['type'])
				{
					case 'checkbox':

						$check_box_items = count($this->request->variable($name, array(0 => 0)));
						$check_box_count = 0;
						$appform_post .= ($row['name_before'] ?: '[form][b]') . $row['name'] . ($row['name_after'] ?: ':[/b][/form]') . ($row['value_before'] ?: '[fbox]');

						$checkbox = $this->request->variable($name, array(0 => '') , true);

						foreach ($checkbox as $value)
						{
							$appform_post .= $value;

							if ($check_box_count < $check_box_items - 1)
							{
								$appform_post .= ', ';
							}
							$check_box_count++;
						}
						$appform_post .= ($row['value_after'] ?: '[/fbox]');

					break;

					case 'email':
					case 'password':
					case 'url':
					case 'text':
					case 'textbox':
					case 'selectbox':
					case 'radiobuttons':
						$fieldcontents = $this->request->variable($name, ' ', true);
						// only process if element has valid data //
						if ($fieldcontents)
						{
							$appform_post .= ($row['name_before'] ?: '[form][b]') . $row['name'] . ($row['name_after'] ?: ':[/b][/form]');
							$appform_post .= ($row['value_before'] ?: '[fbox]') . $fieldcontents . ($row['value_after'] ?: '[/fbox]');
						}
					break;

					case 'file':
						$fieldcontents = $this->request->variable($name, ' ', true);
						// only process if element has valid data //
						if ($fieldcontents)
						{
							$appform_post .= ($row['name_before'] ?: '[b]') . $row['name'] . ($row['name_after'] ?: ':[/b]');
							$appform_post .= ($row['value_before'] ?: '[att]') . '[attachment=' . $file_count . ']' . $names[$file_count] . '[/attachment]' . $fieldcontents . ($row['value_after'] ?: '[/att]');
							$file_count++;
						}
					break;

					default:
					break;
				}
			}
		}

		return $appform_post;
	}
}
