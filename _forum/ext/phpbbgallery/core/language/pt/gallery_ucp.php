<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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

$lang = array_merge($lang, [
	'ACCESS_CONTROL_ALL'             => 'Todos',
	'ACCESS_CONTROL_REGISTERED'      => 'Utilizadores registados',
	'ACCESS_CONTROL_NOT_FOES'        => 'Utilizadores registados, exceto ignorados',
	'ACCESS_CONTROL_FRIENDS'         => 'Apenas amigos',
	'ACCESS_CONTROL_SPECIAL_FRIENDS' => 'Apenas amigos especiais',
	'ALBUMS'                         => 'Álbuns',
	'ALBUM_ACCESS'                   => 'Permitir acesso a',
	'ALBUM_ACCESS_EXPLAIN'           => 'Podes usar as tuas %1$slistas de Amigos e Ignorados%2$s para controlar o acesso ao álbum. No entanto, <strong>moderadores</strong> podem <strong>sempre</strong> aceder.',
	'ALBUM_DESC'                     => 'Descrição do Álbum',
	'ALBUM_NAME'                     => 'Nome do Álbum',
	'ALBUM_PARENT'                   => 'Álbum Pai',
	'ATTACHED_SUBALBUMS'             => 'Sub-álbuns associados',
	'CREATE_PERSONAL_ALBUM'          => 'Criar álbum pessoal',
	'CREATE_SUBALBUM'                => 'Criar sub-álbum',
	'CREATE_SUBALBUM_EXP'            => 'Podes anexar um novo sub-álbum à tua galeria pessoal.',
	'CREATED_SUBALBUM'               => 'Sub-álbum criado com sucesso',
	'DELETE_ALBUM'                   => 'Eliminar Álbum',
	'DELETE_ALBUM_CONFIRM'           => 'Eliminar Álbum, com todos os sub-álbuns e imagens?',
	'DELETED_ALBUMS'                 => 'Álbuns eliminados com sucesso',
	'EDIT'                           => 'Editar',
	'EDIT_ALBUM'                     => 'Editar álbum',
	'EDIT_SUBALBUM'                  => 'Editar Sub-álbum',
	'EDIT_SUBALBUM_EXP'              => 'Podes editar os teus álbuns aqui.',
	'EDITED_SUBALBUM'                => 'Álbum editado com sucesso',
	'GOTO'                           => 'Ir Para',
	'MANAGE_SUBALBUMS'               => 'Gerir os teus sub-álbuns',
	'MISSING_ALBUM_NAME'             => 'Por favor insere um nome para o álbum',
	'NEED_INITIALISE'                => 'Ainda não tens um álbum pessoal.',
	'NO_ALBUM_STEALING'              => 'Não estás autorizado a gerir o Álbum de outros utilizadores.',
	'NO_MORE_SUBALBUMS_ALLOWED'      => 'Atingiste o número máximo de sub-álbuns',
	'NO_PARENT_ALBUM'                => '«-- sem álbum pai',
	'NO_PERSALBUM_ALLOWED'           => 'Não tens permissão para criar o teu álbum pessoal',
	'NO_PERSONAL_ALBUM'              => 'Ainda não tens álbum pessoal. Podes criá-lo aqui. Nos álbuns pessoais apenas o dono pode carregar imagens.',
	'NO_SUBALBUMS'                   => 'Nenhum Álbum associado',
	'NO_SUBSCRIPTIONS'               => 'Não subscreveste nenhuma imagem.',
	'NO_SUBSCRIPTIONS_ALBUM'         => 'Não estás subscrito a um álbum.',
	'PARSE_BBCODE'                   => 'Processar BBCode',
	'PARSE_SMILIES'                  => 'Processar smilies',
	'PARSE_URLS'                     => 'Processar links',
	'PERSONAL_ALBUM'                 => 'Álbum pessoal',
	'UNSUBSCRIBE'                    => 'parar de observar',
	'USER_ALLOW_COMMENTS'            => 'Permitir que os utilizadores comentem as tuas imagens',
	'YOUR_SUBSCRIPTIONS'             => 'Aqui vês os álbuns e imagens nos quais recebes notificações.',
	'WATCH_CHANGED'                  => 'Configurações guardadas',
	'WATCH_COM'                      => 'Subscrever imagens comentadas por padrão',
	'WATCH_NOTE'                     => 'Esta opção apenas afeta novas imagens.',
	'WATCH_OWN'                      => 'Subscrever as próprias imagens por padrão',
	'RRC_ZEBRA'                      => 'Ocultar imagens de ignorados em Recentes/Aleatórias/Comentários',
	'RRC_ZEBRA_EXPLAIN'              => 'Oculta as imagens de álbuns de utilizadores ignorados nas seções de Imagens Recentes, Aleatórias e Comentários Recentes da página principal da galeria.<br /><strong>Atenção:</strong> Não oculta imagens em álbuns públicos/partilhados, mesmo que pertençam a alguém que ignoras.'
]);
