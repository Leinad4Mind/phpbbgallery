<?php
/**
*
* @package Search Results
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\searchresults\migrations\v31x;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_schema extends \phpbb\db\migration\migration
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

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'searchresults'	=> array(
					'COLUMNS'		=> array(
						'search_key'		=> array('UINT', null, 'auto_increment'),
						'search_keywords'	=> array('TEXT', ''),
						'search_authors'	=> array('UINT', 0),
						'in_post'			=> array('INT:1', 0),
						'hits'				=> array('UINT', null),
						'first_time'		=> array('TIMESTAMP', 0),
						'last_time'			=> array('TIMESTAMP', 0),
					),
					'PRIMARY_KEY'	=> 'search_key',
				)
			)
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'searchresults'
			)
		);
	}
}
