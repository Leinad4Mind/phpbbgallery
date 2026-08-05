<?php
/**
 *
 * @package phpBB Extension - Username Colour Changer
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\usernamecolourchanger\event;

use dmzx\usernamecolourchanger\core\colour_helper;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var driver_interface */
	protected $db;

	/** @var config */
	protected $config;

	/** @var language */
	protected $language;

	/** @var colour_helper */
	protected $colour_helper;

	public function __construct(
		request_interface $request,
		template $template,
		user $user,
		auth $auth,
		driver_interface $db,
		config $config,
		language $language,
		colour_helper $colour_helper
	)
	{
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->db = $db;
		$this->config = $config;
		$this->language = $language;
		$this->colour_helper = $colour_helper;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.permissions' => 'add_permission',
			'core.acp_users_modify_profile' => 'acp_modify_profile',
			'core.acp_users_profile_validate' => 'acp_validate_profile',
			'core.acp_users_profile_modify_sql_ary' => 'acp_modify_sql_ary',
			'core.ucp_profile_modify_profile_info' => 'ucp_modify_profile',
			'core.ucp_profile_validate_profile_info' => 'ucp_validate_profile',
			'core.ucp_profile_info_modify_sql_ary' => 'ucp_modify_sql_ary',
		];
	}

	/**
	 * @param object $event Event object
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_usernamecolourchanger_use'] = [
			'lang' => 'ACL_U_USERNAMECOLOURCHANGER_USE',
			'cat' => 'misc',
		];
		$event['permissions'] = $permissions;
	}

	/**
	 * @param object $event Event object
	 */
	public function acp_modify_profile($event)
	{
		$this->language->add_lang('common', 'dmzx/usernamecolourchanger');

		$data = $event['data'];
		$data['user_colour'] = $this->request->variable(
			'user_colour',
			(string) $event['user_row']['user_colour']
		);
		$event['data'] = $data;

		$this->template->assign_vars([
			'USER_COLOUR' => $data['user_colour'],
			'USER_COLOUR_PREVIEW' => $this->preview_colour($data['user_colour']),
		]);
	}

	/**
	 * @param object $event Event object
	 */
	public function acp_validate_profile($event)
	{
		$this->validate_colour($event);
	}

	/**
	 * @param object $event Event object
	 */
	public function acp_modify_sql_ary($event)
	{
		$this->apply_colour_change(
			$event,
			(int) $event['user_id'],
			(string) $event['user_row']['user_colour']
		);
	}

	/**
	 * @param object $event Event object
	 */
	public function ucp_modify_profile($event)
	{
		$this->language->add_lang('common', 'dmzx/usernamecolourchanger');

		$can_change_colour = (bool) $this->auth->acl_get('u_usernamecolourchanger_use');
		$this->template->assign_var('USE_USERNAMECOLOURCHANGER', $can_change_colour);

		if (!$can_change_colour)
		{
			return;
		}

		$data = $event['data'];
		$data['user_colour'] = $this->request->variable(
			'user_colour',
			(string) $this->user->data['user_colour']
		);
		$event['data'] = $data;

		$this->template->assign_vars([
			'COLOUR' => $data['user_colour'],
			'COLOUR_PREVIEW' => $this->preview_colour($data['user_colour']),
		]);
	}

	/**
	 * @param object $event Event object
	 */
	public function ucp_validate_profile($event)
	{
		if (!$this->auth->acl_get('u_usernamecolourchanger_use'))
		{
			return;
		}

		$this->validate_colour($event);
	}

	/**
	 * @param object $event Event object
	 */
	public function ucp_modify_sql_ary($event)
	{
		if (!$this->auth->acl_get('u_usernamecolourchanger_use'))
		{
			return;
		}

		$this->apply_colour_change(
			$event,
			(int) $this->user->data['user_id'],
			(string) $this->user->data['user_colour']
		);
	}

	/**
	 * @param object $event Event object
	 */
	private function validate_colour($event)
	{
		$data = $event['data'];
		if (!array_key_exists('user_colour', $data))
		{
			return;
		}

		$normalised = $this->colour_helper->normalise($data['user_colour']);
		if ($normalised === false)
		{
			$error = $event['error'];
			$error[] = 'USERNAMECOLOURCHANGER_INVALID_COLOUR';
			$event['error'] = $error;
			return;
		}

		$data['user_colour'] = $normalised;
		$event['data'] = $data;
	}

	/**
	 * @param object $event Event object
	 * @param int    $user_id Target user ID
	 * @param string $old_colour Existing colour
	 */
	private function apply_colour_change($event, $user_id, $old_colour)
	{
		$data = $event['data'];
		if (!array_key_exists('user_colour', $data))
		{
			return;
		}

		$new_colour = $this->colour_helper->normalise($data['user_colour']);
		if ($new_colour === false)
		{
			return;
		}

		$old_colour = $this->colour_helper->normalise($old_colour);
		if ($old_colour !== false && $new_colour === $old_colour)
		{
			return;
		}

		$sql_ary = $event['sql_ary'];
		$sql_ary['user_colour'] = $new_colour;
		$event['sql_ary'] = $sql_ary;

		$this->update_cached_colours($user_id, $new_colour);
	}

	/**
	 * @param int    $user_id User ID
	 * @param string $user_colour Canonical username colour
	 */
	private function update_cached_colours($user_id, $user_colour)
	{
		$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', [
				'topic_last_poster_colour' => $user_colour,
			]) . '
			WHERE topic_last_poster_id = ' . (int) $user_id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', [
				'topic_first_poster_colour' => $user_colour,
			]) . '
			WHERE topic_poster = ' . (int) $user_id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . FORUMS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', [
				'forum_last_poster_colour' => $user_colour,
			]) . '
			WHERE forum_last_poster_id = ' . (int) $user_id;
		$this->db->sql_query($sql);

		if ((int) $this->config['newest_user_id'] === (int) $user_id)
		{
			$this->config->set('newest_user_colour', $user_colour, false);
		}
	}

	/**
	 * @param string $colour Colour value
	 * @return string
	 */
	private function preview_colour($colour)
	{
		$colour = $this->colour_helper->normalise($colour);

		return $colour === false ? '' : $colour;
	}
}
