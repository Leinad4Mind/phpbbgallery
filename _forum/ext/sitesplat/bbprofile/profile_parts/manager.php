<?php
/**
*
* BBbbprofile. An extension for the phpBB Forum Software package.
* @copyright (c) 2016, SiteSplat
* @license Proprietary
*
*/

namespace sitesplat\bbprofile\profile_parts;

class manager
{
	protected $user;
	protected $profilefields_manager;
	protected $config_text;
	protected $cpf_part;
	protected $registered_profile_parts;
	protected $profile_parts = [];
	private $total_parts = 0;
	public function __construct(\phpbb\user $user, \phpbb\profilefields\manager $profilefields_manager, \phpbb\config\db_text $config_text, \sitesplat\bbprofile\profile_parts\cpf_part $cpf_part, $profile_parts)
	{
		$this->user = $user;
		$this->profilefields_manager = $profilefields_manager;
		$this->config_text = $config_text;
		$this->cpf_part = $cpf_part;
		$this->registered_profile_parts = $profile_parts;
	}

	public function generate_bbprofile_box()
	{
		if ($this->user->data['is_registered'])
		{
			$this->register_profile_parts($this->registered_profile_parts);
		}

		if (sizeof($this->profile_parts))
		{
			$current_part_key = array_rand($this->profile_parts);
			$current_part = $this->profile_parts[$current_part_key];
	
			return array(
				'percentage'	=> round((($this->total_parts - count($this->profile_parts)) / $this->total_parts) * 100),
				'text'			=> $current_part->appeal_text(),
				'icon'			=> $current_part->appeal_icon(),
				'button'		=> $current_part->appeal_button(),
			);
		}
		else
		{
			return false;
		}
	}

	protected function register_profile_parts($profile_parts)
	{
		if (!empty($profile_parts))
		{
			// parts enabled by admin
			$enabled_parts = json_decode($this->config_text->get('bbprofile_enabled'));

			// predefined first
			foreach ($profile_parts as $part)
			{
				// let's see if admin allowed this part and if part itself is enabled
				if (in_array((new \ReflectionClass($part))->getShortName(), $enabled_parts) && $part->is_enabled())
				{
					$this->total_parts++;
					if (!$part->is_completed())
					{
						$this->profile_parts[] = $part;
					}
				}
			}

			// Custom Profile Fields now
			$profile_fields = $this->profilefields_manager->grab_profile_fields_data($this->user->data['user_id']);
			if (empty($profile_fields) || !array_key_exists($this->user->data['user_id'], $profile_fields))
			{
				$profile_fields = array();
			}
			else
			{
				$profile_fields = $profile_fields[$this->user->data['user_id']];
			}

			foreach ($profile_fields as $field)
			{
				$part = $this->cpf_part->make($field['value'], $field['data']);
				if (in_array('cpf_' . $field['data']['field_id'], $enabled_parts) && $part->is_enabled())
				{
					$this->total_parts++;
					if (!$part->is_completed())
					{
						$this->profile_parts[] = $part;
					}
				}
			}
		}
	}
}
