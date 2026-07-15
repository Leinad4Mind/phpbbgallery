/**
* @package cBB Chat
* @style: BBOOTS
* @version v1.2.4 17/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

var jchat_style_options = {
	positions: {
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
