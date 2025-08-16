/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* Show/hide notes text
*/
function showHideNote(note)
{
	$('#note_' + note).slideToggle();
}
