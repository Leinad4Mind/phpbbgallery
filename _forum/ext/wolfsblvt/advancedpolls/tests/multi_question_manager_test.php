<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;

class multi_question_manager_test extends TestCase
{
	public function test_text_only_edits_preserve_votes()
	{
		$manager = $this->manager();
		$existing = array($this->question('Old question', true, array(10, 11)));
		$submitted = array($this->question('New question', true, array(10, 11)));
		$submitted[0]['options'][0]['text'] = 'Renamed option';

		$this->assertFalse($manager->changed($existing, $submitted));
	}

	public function test_page_option_and_required_changes_reset_ballots()
	{
		$manager = $this->manager();
		$existing = array($this->question('Question', false, array(10, 11)));

		$required = array($this->question('Question', true, array(10, 11)));
		$this->assertTrue($manager->changed($existing, $required));

		$new_option = array($this->question('Question', false, array(10, 0)));
		$this->assertTrue($manager->changed($existing, $new_option));

		$this->assertTrue($manager->changed($existing, array()));
	}

	private function manager()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		return new class($db, 'phpbb_') extends \wolfsblvt\advancedpolls\core\multi_question_manager {
			public function changed(array $existing, array $submitted)
			{
				return $this->definition_changed($existing, $submitted);
			}
		};
	}

	private function question($text, $required, array $option_ids)
	{
		$options = array();
		foreach ($option_ids as $index => $option_id)
		{
			$options[] = array('id' => $option_id, 'text' => 'Option ' . ($index + 1));
		}
		return array(
			'id' => 7,
			'text' => $text,
			'required' => $required,
			'options' => $options,
		);
	}
}
