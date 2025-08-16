<?php
/**
*
* HTML email extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace forumhulp\htmlemail\migrations\v31x;

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
		return array('\phpbb\db\migration\data\v310\gold');
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
				0 => '/includes/functions_messenger.' . $this->php_ext,
				),
			'searches' => array(
				0 => array(
					0 => '	var $use_queue = true;',
					1 => '		$this->subject = \'\';',
					2 => '		$this->mail_priority = $priority;',
					3 => '$headers[] = \'Content-Type: text/plain; charset=UTF-8\';',
					4 => '\'EMAIL_SIG\'	=> str_replace(\'<br />\', "\n", "-- \n" . htmlspecialchars_decode($config[\'board_email_sig\'])),',
					5 => '\'SITENAME\'	=> htmlspecialchars_decode($config[\'sitename\']),',					)
				),
			'replaces' => array(
				0 => array(
					0 => '	var $use_queue = true;
	var $use_html = false;',
					1 => '		$this->subject = \'\';
		$this->use_html = false;',
					2 => '		$this->mail_priority = $priority;
	}
	
	/**
	* Set the email html
	*/
	function set_mail_html($html = false)
	{
		$this->use_html = $html;',
					3 => '$headers[] = \'Content-Type: \' . (($this->use_html) ? \'text/html;\' : \'text/plain;\')  . \' charset=UTF-8\';',
					4 => '\'EMAIL_SIG\'	=> "-- \n" . $config[\'board_email_sig\'],',
					5 => '\'SITENAME\'	=> $config[\'sitename\'],',
					)
				)
			);
		return $replacements;
	}
}
