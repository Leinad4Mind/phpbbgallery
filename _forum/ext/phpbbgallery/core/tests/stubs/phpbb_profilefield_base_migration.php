<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\db\migration;

if (!class_exists('phpbb\db\migration\profilefield_base_migration'))
{
	abstract class profilefield_base_migration extends migration
	{
	}
}
