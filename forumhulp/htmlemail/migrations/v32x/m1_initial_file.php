<?php
/**
*
* HTML email extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace forumhulp\htmlemail\migrations\v32x;

use phpbb\db\migration\container_aware_migration;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_file extends container_aware_migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\forumhulp\htmlemail\migrations\v31x\m1_initial_file');
	}

	/**
	* Add core change to the files.
	*
	* @return array Array of files
	* @access public
	*/
	public function update_data()
	{
		$this->revert = false;
		return array(
			array('custom', array(array($this, 'update_files'))),
		);
	}

	public function revert_data()
	{
		$this->revert = true;
		return array(
			array('custom', array(array($this, 'update_files'))),
		);
	}

	public function update_files()
	{
		if (class_exists('forumhulp\helper\helper'))
		{
			if (!$this->container->has('forumhulp.helper'))
			{
				$forumhulp_helper = new \forumhulp\helper\helper(
					$this->container->get('dbal.conn'),
					$this->config,
					$this->container->get('ext.manager'),
					$this->container->get('template'),
					$this->container->get('user'),
					$this->container->get('request'),
					$this->container->get('log'),
					$this->container->get('cache'),
					$this->phpbb_root_path			
				);
				$this->container->set('forumhulp.helper', $forumhulp_helper);
			}
			$this->container->get('forumhulp.helper')->update_files($this->data(), $this->revert);
		} else
		{
			$this->container->get('user')->add_lang_ext('forumhulp/htmlemail', 'info_acp_htmlemail');
			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);	
		}
	}

	public function data()
	{
		$replacements = array(
			'files' => array(
				0 => '/phpbb/notification/method/messenger_base.' . $this->php_ext,
				),
			'searches' => array(
				0 => array(
					0 => '$messenger = new \messenger();'
					)
				),
			'replaces' => array(
				0 => array(
					0 => '$messenger = new \messenger();

		$use_html = is_callable(array($messenger, set_mail_html));
		($use_html) ? $messenger->set_mail_html($this->config[\'html_email_on_birthday\']) : null;'
					)
				)
			);
		return $replacements;
	}
}
