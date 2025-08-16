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

use leinad4mind\formcreator\ext;
use phpbb\extension\exception;
use phpbb\textformatter\parser_interface;
use phpbb\textformatter\renderer_interface;
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
		\phpbb\files\factory $files_factory
	)
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
		return [
			'core.user_setup'						=> 'load_language_on_setup',
			'core.permissions'						=> 'add_permission',
			'core.posting_modify_message_text'		=> 'modify_message_text',
			'core.posting_modify_template_vars'		=> 'posting_modify_template_vars',
		];
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'leinad4mind/formcreator',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_permission($event)
	{
		$event['permissions'] = array_merge($event['permissions'], [
			'a_form_creator'	=> ['lang' => 'ACL_A_FORM_CREATOR', 'cat' => 'misc'],
			'f_form_creator'	=> ['lang' => 'ACL_F_FORM_CREATOR', 'cat' => 'misc'],
		]);
	}

	private function can_use_form($event)
	{
		return $this->auth->acl_get('f_form_creator', $event['forum_id']) && ($event['mode'] == 'post' || $event['mode'] == 'edit' && $event['post_id'] == $event['post_data']['topic_first_post_id']);
	}

	public function modify_message_text($event)
	{
		if ($this->can_use_form($event))
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

				try
				{
					$message = $this->grab_form_data($forum_id);

					foreach ($files as $key => $name)
					{
						$message_parser->parse_attachments($key, $mode, $forum_id, $submit, $preview, $refresh);
					}

					$message_parser->message = $message;
				}
				catch (exception $e)
				{
					$event['error'] = array_merge($event['error'], $e->get_parameters());
				}
			}
		}
	}

	public function posting_modify_template_vars($event)
	{
		if ($this->can_use_form($event))
		{
			$this->build_form($event['forum_id'], $event['mode']);
		}
	}

	private function build_form($forum_id, $mode)
	{
		global $phpbb_container;

		$sql = 'SELECT m.*, f.forum_name, f.forum_id, f.forum_force_form, f.forum_show_form
			FROM ' . $this->table_formcreator . ' m, ' . FORUMS_TABLE . ' f
			WHERE m.form_id = ' . (int) $forum_id . '
				AND m.form_id = f.forum_id
			ORDER BY ndx_order ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$entry 			= '';
			$clean_name 	= 'templatefield_' . $row['id'];

			$mandatory		= $row['mandatory'] ? ' required' : '';
			$class 			= ' class="inputbox autowidth form-control"';
			$name			= ' name="' . $clean_name . '"';
			$name_array		= ' name="' . $clean_name . '[]"';
			$id				= ' id="' . $clean_name . '"';
			$placeholder	= ' placeholder="' . $row['hint'] . '"';
			$tabindex		= ' tabindex="' . ($row['ndx_order'] + 10) . '"';
			$type			= ' type="' . $row['type'] . '"';
			$size			= ' size="40"';
			$maxlength		= ' maxlength="255"';
			$cols			= ' rows="3"';
			$rows			= ' cols="76"';

			switch (strtolower($row['type']))
			{
				case 'email':
				case 'password':
				case 'url':
				case 'text':
				case 'file':
				case 'date':
				case 'time':
					$value = $this->request->variable($clean_name, '', true);
					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><input' . $type . $name . $id . $placeholder . $mandatory . $size . $maxlength . $tabindex . $class . ' value="' . $value . '"></div></div>';
				break;

				case 'number':
					$value = $this->request->variable($clean_name, 0);
					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><input' . $type . $name . $id . $placeholder . $mandatory . $size . $tabindex . $class . ' value="' . $value . '"></div></div>';
				break;

				case 'textbox':
					$value = $this->request->variable($clean_name, '', true);
					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><textarea' . $type . $name . $id . $rows . $cols . $tabindex . $placeholder . $mandatory . $class . '" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">' . $value . '</textarea></div></div>';
				break;

				case 'selectbox':
					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><select'. $type . $name . $id . $tabindex . $mandatory . $class . '>';
					$entry .= '<option value="">----------------</option>';
					$select_option = ext::explode([',', "\n"], $row['options']);
					$select_option = array_map('trim', $select_option);
					$selected = $this->request->variable($clean_name, '');
					foreach ($select_option as $value)
					{
						 $entry .= '<option value="' . $value . '"' . ($value == $selected ? ' selected' : '') . '>' . $value . '</option>';
					}
					$entry .= '</select></div></div>';
				break;

				case 'radiobuttons':
					$radio_option = ext::explode([',', "\n"], $row['options']);
					$radio_option = array_map('trim', $radio_option);
					$checked = $this->request->variable($clean_name, '');
					foreach ($radio_option as $value)
					{
						$entry .= '<label><input type="radio"' . $tabindex . $mandatory . $name . $id . ' value="' . $value . '"' . ($value == $checked ? ' checked' : '') . '>&nbsp;' . $value . '&nbsp;&nbsp;</label>';
					}
				break;

				case 'checkbox':
					$check_option = ext::explode([',', "\n"], $row['options']);
					$check_option = array_map('trim', $check_option);
					$checked = $this->request->variable($clean_name, [0 => '']);
					foreach ($check_option as $value)
					{
						$entry .= '<label><input' . $type . $tabindex . $name_array . $id . ' value="'. $value .'"' . (in_array($value, $checked) ? ' checked' : '') . '>&nbsp;' . $value . '&nbsp;&nbsp;</label>';
					}
				break;

				default:
				break;
			}

			/** @var renderer_interface $renderer */
			$renderer = $phpbb_container->get('text_formatter.renderer');

			/** @var parser_interface $parser */
			$parser = $phpbb_container->get('text_formatter.parser');

			$this->template->assign_block_vars('form_creator_template', [
				'ID'			=> $row['id'],
				'NDX_ORDER' 	=> $row['ndx_order'],
				'NAME'			=> $row['name'],
				'NAME_RICH'		=> $renderer->render($parser->parse($row['name'])),
				'NAME_VISIBLE'	=> $row['name_visible'],
				'EXPLAIN'		=> $row['explanation'],
				'CLEAN_NAME'	=> $clean_name,
				'HINT'			=> $row['hint'],
				'OPTIONS'		=> $row['options'],
				'ENTRY'			=> $entry,
				'MANDATORY' 	=> $row['mandatory'] ? '<span class="mandatory">*</span>' : '',
			]);

			$this->template->assign_vars([
				'MODE'			=> $mode,
				'S_FORM_CREATOR'	=> true,
				'S_SHOW_FORM'	=> !$this->request->is_set_post('preview') && $row['forum_show_form'] || $this->request->is_set_post('form_creator_preview'),
				'S_FORCE_FORM'	=> $row['forum_force_form'],
			]);
		}
		$this->db->sql_freeresult($result);
	}

	private function grab_form_data($forum_id)
	{
		$appform_post = '';
		$file_count = 0;
		$form_data = $names = $files = [];
		$errors = [];

		$this->config['title_colour'] = (isset($this->config['title_colour'])) ? $this->config['title_colour'] : '#FF0000';

		$sql = 'SELECT *
			FROM ' . $this->table_formcreator . '
			WHERE form_id = ' . (int) $forum_id . '
			ORDER BY ndx_order ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$form_data[] = $row;

			if ($row['type'] == 'file')
			{
				$files[] = $row['name'];
			}
		}
		$this->db->sql_freeresult($result);

		$fileupload = $this->files_factory->get('upload');

		foreach ($files as $name)
		{
			$temp = $fileupload->handle_upload('files.types.form', 'upload');

			if ($temp->get('realname'))
			{
				$names[] = $temp->get('realname');
			}
		}

		foreach ($form_data as $row)
		{
			$name = 'templatefield_' . $row['id'];

			if (isset($row['type']))
			{
				switch ($row['type'])
				{
					case 'email':
					case 'password':
					case 'url':
					case 'text':
					case 'textbox':
					case 'selectbox':
					case 'radiobuttons':
					case 'date':
					case 'time':
						$value = $this->request->variable($name, '', true);
						$appform_post .= $this->create_form_element($row, $value, $value);
					break;

					case 'checkbox':
						$value = $this->request->variable($name, [0 => ''] , true);
						if ($row['max_value'] && $row['min_value'] <= $row['max_value'] && (sizeof($value) < $row['min_value'] || sizeof($value) > $row['max_value']))
						{
							$errors[] = $this->user->lang('ERROR_MIN_MAX_CHECKBOX', $row['min_value'], $row['max_value'], $this->get_clean_name($row['name']));
						}
						$appform_post .= $this->create_form_element($row, $value, implode($value, $row['options_separator']));
					break;

					case 'number':
						$value = $this->request->variable($name, 0);
						$appform_post .= $this->create_form_element($row, $value, $value);
					break;

					case 'file':
						$value = $this->request->variable($name, '', true);
						$appform_post .= $this->create_form_element($row, $value, '[attachment=' . $file_count . ']' . $names[$file_count] . '[/attachment]' . $value, 'att');
						$file_count++;
					break;

					default:
					break;
				}
			}
		}

		if ($errors)
		{
			throw new exception('', $errors);
		}

		return $appform_post;
	}

	private function create_form_element(array $element, $value, $value_rich, $container = 'fbox')
	{
		$content = '';

		if ($value)
		{
			if ($element['name_visible'])
			{
				$content .= (ext::trim_once($element['name_before']) ?: '[form][b]') . $this->get_clean_name($element['name']) . (ext::trim_once($element['name_after']) ?: ':[/b][/form]');
			}

			$content .= ext::trim_once($element['value_before']) ?: ('[' . $container . ']');
			$content .= $value_rich;
			$content .= ext::trim_once($element['value_after']) ?: ('[/' . $container . ']');
		}

		return $content;
	}

	private function get_clean_name($name)
	{
		strip_bbcode($name, '?');
		return trim($name);
	}

}
