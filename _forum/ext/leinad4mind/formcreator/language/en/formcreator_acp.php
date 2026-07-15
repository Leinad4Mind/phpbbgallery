<?php
/**
*
* @package phpBB Extension - Form Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'MODE'						=> 'Mode',
	'ELEMENTS'					=> 'Elements',
	'FORM_NAME'					=> 'Forum Name',
	'FORUM_ID'					=> 'Forum ID',
	'ACP_FORM_CURRENT'		 	=> 'Update Current Form',
	'ACP_FORM_CREATOR'			=> 'Form Creator',
	'ACP_FORM_CREATOR_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
	'ACP_FORM_EXT_NOTE'			=> '<br><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',

	'ACP_FORM_CREATOR_FAQ' => '<strong>How to begin?</strong><br>
									&nbsp; &bull; You just need to first select the forum where you will want to create the form.<br>
									<br>
									<strong>How can I do that?</strong><br>
									&nbsp; &bull; Just select a new forum from the <strong><i>Current Forum</i></strong> dropdown box...<br>
									<br>
									<strong>And now what?</strong><br>
									&nbsp; &bull; Next step would be to add new form elements<br>
									<br>
									<strong>How do I add a new form element?</strong><br> 
									&nbsp; &bull; Use <strong><i>Add a new form element</i></strong> at the bottom.<br>
									<br>
									<strong>After adding all the form elements I want, does it save automatically?</strong><br>
									&nbsp; &bull; Yes, when you add the form element it saves automatically on the current form, but if you make changes on the form elements on the <strong><i>Update Current Form</i></strong> then you\'ll need to click update so it can save the changes!<br>
									<br>
									<strong>Some fields don\'t make sense to my element type, will something bad happen if I fill those fields?</strong><br>
									&nbsp; &bull; Nothing bad will happen. You\'ll just put trash on the database. All that info will be discarded. That\'s why it\'s recommended to add an empty new form element and just then update it.<br>
									<br>
									<strong>How do I delete a form?</strong><br>
									&nbsp; &bull; Simply delete all form elements...<br>
									<br>
									<br>
									<strong>What is Name Before/After?</strong><br>
									&nbsp; &bull; Those fields accept BBCode, and whatever you write there will appear before and after the Entry Name on the final post, so you can customize the Entry Name.<br>
									<br>
									<strong>Can I see an example for Name Before/After fields?</strong><br>
									&nbsp; &bull; Sure. You can add <i>[b]</i> on the Before field and <i>[/b]</i> on the After field and if the Entry Name is <i>Title</i> then the post will be parsed into: <i>[b]Title[/b]</i><br>
									<br>
									<strong>What is Entry Name?</strong><br>
									&nbsp; &bull; Really? This is the question on the form field, the text before the input field, and that text may or may not be imported to the final post.<br>
									<br>
									<strong>What is Entry Explain?</strong><br>
									&nbsp; &bull; This is an optional field, if you fill it, it will appear below the Entry Name on the form, so you can insert a little explanation text. It supports BBCode and line break too.<br>
									<br>
									<strong>What is Hint?</strong><br>
									&nbsp; &bull; Hint is optional and is what appears inside the input fields, so you can provide an idea of what should be filled on the input box. Its good idea to use in some cases to avoid abusing the Entry Explain. For selectbox the hint will be the default first element.<br>
									<br>
									<strong>What is Options?</strong><br>
									&nbsp; &bull; It only works on some element types: selectbox, radiobuttons, checkbox and separator. With that said, it\'s a field where you\'ll insert the options for those element types.<br>
									<br>
									<strong>Can I see an example for Options fields? I am still confuse.</strong><br>
									&nbsp; &bull; Sure. You can add for example genres as: <i>Action, Adventure, Horror, Romance, Sci-Fi</i>, and the user will be able to just select the options, instead of writing.<br>
									<br>
									<strong>That makes sense for selectbox, radiobuttons and checkbox, but separator? What is it? </strong><br>
									&nbsp; &bull; Yes, that one is an exception. That field is only for form layout customization. A way to customize how the form itself will look like.<br>
									<br>
									<strong>Great! And do I always need to use a Comma to separate the words?</strong><br>
									&nbsp; &bull; You can use a comma or a line break and there is a hidden feature too. If you use "Administrator => Adm, Moderator => Mod, User => U", where the former one will appear on the form and the latter one on the post.<br>
									<br>
									<strong>What is Min/Max?</strong><br>
									&nbsp; &bull; This only works on Checkboxes since it\'s the only element type where you can select multiple items and with those fields you can require the user to choose between a min and max values. If you put Min: 1 and Max: 3, the user will need to choose at least one and less than 3 options.<br>
									<br>
									<strong>What is Value Before/After?</strong><br>
									&nbsp; &bull; It\'s similar to the <i>Name Before/After</i>. It accepts BBCode as well and will appear before and after the value that the user inserted.<br>
									<br>
									<strong>Can I still see an example for Value Before/After fields?</strong><br>
									&nbsp; &bull; Why not? You can add <i>[color=#ff0000]</i> on the Before field and <i>[/color]</i> on the After field and lets say the Entry Name is <i>Movie Title</i>. Then the user inserts on the form something as <i>Titanic</i> and when he submits, the post will be parsed into: <i>[color=#ff0000]Titanic[/color]</i><br>
									<br>
									<strong>Is there anything else that I should know?</strong><br>
									&nbsp; &bull; I\'m glad you asked! Some fields as Entry Name, Explain, Hint and Options are translatable. This means you can insert language variables {L_LANGUAGE_VARIABLE} so the form will be multilingual.<br>
									<br>
									<strong>WOW! Awesome! But where can I add the Language Variables?</strong><br>
									&nbsp; &bull; Just edit the root/ext/leinad4mind/formcreator/language/COUNTRY/common.php file and add new variables, so you can use at ACP afterwards.<br>
									<br>
									<strong>&#8730;</strong> The checkmark character indicates the item is mandatory and cannot be empty, so it will force the user to fill it.<br>
									<strong><i class="fa fa-eye" aria-hidden="true"></i></strong> The eye character indicates the entry name of that item will not be imported to the post submitted.<br>',

	'CURRENT_FORUM'			 	=> 'Current Forum',
	'FORM_ADD_ITEM'				=> 'Add a new form element',
	'FORM_CHECKBOX'				=> 'Check Box',
	'FORM_DETAILS'			 	=> 'All forms use a generic template file: styles/YOUR_STYLE/template/forms/form_creator.html',
	'FORM_ELEMENT_TYPE'					=> 'Element type',
	'FORM_ELEMENT_HINT'					=> 'Hint',
	'FORM_ELEMENT_OPTIONS_SEPARATOR'	=> 'Options separator',
	'FORM_ELEMENT_NAME_VISIBLE'			=> 'Display/hide the element name on the final form.',
	'FORM_ELEMENT_NAME'					=> 'Entry Name',
	'FORM_ELEMENT_EXPLAIN'				=> 'Entry Explain',
	'FORM_ELEMENT_NAME_EXPLAIN'			=> 'Entry Name/Explain',
	'FORM_ELEMENT_OPTIONS'				=> 'Options',
	'FORM_ELEMENT_MIN_MAX'				=> 'Min/Max',
	'FORM_ELEMENT_MIN'					=> 'Min',
	'FORM_ELEMENT_MAX'					=> 'Max',
	'FORM_ELEMENT_NAME_BEFORE_AFTER'	=> 'Name before/after',
	'FORM_ELEMENT_VALUE_BEFORE_AFTER'	=> 'Value before/after',
	'FORM_EMAILBOX'				=> 'Email',
	'FORM_INPUTBOX'				=> 'Text',
	'FORM_CREATOR_ACP_RETURN'	=> 'Back to manage forms',
	'FORM_MANAGE'				=> 'Manage this form',
	'FORM_MANAGE_EXPLAIN'		=> 'Here you can modify all of the current form elements, simply edit fields and press the <strong>Update</strong> button...',

	'FORM_NEW_ITEM_EXPLAIN'		=> '<pre style="font-size:11px; line-height: 100%;"><strong><u>Form Elements Supported</u></strong><br>
									<strong>Inputbox:</strong>		Up to 255 characters<br>
									<strong>Textbox:</strong>	 	Multiple lines of text arranged as 3 rows by 76 columns.<br>
									<strong>Checkbox:</strong>		One or more options can be selected.<br>
									<strong>Radiobutton:</strong> 		Only one option can be selected.<br>
									<strong>Selectbox:</strong>		One option from a dropdown list.<br>
									<strong>Email:</strong>			Valid email address.<br>
									<strong>Password:</strong>		For test purposes only...<br>
									<strong>URL:</strong>			A valid URL must be entered.<br>
									<strong>Attachment:</strong>		Add a file to the attachment system.<br>
									<strong>Number:</strong>			Only numbers 0-9 are allowed.<br>
									<strong>Date:</strong>			Opens a date picker.<br>
									<strong>Time:</strong>			Opens a time picker.<br>
									<strong>Separator:</strong>			Only for form layout customization.<br>
									<br></pre>',

	'FORM_NO_FORM'			 	=> 'There are no forms assigned to: <strong>%s</strong>...<br>To add a new form to this forum, simply add a form element below...',
	'FORM_RADIOBOX'				=> 'Radio Buttons',
	'FORM_PASSWORDBOX'			=> 'Password',
	'FORM_SELECTBOX'			=> 'Select Box',
	'FORM_TXTBOX'				=> 'Text Box',
	'FORM_URLBOX'				=> 'URL',
	'FORM_ATTACH'				=> 'Attachment',
	'FORM_NUMBER'				=> 'Number',
	'FORM_DATE'					=> 'Date',
	'FORM_TIME'					=> 'Time',
	'FORM_SEPARATOR'			=> 'Separator',
	'HIDE_FORM_INFO'			=> 'Hide info',
	'HIDE_PREVIEW'			 	=> 'Hide Preview',
	'HIDE_COPY'				 	=> 'Hide copy form',
	'HOW_TO'					=> '<strong>Additional Help...</strong>',
	'HOW_TO_MORE'				=> 'More info...',
	'HOW_TO_HIDE'				=> '<strong>Hide</strong>',
	'NDX'						=> 'NDX',
	'NDX_ORDER'					=> 'Index order (the order in which items appear on the form)',
	'FORMS_MOD_SAMPLE'		 	=> 'Rendering the current form to assist visualization only... not a working form.',
	'SHOW_FORM_INFO'			=> 'More info on Element types',
	'SHOW_PREVIEW'			 	=> 'Preview the form',
	'SHOW_COPY'					=> 'Copy form',
	'COPY_FORM'					=> 'Copy form to selected forums',
	'COPY_FORM_EXPLAIN'			=> 'This will delete all existing form elements in the selected destination forums!',
	'COPY_FORM_SUCCESS'			=> 'The form elements have been copied to all selected forums.',

	'SHOW_FORM_DEFAULT'			=> 'Show form by default',
	'FORCE_FORM'				=> 'Force form',
]);
