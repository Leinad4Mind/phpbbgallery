<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */


namespace chris1278\cptfork\migrations;

class v1_0_2_permissions extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	public function update_data()
	{
		return [
			['permission.add', ['m_cf_chgposttime', true]],
			['permission.add', ['m_cf_chgposttime', false, 'm_chgposter']],
		];
	}
}
