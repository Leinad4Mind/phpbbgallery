<?php
/**
*
* UserDefaults extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\userdefault\migrations\v31x;

use phpbb\db\migration\container_aware_migration;

/**
* Migration stage 1: Initial data changes to the database
*/
class m1_initial_data extends container_aware_migration
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
		return array('\phpbb\db\migration\data\v310\gold');
	}

	/**
	* Add data to the database.
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
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
			return array(
				array('config.add', array('user_default_options', '230271~001110~1110210~')),
			);
		} else
		{
			$this->container->get('user')->add_lang_ext('forumhulp/userdefault', 'info_acp_userdefault');
			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);
		}
	}
}
