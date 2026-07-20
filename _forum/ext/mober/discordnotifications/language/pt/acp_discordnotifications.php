<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'DN_CONFIG_TITLE'                  => 'Notificações do Discord',
	'DN_CONFIG_DESCRIPTION'            => 'Selecione em quais fóruns e para quais tipos de eventos deseja criar notificações, bem como os canais do Discord para onde a mensagem de notificação deve ser enviada. Ao criar ou modificar um Webhook nesta página, tem a opção de gerar uma mensagem de teste para verificar se as suas configurações são válidas e se a mensagem aparece com sucesso no Discord.',
	'DN_GLOBAL_SETTINGS'               => 'Configurações Globais',
	'DN_ENABLE'                        => 'Ativar Notificações do Discord',
	'DN_POST_PREVIEW_LENGTH'           => 'Comprimento da pré-visualização da mensagem',
	'DN_POST_PREVIEW_DESCRIPTION'      => 'Comprimento máximo do resumo da mensagem incluído em várias notificações.',
	'DN_SEND_TEST'                     => 'Enviar Mensagem de Teste',
	'DN_SEND_TEST_DESCRIPTION'         => 'Envia o conteúdo da mensagem de teste para o webhook do Discord. Utilize isto para verificar se o seu webhook está a funcionar corretamente.',
	'DN_CONNECT_TIMEOUT'               => 'Tempo limite de ligação',
	'DN_CONNECT_TO_DESCRIPTION'        => 'Tempo limite em segundos para estabelecer ligação com o destino Webhook.',
	'DN_EXEC_TIMEOUT'                  => 'Tempo limite de transferência',
	'DN_EXEC_TO_DESCRIPTION'           => 'Tempo limite em segundos para a transferência de dados.',
	'DN_TEST_SETTINGS'                 => 'Configurações de Teste',
	'DN_WEBHOOK_SETTINGS'              => 'Editar entradas',
	'DN_WEBHOOK_SETTINGS_DESCRIPTION'  => 'Editar ou apagar entradas existentes.',
	'DN_WEBHOOK_NEW'                   => 'Criar nova entrada',
	'DN_WEBHOOK_NEW_DESCRIPTION'       => 'Criar uma nova entrada. Para obter a URL do Webhook, clique com o botão direito num canal do Discord, escolha "Editar Canal", depois vá a "Integrações" para criar um Webhook.',
	'DN_WEBHOOK_NEW_ALIAS'             => 'Novo Atalho (Alias)',
	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Pode ser escolhido livremente, por exemplo algo que descreva o canal de destino do webhook.',
	'DN_WEBHOOK_NEW_URL'               => 'Nova URL',
	'DN_WEBHOOK_NEW_URL_DESCRIPTION'   => 'URL do Webhook, deve começar com http/https.',
	'DN_WEBHOOK_SELECT'                => 'Selecionar Webhook',
	'DN_WEBHOOK_DEFAULT'               => 'Eventos Globais',
	'DN_WEBHOOK_DEFAULT_DESCRIPTION'   => 'Webhook para eventos globais não relacionados a um fórum específico, ex. criação/remoção de utilizador',
	'DN_NO_WEBHOOKS'                   => 'Não existem entradas.',
	'DN_TYPE_SETTINGS'                 => 'Tipos de Notificação',
	'DN_TYPE_DESCRIPTION'              => 'Selecione quais os tipos de notificações que devem gerar mensagens a enviar para o Discord',
	'DN_POST_CREATE'                   => 'Mensagem criada',
	'DN_POST_UPDATE'                   => 'Mensagem atualizada',
	'DN_POST_DELETE'                   => 'Mensagem eliminada',
	'DN_POST_LOCK'                     => 'Mensagem bloqueada',
	'DN_POST_UNLOCK'                   => 'Mensagem desbloqueada',
	'DN_POST_APPROVE'                  => 'Mensagem aprovada',
	'DN_TOPIC_CREATE'                  => 'Tópico criado',
	'DN_TOPIC_UPDATE'                  => 'Tópico atualizado',
	'DN_TOPIC_DELETE'                  => 'Tópico eliminado',
	'DN_TOPIC_LOCK'                    => 'Tópico bloqueado',
	'DN_TOPIC_UNLOCK'                  => 'Tópico desbloqueado',
	'DN_TOPIC_APPROVE'                 => 'Tópico aprovado',
	'DN_USER_CREATE'                   => 'Utilizador criado',
	'DN_USER_DELETE'                   => 'Utilizador eliminado',
	'DN_FORUM_SETTINGS'                => 'Fóruns de Notificação',
	'DN_FORUM_DESCRIPTION'             => 'Selecione quais os fóruns que devem gerar notificações para eventos específicos',
	'DN_TEST_SUCCESS'                  => 'Sucesso! Verifique o seu servidor Discord.',
	'DN_TEST_FAILURE'                  => 'Houve um problema ao enviar a mensagem de teste. Verifique a sua URL do webhook.',
	'DN_TEST_BAD_MESSAGE'              => 'Por favor, insira pelo menos um carácter para a mensagem de teste',
	'DN_TEST_BAD_WEBHOOK'              => 'O texto inserido para a URL do webhook não é uma URL válida.',
	'DN_SETTINGS_SAVED'                => 'Configurações das Notificações do Discord modificadas com sucesso.',
	'DN_MASTER_WEBHOOK_REQUIRED'       => 'É necessária uma URL válida do webhook do Discord para ativar as notificações.',
	'DN_WEBHOOK_URL_INVALID'           => 'A URL do webhook do Discord deve ser uma URL completa e válida.',
	'DN_POST_PREVIEW_INVALID'          => 'O comprimento da pré-visualização da mensagem deve ser um número entre 10 e 2000.',
]);
