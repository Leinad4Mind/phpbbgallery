<?php
/**
 * Contract implemented by content types that use the BBTags catalogue.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\provider;

interface provider_interface
{
	/**
	 * Stable storage key, using lower-case ASCII letters, digits and underscores.
	 */
	public function get_name(): string;

	/**
	 * Language key used to identify this content provider in moderation screens.
	 */
	public function get_language_key(): string;

	/**
	 * Confirm that an item exists inside the provider-defined scope.
	 */
	public function validate_subject(int $scope_id, int $item_id): bool;

	/**
	 * Attach an approved catalogue tag to the provider item.
	 */
	public function apply_approved_tag(int $scope_id, int $item_id, int $tag_id): bool;

	/**
	 * Return an internal moderation link, or an empty string when unavailable.
	 */
	public function get_item_url(int $scope_id, int $item_id): string;
}
