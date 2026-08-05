<?php
/**
*
* @package Statistics
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\statistics\migrations\v32x;

/**
* Migration stage 3: geoip_lookup toggle
*
* Controls whether each visitor's IP is sent to the ip-api.com third-party service to resolve a
* country flag. Off by default: without it, the country is still guessed from the reverse DNS of
* the visitor's IP, entirely locally.
*/
class m3_geoip_toggle extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencies.
	 *
	 * @return array Array of depending items.
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\forumhulp\statistics\migrations\v32x\m2_permissions');
	}

	/**
	 * Add the column to the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'statistics_config' => array(
					'geoip_lookup' => array('BOOL', 0),
				),
			),
		);
	}

	/**
	 * Drop the column from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'statistics_config' => array(
					'geoip_lookup',
				),
			),
		);
	}
}
