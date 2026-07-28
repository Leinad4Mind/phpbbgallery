<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSIMAGES_DEPENDENCIES_MISSING' => 'As seguintes extensões obrigatórias não estão disponíveis ou estão desativadas: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'A extensão foi ativada com sucesso.',
	'ACP_BBTAGSIMAGES_POLICIES' => 'Políticas de tags da Galeria',
	'ACP_BBTAGSIMAGES_POLICIES_EXPLAIN' => 'Configura onde as tags do catálogo partilhado do BBTags estão disponíveis na Galeria. A moderação de propostas de tags permanece no Painel de Controlo do Moderador.',
	'ACP_BBTAGSIMAGES_TAG' => 'Catálogo de tags',
	'ACP_BBTAGSIMAGES_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSIMAGES_NO_TAGS' => 'O catálogo partilhado não contém tags aprovadas.',
	'ACP_BBTAGSIMAGES_PROVIDER_POLICY' => 'Disponibilidade na Galeria',
	'ACP_BBTAGSIMAGES_ENABLED' => 'Disponível na Galeria',
	'ACP_BBTAGSIMAGES_ENABLED_EXPLAIN' => 'Desativar uma tag oculta-a dos campos e pesquisas da Galeria sem a remover do BBTags ou do fórum.',
	'ACP_BBTAGSIMAGES_MODE' => 'Disponibilidade predefinida',
	'ACP_BBTAGSIMAGES_MODE_EXPLAIN' => 'A regra explícita do álbum mais próximo prevalece sobre esta predefinição e sobre as regras herdadas.',
	'ACP_BBTAGSIMAGES_MODE_GLOBAL' => 'Disponível exceto quando negada',
	'ACP_BBTAGSIMAGES_MODE_RESTRICTED' => 'Indisponível exceto quando permitida',
	'ACP_BBTAGSIMAGES_ALBUM_RULES' => 'Regras por álbum',
	'ACP_BBTAGSIMAGES_ALBUM_RULES_EXPLAIN' => 'Herdar utiliza a regra do álbum ascendente mais próximo e, depois, a disponibilidade predefinida.',
	'ACP_BBTAGSIMAGES_ALBUM' => 'Álbum',
	'ACP_BBTAGSIMAGES_RULE' => 'Regra',
	'ACP_BBTAGSIMAGES_RULE_INHERIT' => 'Herdar',
	'ACP_BBTAGSIMAGES_RULE_ALLOW' => 'Permitir',
	'ACP_BBTAGSIMAGES_RULE_DENY' => 'Negar',
	'ACP_BBTAGSIMAGES_NO_ALBUMS' => 'Não existem álbuns da Galeria para configurar.',
	'ACP_BBTAGSIMAGES_SAVE_FAILED' => 'Não foi possível guardar a política de tags da Galeria.',
	'ACP_BBTAGSIMAGES_SAVED' => 'A política de tags da Galeria foi guardada com sucesso.',
]);
