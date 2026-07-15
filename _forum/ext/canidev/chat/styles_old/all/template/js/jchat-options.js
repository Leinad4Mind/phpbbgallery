/*
* @package cBB Chat
* @style: proSilver
* @version v1.2.0 02/03/2019 $
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

var jchat_style_options = {
	positions: {
		faq: {
			top		: ['#faqlinks', 'before'],
			bottom	: ['.panel:last', 'after']
		},
		index: {
			top		: ['.forabg:has(.forumtitle):first', 'before'],
			bottom	: ['.forabg:has(.forumtitle):last', 'after']
		},
		mcp: {
			top		: ['#tabs', 'before'],
			bottom	: ['#page-body', 'append']
		},
		memberlist: {
			top		: ['h2:first', 'after'],
			bottom	: ['#jumpbox', 'before']
		},
		search: {
			top		: ['h2:first', 'after'],
			bottom	: ['#page-body', 'append']
		},
		ucp: {
			top		: ['#tabs', 'before'],
			bottom	: ['#page-body', 'append']
		},
		viewforum: {
			top		: ['.action-bar.bar-top', 'before'],
			bottom	: ['.action-bar.bar-bottom', 'after']
		},
		viewonline: {
			top		: ['.action-bar.bar-top', 'before'],
			bottom	: ['.action-bar.bar-bottom', 'after']
		},
		viewtopic: {
			top		: ['.action-bar.bar-top', 'before'],
			bottom	: ['.action-bar.bar-bottom', 'after']
		},
		chat: ['#chat-container', 'append'],
		undefined: {
			top		: ['#page-body', 'prepend'],
			bottom	: ['#page-body', 'append']
		}
	}
};
