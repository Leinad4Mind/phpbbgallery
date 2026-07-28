<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'As seguintes extensões obrigatórias não estão disponíveis ou estão desativadas: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'A extensão foi ativada com sucesso.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Políticas de tags da Galeria',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Configure onde as tags do catálogo compartilhado do BBTags estão disponíveis na Galeria. A moderação de sugestões de tags permanece no Painel de Controle do Moderador.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Catálogo de tags',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'O catálogo compartilhado não contém tags aprovadas.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Disponibilidade na Galeria',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'Disponível na Galeria',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Desativar uma tag a oculta dos campos e pesquisas da Galeria sem removê-la do BBTags ou do fórum.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Disponibilidade padrão',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'A regra explícita do álbum mais próximo prevalece sobre este padrão e sobre as regras herdadas.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Disponível exceto quando negada',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'Indisponível exceto quando permitida',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Regras por álbum',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Herdar usa a regra do álbum pai mais próximo e, depois, a disponibilidade padrão.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Álbum',
	'ACP_BBTAGSBRIDGE_RULE' => 'Regra',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Herdar',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Permitir',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Negar',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'Não há álbuns da Galeria para configurar.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'Não foi possível salvar a política de tags da Galeria.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'A política de tags da Galeria foi salva com sucesso.',
]);
