/**
* @package cBB Chat
* @style: All
* @version v1.2.4 17/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

var jchat_style_options = {
	positions: {
		faq: {
			top		: ['#faqlinks', 'before'],
			bottom	: ['.panel:last', 'after']
		},
		index: {
			top		: ['.action-bar:first', 'after'],
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
