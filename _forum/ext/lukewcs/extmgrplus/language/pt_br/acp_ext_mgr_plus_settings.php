<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'EXTMGRPLUS_SECTION_SETTINGS'         => 'Configurações (Plus)',
	'EXTMGRPLUS_LOG'                      => 'Entrada no registro',
	'EXTMGRPLUS_LOG_EXPLAIN'              => 'Aqui você pode especificar se uma entrada deve ser adicionada ao registro de administrador para as ações "Habilitar selecionados" e "Desabilitar selecionados".',
	'EXTMGRPLUS_CONFIRMATION'             => 'Confirmação',
	'EXTMGRPLUS_CONFIRMATION_EXPLAIN'     => 'Aqui você pode especificar se as ações "Habilitar selecionados" e "Desabilitar selecionados" devem ser questionadas e ter que ser confirmadas.',
	'EXTMGRPLUS_AUTO_REDIRECT'            => 'Confirmar automaticamente as mensagens',
	'EXTMGRPLUS_AUTO_REDIRECT_EXPLAIN'    => 'Aqui você pode especificar se mensagens positivas devem ser automaticamente confirmadas. Mensagens de erro continuam a ter que ser confirmadas manualmente.',
	'EXTMGRPLUS_CHECKBOX_MODE'            => 'Definir caixas de seleção',
	'EXTMGRPLUS_CHECKBOX_MODE_EXPLAIN'    => 'Se selecionar "Definir todas", todas as caixas de seleção são automaticamente selecionadas. Se escolher "Lembrar último estado", o estado de todas as caixas é salvo quando a ação "Habilitar" ou "Desabilitar" é executada. Além disso, o estado pode ser salvo no link "%s Salvar".',
	'EXTMGRPLUS_CHECKBOX_MODE_OFF'        => 'Desligado',
	'EXTMGRPLUS_CHECKBOX_MODE_ALL'        => 'Definir todas',
	'EXTMGRPLUS_CHECKBOX_MODE_LAST'       => 'Lembrar último estado',
	'EXTMGRPLUS_SELF_DISABLE'             => 'Permitir autodesativação',
	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'     => 'Se você habilitar esta opção, a "Extension Manager Plus" também poderá se desabilitar na ação "Desabilitar selecionados", já que essa extensão poderá ser selecionada como qualquer outra.',
	'EXTMGRPLUS_INSTRUCTIONS'             => 'Ver instruções',
	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'     => 'Esta opção permite que você escolha se deseja exibir as instruções de instalação, atualização e desinstalação no fim da lista.',
	'EXTMGRPLUS_VC_LIMIT'                 => 'Dividir tempo de execução da verificação de versão',
	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'         => 'A verificação de versão é executada em blocos e com este valor você pode especificar a duração máxima de um único bloco. Isso evita exceder limites de tempo do PHP ou do banco de dados.',
	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'   => 'Propriedades da extensão',
	'EXTMGRPLUS_ORDER_AND_IGNORE'         => 'Ordem, dependência e ignorar',
	'EXTMGRPLUS_ORDER_AND_IGNORE_EXPLAIN' => 'Se você habilitar esta opção, as ações de habilitar e desabilitar em massa vão levar em conta o grupo de ordem e a propriedade de ignorar.',
	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'  => 'Configurações avançadas',
	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'  => 'Nesta seção, funções especiais relevantes para desenvolvedores podem ser habilitadas.',
	'EXTMGRPLUS_MIGRATION_COL'            => 'Mostrar coluna com novas migrações',
	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'    => 'Se habilitada, uma coluna adicional mostra o número de novas migrações.',
	'EXTMGRPLUS_MIGRATIONS'               => 'Permitir extensões com novas migrações',
	'EXTMGRPLUS_MIGRATIONS_EXPLAIN'       => 'Se habilitada, a ação de habilitar permite selecionar extensões que tenham novas migrações.',
	'EXTMGRPLUS_VERSION_URL'              => 'Mostrar link para arquivo de versão',
	'EXTMGRPLUS_VERSION_URL_EXPLAIN'      => 'Se você habilitar esta opção, pode mostrar o link para o arquivo de versão nos "Detalhes" de uma extensão.',
	'EXTMGRPLUS_SECTION_RESET'            => 'Reiniciar',
	'EXTMGRPLUS_DEFAULTS'                 => 'Reiniciar configurações',
	'EXTMGRPLUS_DEFAULTS_EXP'             => 'Reinicia todas as configurações para o padrão de instalação.',
	'EXTMGRPLUS_BUTTON_DEFAULTS'          => 'Padrões',
	'EXTMGRPLUS_MSG_CONFIRM_MIGRATIONS'   => 'Tem certeza de que deseja permitir a habilitação de extensões com novas migrações?',
	'EXTMGRPLUS_MSG_SETTINGS_SAVED'       => 'Configurações salvas com sucesso.',
]);
