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
use wolfsblvt\advancedpolls\core\multi_question_payload;

class multi_question_payload_test extends TestCase
{
	public function test_empty_payload_contains_no_questions()
	{
		$this->assertSame(array('questions' => array(), 'error' => false), multi_question_payload::decode(''));
	}

	public function test_questions_only_keep_page_specific_fields()
	{
		$result = multi_question_payload::decode(json_encode(array(array(
			'id' => 9,
			'text' => 'Second question',
			'required' => true,
			'type' => 2,
			'max_value' => 999,
			'options' => array(
				array('id' => 20, 'text' => ' Alpha '),
				array('id' => 21, 'text' => 'Beta'),
				array('id' => 22, 'text' => 'Gamma'),
			),
		))), 3);

		$this->assertFalse($result['error']);
		$this->assertSame(2, $result['questions'][0]['order']);
		$this->assertSame('Second question', $result['questions'][0]['text']);
		$this->assertTrue($result['questions'][0]['required']);
		$this->assertSame(array('id' => 20, 'text' => 'Alpha'), $result['questions'][0]['options'][0]);
		$this->assertArrayNotHasKey('type', $result['questions'][0]);
		$this->assertArrayNotHasKey('max_value', $result['questions'][0]);
	}

	public function test_global_selection_limit_requires_enough_options_per_page()
	{
		$json = json_encode(array(array(
			'text' => 'Question',
			'options' => array('One', 'Two'),
		)));
		$this->assertSame('AP_MULTI_CONTENT_INVALID', multi_question_payload::decode($json, 3)['error']);
	}

	public function test_invalid_json_and_question_limit_are_rejected()
	{
		$this->assertSame('AP_MULTI_INVALID', multi_question_payload::decode('{')['error']);
		$questions = array_fill(0, multi_question_payload::MAX_QUESTIONS + 1, array());
		$this->assertSame('AP_MULTI_TOO_MANY', multi_question_payload::decode(json_encode($questions))['error']);
		$this->assertSame('AP_MULTI_INVALID', multi_question_payload::decode('{"named":{"text":"Question","options":["A","B"]}}')['error']);
	}

	public function test_wrong_json_types_and_oversized_payload_are_rejected()
	{
		$result = multi_question_payload::decode(json_encode(array(array(
			'id' => '7',
			'text' => array('not', 'text'),
			'required' => 1,
			'options' => array(array('wrong' => 'shape'), 4),
		))));
		$this->assertSame('AP_MULTI_INVALID', $result['error']);

		$result = multi_question_payload::decode(str_repeat('x', multi_question_payload::MAX_PAYLOAD_BYTES + 1));
		$this->assertSame('AP_MULTI_TOO_MANY', $result['error']);
	}
}
