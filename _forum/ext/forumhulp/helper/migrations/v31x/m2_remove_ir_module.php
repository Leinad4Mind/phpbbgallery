<?php
/**
*
* This file is part of the ForumHulp extension package.
*
* @copyright (c) 2015 John Peskens (http://ForumHulp.com)
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace forumhulp\helper\migrations\v31x;

use phpbb\db\migration\container_aware_migration;

/**
* Migration stage 2: remove the UCP image resize module.
*
* Its handler (ucp/ir_module.php) read "app" and "file" straight off the request
* and passed them unvalidated to file_get_contents(), unlink() and a language file
* include - arbitrary file read/delete plus XSS for any logged in user. It only
* ever failed to run because its target route never existed; removed rather than
* patched, since nothing in this extension actually needs it.
*/
class m2_remove_ir_module extends container_aware_migration
{
	/**
	 * Get the migration dependencies.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return array('\forumhulp\helper\migrations\v31x\m1_initial_module');
	}

	/**
	 * Run migration if the module is already gone.
	 *
	 * @return bool Is effectively installed?
	 */
	public function effectively_installed()
	{
		return !$this->get_own_module_id();
	}

	/**
	 * Update data of the database.
	 *
	 * @return array Array of elements to update.
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'remove_ir_module_if_ours'))),
		);
	}

	/**
	 * Deliberately not reversible: the removed handler is a security fix, not a
	 * feature toggle, and its class file no longer exists on disk to re-register.
	 *
	 * @return array
	 * @access public
	 */
	public function revert_data()
	{
		return array();
	}

	/**
	 * Find the module_id of the UCP_IR module, but only if it's this extension's
	 * own copy - never sitesplat/BBCore's, which is a different, still-functional
	 * module that happens to share the same langname.
	 *
	 * @return int Module id, or 0 if not found.
	 * @access private
	 */
	private function get_own_module_id()
	{
		$sql = 'SELECT module_id
			FROM ' . MODULES_TABLE . "
			WHERE module_class = 'ucp'
				AND module_langname = 'UCP_IR'
				AND module_basename = '\\forumhulp\\helper\\ucp\\ir_module'";
		$result = $this->db->sql_query($sql);
		$module_id = (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id;
	}

	/**
	 * Remove the module if it's this extension's own copy, and hand it back to
	 * sitesplat/BBCore if that extension is active (mirrors the logic already in
	 * m1_initial_module::revert_data() for the same handoff in the other direction).
	 *
	 * @return void
	 * @access public
	 */
	public function remove_ir_module_if_ours()
	{
		$module_id = $this->get_own_module_id();

		if (!$module_id)
		{
			return;
		}

		$module_tool = $this->container->get('migrator.tool.module');
		$module_tool->remove('ucp', false, $module_id);

		if ($this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$module_tool->add('ucp', 'UCP_PROFILE', array(
				'module_basename'	=> '\sitesplat\BBCore\ucp\ir_module',
				'modes'				=> array('ir'),
			));
		}
	}
}
