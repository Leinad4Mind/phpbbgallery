<?php
/**
*
* Gallery Control test
*
* @copyright (c) 2014 Stanislav Atanasov
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/
namespace phpbbgallery\tests\functional;
/**
* @group functional
*/
class acp_test extends phpbbgallery_base
{
	public function test_acp_pages($mode)
	{
		$this->login();
		$this->admin_login();
		
		$this->assertContains('zazazazazaza', $crawler->text());
	}
}