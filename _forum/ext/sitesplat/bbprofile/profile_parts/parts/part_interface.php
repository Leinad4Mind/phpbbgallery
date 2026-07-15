<?php

namespace sitesplat\bbprofile\profile_parts\parts;

interface part_interface
{
	/**
	 * Tells whether this part is enabled.
	 *
	 * @param array $profile_fields User profile fields
	 * @return bool True if this part is enabled
	 */
	public function is_enabled();

	/**
	 * Tells whether this part is already completed.
	 *
	 * @param array $profile_fields User profile fields
	 * @return bool True if this part is already completed
	 */
	public function is_completed();

	/**
	 * Text displayed on BBprofile box that asks user to complete this profile part.
	 *
	 * @return string Text to display
	 */
	public function appeal_text();

	/**
	 * Icon displayed on BBprofile box that asks user to complete this profile part.
	 *
	 * @return string Icon class name
	 */
	public function appeal_icon();

	/**
	 * Button data for BBprofile box. Returned format
	 * 
	 * array(
	 *   'label' => 'Label text',
	 *   'url'   => 'url_when_user_can_complete_this_part',
	 * )
	 *
	 * @return array Button label and URL
	 */
	public function appeal_button();
}