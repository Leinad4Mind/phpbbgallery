<?php

namespace forumhulp\uploadimage\acp;

use phpbb\request\request_interface;

class uploadimage_module
{
	private const FORM_KEY = 'acp_uploadimage';

	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $auth, $phpbb_container, $request, $user;

		$user->add_lang_ext('forumhulp/uploadimage', 'info_acp_uploadimage');
		if (!$auth->acl_get('a_styles'))
		{
			trigger_error($user->lang['NO_AUTH_OPERATION'], E_USER_WARNING);
		}

		$controller = $phpbb_container->get('forumhulp.uploadimage.admin.controller');
		$controller->set_page_url($this->u_action);
		$this->tpl_name = 'acp_uploadimage';
		$this->page_title = 'ACP_UPLOAD_IMAGE_TITLE';
		$action = $request->variable('action', '');

		if ($action === 'details')
		{
			$this->tpl_name = 'acp_ext_details';
			$phpbb_container->get('forumhulp.helper')->detail('forumhulp/uploadimage');
			return;
		}

		$rename_folder = $request->is_set_post('imgfolder');
		$delete_file = $request->is_set_post('delete_file');
		$add_file = $request->is_set_post('add_file');
		if (($rename_folder || $delete_file || $add_file) && !check_form_key(self::FORM_KEY))
		{
			trigger_error($user->lang['FORM_INVALID'], E_USER_WARNING);
		}

		if ($rename_folder)
		{
			$controller->rename_folder();
			redirect($this->u_action);
		}

		if ($delete_file)
		{
			$indexes = $request->variable(
				'delete_file',
				[0 => 0],
				false,
				request_interface::POST
			);
			$files = $request->variable(
				'attachment_data',
				[0 => ['' => '']],
				true,
				request_interface::POST
			);
			$files = $controller->sanitise_attachment_data($files);
			$index = array_key_first($indexes);
			if ($index === null || !isset($files[$index]['real_filename']))
			{
				trigger_error($user->lang['FORM_INVALID'], E_USER_WARNING);
			}

			$controller->delete_image((string) $files[$index]['real_filename']);
			unset($files[$index]);
			if ($request->is_ajax())
			{
				$response = new \phpbb\json_response();
				$response->send(array_values($files));
			}
			redirect($this->u_action);
		}

		if ($add_file)
		{
			$controller->add_image();
			redirect($this->u_action);
		}

		if ($action === 'delete')
		{
			$image_id = $request->variable('image_id', '');
			if (confirm_box(true))
			{
				$controller->delete_image($image_id);
				redirect($this->u_action);
			}

			confirm_box(false, $user->lang('ACP_IMAGE_DELETE_CONFIRM'), build_hidden_fields([
				'i' => $id,
				'mode' => $mode,
				'action' => 'delete',
				'image_id' => $image_id,
			]));
		}

		$controller->display_images();
	}
}
