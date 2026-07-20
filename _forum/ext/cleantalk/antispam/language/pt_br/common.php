<?php

/**
 * @package phpBB Extension - Antispam by CleanTalk for phpBB.
 * @author Сleantalk team (welcome@cleantalk.org)
 * @copyright (C) 2014 СleanTalk team (http://cleantalk.org)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
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
	'ACP_CLEANTALK_TITLE' => 'Antispam da CleanTalk',

	'ACP_CLEANTALK_SETTINGS'       => 'Configurações de proteção contra spam',
	'ACP_CLEANTALK_SETTINGS_SAVED' => 'As configurações de proteção contra spam foram guardadas com sucesso!',

	'ACP_CLEANTALK_REGS_LABEL' => 'Verificar Registros',
	'ACP_CLEANTALK_REGS_DESCR' => 'Spam-bots serão rejeitados com uma declaração de motivos.',

	'ACP_CLEANTALK_GUESTS_LABEL' => 'Moderar Visitantes',
	'ACP_CLEANTALK_GUESTS_DESCR' => 'Mensagens e tópicos de visitantes serão testados para spam. O spam será rejeitado ou enviado para aprovação.',

	'ACP_CLEANTALK_NUSERS_LABEL' => 'Moderar Novos Usuários Registados',
	'ACP_CLEANTALK_NUSERS_DESCR' => 'Mensagens e tópicos de novos usuários serão testados para spam. O spam será rejeitado ou enviado para aprovação.',

	'ACP_CLEANTALK_CCF_LABEL' => 'Verificar formulários de contacto',
	'ACP_CLEANTALK_CCF_DESCR' => 'Habilitar teste anti-spam para formulários de contacto. Pode causar conflitos!',

	'ACP_CLEANTALK_SFW_LABEL' => 'SpamFireWall',
	'ACP_CLEANTALK_SFW_DESCR' => 'Ativa o SpamFireWall. Reduz a carga do servidor web e impede o acesso de bots ao site.',

	'ACP_CLEANTALK_APIKEY_LABEL'                     => 'Chave de acesso',
	'ACP_CLEANTALK_APIKEY_LABEL_PLACEHOLDER'         => 'Insira a chave de acesso',
	'ACP_CLEANTALK_APIKEY_DESCR'                     => 'Para obter uma chave de acesso, por favor registe-se no site ',
	'ACP_CLEANTALK_REG_NOTICE'                       => 'O e-mail do fórum',
	'ACP_CLEANTALK_REG_NOTICE2'                      => 'será utilizado para o registro',
	'ACP_CLEANTALK_AGREEMENT'                        => 'Contrato de licença',
	'ACP_CLEANTALK_APIKEY_IS_OK_LABEL'               => 'A chave é válida!',
	'ACP_CLEANTALK_APIKEY_IS_BAD_LABEL'              => 'A chave não é válida!',
	'ACP_CLEANTALK_APIKEY_GET_AUTO_BUTTON_LABEL'     => 'Obter Chave de acesso automaticamente',
	'ACP_CLEANTALK_APIKEY_GET_MANUALLY_BUTTON_LABEL' => 'Obter Acesso manualmente',
	'ACP_CLEANTALK_APIKEY_CP_LINK_BUTTON'            => 'Clique aqui para obter estatísticas anti-spam',
	'ACP_CLEANTALK_ACCOUNT_NAME_OB'                  => 'A conta em cleantalk.org é',
	'ACP_CLEANTALK_TITLE__STATS'                     => 'Estatísticas',
	'ACP_CLEANTALK_STATS__SFW_NETS'                  => 'Número de Redes Spam Firewall',
	'ACP_CLEANTALK_CHECKUSERS_TITLE'                 => 'Verificar usuários por spam',
	'ACP_CLEANTALK_CHECKUSERS_DESCRIPTION'           => 'O Anti-spam da CleanTalk verificará todos os usuários contra a base de dados de listas negras e mostrará os remetentes que têm atividade de spam noutros sites. Clique em `Verificar usuários por spam` para começar.',
	'ACP_CLEANTALK_CHECKUSERS_PAGES_TITLE'           => 'Páginas:',
	'ACP_CLEANTALK_CHECKUSERS_BUTTON'                => 'Verificar usuários por spam',
	'ACP_CLEANTALK_CHECKUSERS_NUMBER_DESCRIPTION'    => 'Número de usuários não verificados a verificar. Deixe em branco para redefinir as marcações e iniciar uma verificação completa.',
	'ACP_CHECKUSERS_DONE_2'                          => 'Concluído. Todos os usuários testados através da base de dados de listas negras, foram encontrados 0 usuários de spam.',
	'ACP_CHECKUSERS_DONE_3'                          => 'Erro. Sem ligação com a base de dados da lista negra.',
	'ACP_CHECKUSERS_USERNAME'                        => 'Nome de usuário',
	'ACP_CHECKUSERS_MESSAGES'                        => 'Mensagens',
	'ACP_CHECKUSERS_JOINED'                          => 'Registou-se',
	'ACP_CHECKUSERS_EMAIL'                           => 'E-mail',
	'ACP_CHECKUSERS_IP'                              => 'IP',
	'ACP_CHECKUSERS_LASTVISIT'                       => 'Última visita',
	'ACP_CHECKUSERS_DELETEALL'                       => 'Excluir tudo',
	'ACP_CHECKUSERS_DELETEALL_DESCR'                 => 'Todas as mensagens dos usuários excluídos serão eliminadas também.',
	'ACP_CHECKUSERS_DELETESEL'                       => 'Excluir selecionados',
	'ACP_CLEANTALK_MODERATE_IP'                      => 'O serviço anti-spam é pago pelo seu provedor de alojamento. Licença #',
	'SFW_DIE_NOTICE_IP'                              => 'O SpamFireWall está ativado para o seu IP ',
	'SFW_DIE_MAKE_SURE_JS_ENABLED'                   => 'Para continuar a usar o site, por favor certifique-se que o JavaScript está ativado.',
	'SFW_DIE_CLICK_TO_PASS'                          => 'Por favor, clique abaixo para passar a proteção,',
	'SFW_DIE_YOU_WILL_BE_REDIRECTED'                 => 'Ou será redirecionado automaticamente para a página solicitada após 3 segundos.',

	'CLEANTALK_ERROR_MAIL'    => 'Erro ao ligar ao serviço CleanTalk',
	'CLEANTALK_ERROR_LOG'     => '<strong>Erro ao ligar ao serviço CleanTalk</strong><br />%s',
	'CLEANTALK_ERROR_CURL'    => 'Erro do CURL: `%s`',
	'CLEANTALK_ERROR_NO_CURL' => 'O suporte CURL não foi compilado',
	'CLEANTALK_ERROR_ADDON'   => ' ou o allow_url_fopen está desativado no php.ini.',
	'CLEANTALK_NOTIFICATION'  => 'Tem a certeza?',

	'ACP_CLEANTALK_STATS__LAST_SPAM_REQUEST_TIME'  => 'O último pedido de verificação de spam para o servidor foi às',
	'ACP_CLEANTALK_STATS__AVERAGE_REQUEST_TIME'    => 'Tempo médio de pedido nos últimos 7 dias (segundos)',
	'ACP_CLEANTALK_STATS__LAST_SFW_BLOCK_IP'       => 'A última vez que o SpamFireWall foi acionado para o IP',
	'ACP_CLEANTALK_STATS__LAST_SFW_BLOCK_TIME'     => 'A última vez que o SpamFireWall foi acionado às',
	'ACP_CLEANTALK_STATS__SFW_LAST_TIME_UPDATED'   => 'O SpamFireWall foi atualizado às',
	'ACP_CLEANTALK_STATS__SFW_LAST_TIME_SEND_LOGS' => 'O SpamFireWall enviou os registros às',
]);
