<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'ALBUM_TYPE_CONTEST'                  => 'Concurso',
	'CONTEST_CREATION'                    => 'Permitir nuevos concursos',
	'CONTEST_CREATION_EXPLAIN'            => 'Permite a los administradores crear nuevos álbumes de concurso. Los concursos existentes permanecen activos y editables cuando esta opción está desactivada.',
	'CONTEST_CREATION_DISABLED'           => 'La creación de nuevos álbumes de concurso está desactivada en la configuración de la Galería.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'Un álbum sin concurso no puede convertirse en un álbum de concurso.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Los álbumes del concurso no pueden convertirse en un álbum sin concurso.',
	'CONTEST_DATE_EXPLAIN'                => 'Por favor, introduzca la fecha en formato AAAA-MM-DD HH:MM',
	'CONTEST_END'                         => 'Final del concurso',
	'CONTEST_END_BEFORE_RATING'           => 'El final del concurso no debe ser antes de la clasificación del concurso.',
	'CONTEST_END_BEFORE_START'            => 'El final del concurso no debe ser antes del inicio del concurso.',
	'CONTEST_END_EXPLAIN'                 => 'Después del final del concurso, los usuarios ya no pueden calificar imágenes.',
	'CONTEST_END_INVALID'                 => 'Final del concurso no válido (%s). Por favor, introduzca la fecha en formato AAAA-MM-DD HH:MM',
	'CONTEST_RATING'                      => 'Inicio de la clasificación',
	'CONTEST_RATING_BEFORE_START'         => 'El inicio del concurso no debe ser antes del inicio del concurso.',
	'CONTEST_RATING_EXPLAIN'              => 'Después del "Rating start", los usuarios ya no pueden cargar imágenes.',
	'CONTEST_RATING_INVALID'              => 'Inicio de la clasificación del concurso no válido (%s). Por favor, introduzca la fecha en formato AAAA-MM-DD HH:MM',
	'CONTEST_SETTINGS'                    => 'Configuración del concurso',
	'CONTEST_START'                       => 'Inicio del concurso',
	'CONTEST_START_EXPLAIN'               => 'Al inicio del concurso, los usuarios pueden subir imágenes.',
	'CONTEST_START_INVALID'               => 'Inicio de concurso no válido (%s). Por favor, introduzca la fecha en formato AAAA-MM-DD HH:MM',
]);
