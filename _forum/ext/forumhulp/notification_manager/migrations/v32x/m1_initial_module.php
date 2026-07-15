<?php
/**
*
* Notification_manager for the phpBB Forum Software package.
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\notification_manager\migrations\v32x;

class m1_initial_module extends \phpbb\db\migration\migration
{
	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('module.add', array(
				'ucp', 'UCP_MAIN', array(
					'module_basename'	=> '\forumhulp\notification_manager\ucp\noties_module',
					'modes'				=> array('noties'),
				),
			)),
		);
	}
}
