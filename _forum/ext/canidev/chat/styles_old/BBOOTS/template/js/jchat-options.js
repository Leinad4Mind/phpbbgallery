/*
* @name jchat-options.js
* @package cBB Chat
* @style: BBOOTS
* @version v1.2.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

var jchat_style_options = {
	positions: {
		chat: ['main', 'prepend'],

		faq: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		index: {
			top		: ['.panel:first', 'before'],
			bottom	: ['.panel:not(#chat-body):last', 'after']
		},
		mcp: {
			top		: ['h3:first', 'after'],
			bottom	: ['footer', 'before']
		},
		memberlist: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		search: {
			top		: ['h3:first', 'after'],
			bottom	: ['main', 'append']
		},
		ucp: {
			top		: ['h3:first', 'after'],
			bottom	: ['footer', 'before']
		},
		viewforum: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .side-segment:last', 'before']
		},
		viewonline: {
			top		: ['.panel:first', 'before'],
			bottom	: ['footer', 'before']
		},
		viewtopic: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .side-segment:last', 'before']
		},
		chat: ['#chat-container', 'append'],
		undefined: {
			top		: ['main', 'prepend'],
			bottom	: ['footer', 'before']
		}
	}
};
