<?php
/**
*
* Genders extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\genders\event;

/**
* @ignore
*/
use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use rmcgirr83\genders\core\gender_constants;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	public function __construct(
		language $language,
		request $request,
		template $template,
		user $user,
		$root_path,
		$php_ext)
	{
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_extensions_run_action_after'	=>	'acp_extensions_run_action_after',
			'core.ucp_profile_modify_profile_info'		=> 'user_gender_profile',
			'core.ucp_profile_info_modify_sql_ary'		=> 'user_gender_profile_sql',
			'core.acp_users_modify_profile'				=> 'user_gender_profile',
			'core.acp_users_profile_modify_sql_ary'		=> 'user_gender_profile_sql',
			'core.viewtopic_cache_user_data'			=> 'viewtopic_cache_user_data',
			'core.viewtopic_cache_guest_data'			=> 'viewtopic_cache_guest_data',
			'core.viewtopic_modify_post_row'			=> 'viewtopic_modify_post_row',
			'core.memberlist_view_profile'				=> 'memberlist_view_profile',
			'core.search_get_posts_data'				=> 'search_get_posts_data',
			'core.search_modify_tpl_ary'				=> 'search_modify_tpl_ary',
			'core.ucp_register_data_before'				=> 'user_gender_profile',
			'core.ucp_register_user_row_after'			=> 'user_gender_registration_sql',
		);
	}

	/* Display additional metadata in extension details
	*
	* @param $event			event object
	* @param return null
	* @access public
	*/
	public function acp_extensions_run_action_after($event)
	{
		if ($event['ext_name'] == 'rmcgirr83/genders' && $event['action'] == 'details')
		{
			$this->language->add_lang('genders', $event['ext_name']);
			$this->template->assign_var('S_BUY_ME_A_BEER_GENDERS', true);
		}
	}

	/**
	* Allow users to change their gender
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_gender_profile($event)
	{
		if (DEFINED('IN_ADMIN'))
		{
			$user_gender = $this->request->variable('user_gender', $event['user_row']['user_gender']);
		}
		else
		{
			$user_gender = $this->request->variable('user_gender', $this->user->data['user_gender']);
		}
		// Request the user option vars and add them to the data array
		$event['data'] = array_merge($event['data'], [
			'user_gender'	=> $user_gender,
		]);

		$this->language->add_lang('genders', 'rmcgirr83/genders');

		$genders = gender_constants::getGenderChoices();
		$gender_image = $gender_options = '';

		foreach ($genders as $key => $value)
		{
			$selected = ($user_gender == $value) ? ' selected="selected"' : '';
			$gender_options .= '<option value="' . $value . '" ' . $selected . '>' . $this->language->lang($key) . '</option>';
			$gender_image .= ($user_gender == $value) ? strtolower($key) : '';
		}

		$this->template->assign_vars([
			'USER_GENDER'		=> $gender_image,
			'S_GENDER_OPTIONS'	=> $gender_options,
		]);
	}

	/**
	* User changed their gender so update the database
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_gender_profile_sql($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], [
				'user_gender' => $event['data']['user_gender'],
		]);
	}

	/**
	* Update viewtopic user data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_cache_user_data($event)
	{
		$array = $event['user_cache_data'];
		$array['user_gender'] = $event['row']['user_gender'];
		$event['user_cache_data'] = $array;
	}

	/**
	* Update viewtopic guest data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_cache_guest_data($event)
	{
		$array = $event['user_cache_data'];
		$array['user_gender'] = '';
		$event['user_cache_data'] = $array;
	}

	/**
	* Modify the viewtopic post row
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_modify_post_row($event)
	{
		$gender = '';
		if ($event['user_poster_data']['user_type'] != USER_IGNORE)
		{
			$gender = $this->display_user_gender($event['user_poster_data']['user_gender']);
		}

		$event['post_row'] = array_merge($event['post_row'],[
			'USER_GENDER' => $gender,
		]);
	}

	/**
	* Display gender on viewing user profile
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function memberlist_view_profile($event)
	{
		$gender = '';
		if ($event['member']['user_type'] != USER_IGNORE)
		{
			$gender = $this->display_user_gender($event['member']['user_gender']);
		}

		$this->template->assign_vars([
			'USER_GENDER'	=> $gender,
		]);
	}

	/**
	* Display gender on search
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function search_get_posts_data($event)
	{
		$array = $event['sql_array'];
		$array['SELECT'] .= ', u.user_gender, u.user_type';
		$event['sql_array'] = $array;
	}

	/**
	* Display gender on search
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function search_modify_tpl_ary($event)
	{
		if ($event['show_results'] == 'topics')
		{
			return;
		}

		$array = $event['tpl_ary'];
		$gender = '';
		if ($event['row']['user_type'] != USER_IGNORE)
		{
			$gender = $this->display_user_gender($event['row']['user_gender']);
		}
		$array = array_merge($array, [
			'USER_GENDER'	=> $gender,
		]);

		$event['tpl_ary'] = $array;
	}

	/**
	* Update registration data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_gender_registration_sql($event)
	{
		$event['user_row'] = array_merge($event['user_row'], [
				'user_gender' => $this->request->variable('user_gender', 0),
		]);
	}

	/**
	 * display user gender
	 *
	 * @author RMcGirr83
	 * @param int $user_gender User's gender
	 * @return string Gender image
	 */
	private function display_user_gender($user_gender)
	{
		$this->language->add_lang('genders', 'rmcgirr83/genders');
		$genders = gender_constants::getGenderChoices();
		$gender = '';
		foreach ($genders as $key => $value)
		{
			if ((int) $user_gender == $value && $user_gender <> 0)
			{
				$gender = '<i class="fa ' . strtolower($key) . '" style="font-size:12px" title="' . $this->language->lang($key) . '"></i>';
			}
		}

		return $gender;
	}
}
