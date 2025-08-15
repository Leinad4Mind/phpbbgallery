<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\types\type;

/**
 * Newsletter class
 */
class newsletter extends \sitesplat\sidebar\types\type\base
{
	/**
	 * Get sidebar block enable
	 *
	 * @return sidebar enabled
	 * @access public
	 */
	public function get_sidebar_enable()
	{
		$manager = $this->container->get('ext.manager');
		return $manager->is_enabled('sitesplat/exportemailsandsubscribers');
	}

	/**
	 * Get sidebar type
	 *
	 * @return string sidebar block type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.newsletter';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_NEWSLETTER');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/newsletter.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$this->template->assign_vars(array(
			'NEWSLETTER' => append_sid($this->root_path . 'index.' . $this->php_ext . '#subscribe')
		));
	}

}
