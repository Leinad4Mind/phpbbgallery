<?php
/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbpoints\exception;

final class insufficient_funds extends \RuntimeException
{
	public function __construct(private int $available, private int $required)
	{
		parent::__construct('The BBPoints account does not have enough points.');
	}

	public function get_available(): int
	{
		return $this->available;
	}

	public function get_required(): int
	{
		return $this->required;
	}
}
