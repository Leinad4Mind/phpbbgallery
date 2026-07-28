<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSIMAGES_DEPENDENCIES_MISSING' => 'As seguintes extensões obrigatórias não estão disponíveis ou estão desativadas: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'A extensão foi ativada com sucesso.',
	'ACP_BBTAGSIMAGES_POLICIES' => 'Políticas de tags da Galeria',
	'ACP_BBTAGSIMAGES_POLICIES_EXPLAIN' => 'Configure onde as tags do catálogo compartilhado do BBTags estão disponíveis na Galeria. A moderação de sugestões de tags permanece no Painel de Controle do Moderador.',
	'ACP_BBTAGSIMAGES_TAG' => 'Catálogo de tags',
	'ACP_BBTAGSIMAGES_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSIMAGES_NO_TAGS' => 'O catálogo compartilhado não contém tags aprovadas.',
	'ACP_BBTAGSIMAGES_PROVIDER_POLICY' => 'Disponibilidade na Galeria',
	'ACP_BBTAGSIMAGES_ENABLED' => 'Disponível na Galeria',
	'ACP_BBTAGSIMAGES_ENABLED_EXPLAIN' => 'Desativar uma tag a oculta dos campos e pesquisas da Galeria sem removê-la do BBTags ou do fórum.',
	'ACP_BBTAGSIMAGES_MODE' => 'Disponibilidade padrão',
	'ACP_BBTAGSIMAGES_MODE_EXPLAIN' => 'A regra explícita do álbum mais próximo prevalece sobre este padrão e sobre as regras herdadas.',
	'ACP_BBTAGSIMAGES_MODE_GLOBAL' => 'Disponível exceto quando negada',
	'ACP_BBTAGSIMAGES_MODE_RESTRICTED' => 'Indisponível exceto quando permitida',
	'ACP_BBTAGSIMAGES_ALBUM_RULES' => 'Regras por álbum',
	'ACP_BBTAGSIMAGES_ALBUM_RULES_EXPLAIN' => 'Herdar usa a regra do álbum pai mais próximo e, depois, a disponibilidade padrão.',
	'ACP_BBTAGSIMAGES_ALBUM' => 'Álbum',
	'ACP_BBTAGSIMAGES_RULE' => 'Regra',
	'ACP_BBTAGSIMAGES_RULE_INHERIT' => 'Herdar',
	'ACP_BBTAGSIMAGES_RULE_ALLOW' => 'Permitir',
	'ACP_BBTAGSIMAGES_RULE_DENY' => 'Negar',
	'ACP_BBTAGSIMAGES_NO_ALBUMS' => 'Não há álbuns da Galeria para configurar.',
	'ACP_BBTAGSIMAGES_SAVE_FAILED' => 'Não foi possível salvar a política de tags da Galeria.',
	'ACP_BBTAGSIMAGES_SAVED' => 'A política de tags da Galeria foi salva com sucesso.',
]);
