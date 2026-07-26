<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ACCESS_CONTROL_REGISTERED'      => 'Usuários registrados',
	'ACCESS_CONTROL_NOT_FOES'        => 'Usuários registrados, exceto ignorados',
	'ACCESS_CONTROL_FRIENDS'         => 'Apenas amigos',
	'ACCESS_CONTROL_SPECIAL_FRIENDS' => 'Apenas amigos especiais',
	'ALBUMS'                         => 'Álbuns',
	'ALBUM_ACCESS'                   => 'Permitir acesso a',
	'ALBUM_ACCESS_EXPLAIN'           => 'Você pode usar suas %1$slistas de Amigos e Ignorados%2$s para controlar o acesso ao álbum. No entanto, os <strong>moderadores</strong> sempre podem acessá-lo.',
	'ALBUM_DESC'                     => 'Descrição do Álbum',
	'ALBUM_NAME'                     => 'Nome do Álbum',
	'ALBUM_PARENT'                   => 'Álbum Pai',
	'ATTACHED_SUBALBUMS'             => 'Sub-álbuns associados',
	'CREATE_PERSONAL_ALBUM'          => 'Criar álbum pessoal',
	'CREATE_SUBALBUM'                => 'Criar sub-álbum',
	'CREATE_SUBALBUM_EXP'            => 'Você pode anexar um novo sub-álbum à sua galeria pessoal.',
	'CREATED_SUBALBUM'               => 'Sub-álbum criado com sucesso',
	'DELETE_ALBUM'                   => 'Excluir Álbum',
	'DELETE_ALBUM_CONFIRM'           => 'Excluir Álbum, com todos os sub-álbuns e imagens?',
	'DELETED_ALBUMS'                 => 'Álbuns excluídos com sucesso',
	'EDIT'                           => 'Editar',
	'EDIT_ALBUM'                     => 'Editar álbum',
	'EDIT_SUBALBUM'                  => 'Editar Sub-álbum',
	'EDIT_SUBALBUM_EXP'              => 'Você pode editar seus álbuns aqui.',
	'EDITED_SUBALBUM'                => 'Álbum editado com sucesso',
	'GOTO'                           => 'Ir Para',
	'MANAGE_SUBALBUMS'               => 'Gerenciar seus subálbuns',
	'MISSING_ALBUM_NAME'             => 'Informe um nome para o álbum',
	'NEED_INITIALISE'                => 'Você ainda não tem um álbum pessoal.',
	'NO_ALBUM_STEALING'              => 'Você não tem autorização para gerenciar o álbum de outro usuário.',
	'NO_MORE_SUBALBUMS_ALLOWED'      => 'Você atingiu o número máximo de subálbuns',
	'NO_PARENT_ALBUM'                => '«-- sem álbum pai',
	'NO_PERSALBUM_ALLOWED'           => 'Você não tem permissão para criar um álbum pessoal',
	'NO_PERSONAL_ALBUM'              => 'Você ainda não tem um álbum pessoal e pode criá-lo aqui. Somente o proprietário pode enviar imagens para álbuns pessoais.',
	'NO_SUBALBUMS'                   => 'Nenhum Álbum associado',
	'NO_SUBSCRIPTIONS'               => 'Você não acompanha nenhuma imagem.',
	'NO_SUBSCRIPTIONS_ALBUM'         => 'Você não acompanha nenhum álbum.',
	'PARSE_BBCODE'                   => 'Processar BBCode',
	'PARSE_SMILIES'                  => 'Processar smilies',
	'PARSE_URLS'                     => 'Processar links',
	'PERSONAL_ALBUM'                 => 'Álbum pessoal',
	'UNSUBSCRIBE'                    => 'deixar de acompanhar',
	'USER_ALLOW_COMMENTS'            => 'Permitir que outros usuários comentem suas imagens',
	'YOUR_SUBSCRIPTIONS'             => 'Aqui você vê os álbuns e imagens que acompanha e para os quais recebe notificações.',
	'WATCH_CHANGED'                  => 'Configurações salvas',
	'WATCH_COM'                      => 'Acompanhar por padrão as imagens que você comentar',
	'WATCH_NOTE'                     => 'Esta opção apenas afeta novas imagens.',
	'WATCH_OWN'                      => 'Acompanhar por padrão suas próprias imagens',
	'RRC_ZEBRA'                      => 'Ocultar de ignorados no RRC',
	'RRC_ZEBRA_EXPLAIN'              => 'Oculta imagens de álbuns dos ignorados na parte de Recentes e Aleatórios. Atenção: Não oculta imagens em álbuns públicos.'
]);
