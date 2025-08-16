/**
* @package cBB Chat
* @style: FLATBOOTS
* @version v1.2.4 17/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

var jchat_style_options = {
	positions: {
		faq: {
			top		: ['h2:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		index: {
			top		: ['.panel-forum:first', 'before'],
			bottom	: ['.panel-stats', 'before']
		},
		mcp: {
			top		: ['h2:first', 'after'],
			bottom	: ['main', 'append']
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
			top		: ['h2:first', 'after'],
			bottom	: ['main', 'append']
		},
		viewforum: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		viewonline: {
			top		: ['.panel-forum:first', 'before'],
			bottom	: ['.panel-forum:not(#chat-body):last', 'after']
		},
		viewtopic: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		chat: ['#chat-container', 'append'],
		undefined: {
			top		: ['main', 'prepend'],
			bottom	: ['main', 'append']
		}
	}
};
