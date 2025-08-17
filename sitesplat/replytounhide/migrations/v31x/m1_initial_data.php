<?php
/**
 *
 * @package ReplyToUnihde
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 *
 */

namespace sitesplat\replytounhide\migrations\v31x;

/**
 * Initial data changes needed for Extension installation
 */
class m1_initial_data extends \sitesplat\replytounhide\core\bbcodes_migration_base
{
	/**
	 * @inheritdoc
	 */
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	/**
	 * @inheritdoc
	 */
	public function update_data()
	{
		return [
			['custom', [[$this, 'install_replytounhide_bbcodes']]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	protected static $bbcode_data = [
		'hide' => [
			'bbcode_helpline'	=> 'HIDE_HELPLINE',
			'bbcode_match'		=> '[hide]{TEXT}[/hide]',
			'bbcode_tpl'		=> '<!-- BBCODE_HIDE -->{TEXT}<!-- BBCODE_HIDE -->',
            'display_on_posting'=> 0
		]
	];
}
