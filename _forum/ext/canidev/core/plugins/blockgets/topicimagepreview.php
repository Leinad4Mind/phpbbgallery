<?php
/**
 * @package cBB Blockgets Plugin
 * @version 1.0.0 23/04/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\core\plugins\blockgets;

class topicimagepreview extends \canidev\core\plugins\base
{
	public $name = 'vse/topicimagepreview';

	/**
	 * {@inheritDoc}
	 */
	public function frontend_js_events()
	{
		return [
			'core.request.onSuccess'	=> "() => {
				if(!window.Opentip)
				{
					return;
				}

				$('[data-ot]').each((i, el) => {
					let item = $(el),
						opentips = item.data('opentips');

					if(opentips == undefined)
					{
						let options = [];
						
						for(optionName in Opentip.styles.standard)
						{
	  						optionValue = Opentip.adapter.data(el, 'ot' + (Opentip.prototype.ucfirst(optionName)));

							if(optionValue === 'yes' || optionValue === 'true' || optionValue === 'on')
							{
								optionValue = true;
							}
							else if (optionValue === 'no' || optionValue === 'false' || optionValue === 'off')
							{
								optionValue = false;
							}
							
							options[optionName] = optionValue;
						}
						
						item.opentip(item.attr('data-ot'), options);
						item.closest('dt').removeAttr('title');
					}
				});
			}"
		];
	}
}