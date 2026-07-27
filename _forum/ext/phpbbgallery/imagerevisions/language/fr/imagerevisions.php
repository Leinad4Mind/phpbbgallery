<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'REPLACE_IMAGE'                => 'Remplacer le fichier image',
	'REPLACE_IMAGE_EXPLAIN'        => 'Sélectionnez un nouveau fichier. L’identifiant, la description, les commentaires, les évaluations et le nombre de vues sont conservés.',
	'IMAGE_REVISIONS'              => 'Fichiers image précédents',
	'IMAGE_REVISIONS_EXPLAIN'      => 'Les fichiers conservés peuvent être prévisualisés et restaurés. Lors d’une restauration, le fichier actuel est conservé dans l’historique.',
	'RESTORE_REVISION'             => 'Restaurer cette version',
	'IMAGE_REPLACE_FAILED'         => 'Le fichier de remplacement n’a pas pu être appliqué en toute sécurité.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'Cette révision de l’image n’est plus disponible.',
	'IMAGE_REVISION_RESTORED'      => 'La révision de l’image a été restaurée avec succès.',
]);
