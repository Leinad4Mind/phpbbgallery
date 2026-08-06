<?php

namespace forumhulp\uploadimage\acp;

class uploadimage_info
{
	public function module(): array
	{
		return [
			'filename' => '\\forumhulp\\uploadimage\\acp\\uploadimage_module',
			'title' => 'ACP_IMAGE_TITLE',
			'version' => '3.3.0',
			'modes' => [
				'main' => [
					'title' => 'ACP_IMAGE_TITLE',
					'auth' => 'ext_forumhulp/uploadimage && acl_a_styles',
					'cat' => ['ACP_UPLOAD_IMAGE_TITLE'],
				],
			],
		];
	}
}
