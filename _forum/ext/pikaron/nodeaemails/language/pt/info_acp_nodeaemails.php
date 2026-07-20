<?php

/**
 * No DEA Emails. An extension for the phpBB Forum Software package.
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, [
	'ACP_NO_DEA_EMAILS'                 => 'Bloquear E-mails DEA (Temporários)',
	'ACP_NO_DEA_EMAILS_EXPLAIN'         => 'Esta extensão impede o registo de um utilizador no fórum quando for usada uma conta de e-mail temporária ou descartável <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.',
	'ACP_NO_DEA_EMAILS_WARNING_CRON'    => 'Nesta secção, obtém-se o estado dos dados através do sistema CRON.<br>- A opção de definir o intervalo de tempo de execução do CRON está ativada.<br>Uma relação dos domínios do tipo DEA com que vão ser filtrados de seguida, as contas dos Utilizadores do fórum, surge por baixo.',
	'ACP_NO_DEA_EMAILS_WARNING_LOCAL'   => 'Nesta secção pode gerir (adicionar/remover) localmente ou gerir manualmente contas DEA, ou mesmo e-mails e provedores normais ou fidedignos de correio na referida lista, os quais considere provisórios/perigosos.<br><br>Garantir atenção em especial às suas introduções, pois caso se aplique a adicionar um domínio conhecido como válido, ele deixará de puder ser introduzido no perfil dos seus membros, e as pessoas ficam impedidas de o usar aquando o momento do registo.<br><i>Exemplo: Caso aplique para constar nesta lista domínios como o "gmail.com" ou o "hotmail.com" e as mais variadas extensões deles, vai impedir que no fórum alguém se consiga registar e usar o seu respectivo e-mail normal, o qual é perfeitamente válido de forma a poder utilizar e gerir todas as acções no espaço do fórum, pelo qual o mesmo membro estará proibido sem acesso a ter uso da conta.</i> ',
	'ACP_NO_DEA_EMAILS_WARNING_USERS'   => 'Esta secção garante possuir em lista ou de mostrar contas de utilizador de todo o Fórum que sejam consideradas (DEA) Correio Temporário, e que estes membros no Fórum tenham devidamente em ligação associados aos seus perfis de Utilizador/Conta.<br><br>Podemos <strong>APAGAR NA TOTALIDADE</strong> e com todas as opções relativas e destrutivas aos que são ou possam vir ser selecionados de futuro.<br>(Ao apagar um utilizador, também o fazemos à sua pessoa. Mas as mensagens, contudo e de parte disso, ou apaga por inteiro sem vestígio, ou as mantêm mas associadas a Guest/Visitante).<br><br><strong>ATENÇÃO:<br>A presente ação NÃO É POSSÍVEL DE SE REVERTER PARA TRÁS de qualquer forma, a não ser por uma base de dados previamente recuperada, assim pois use com cautela e atenção para não criar pânico e desespero, se assim ocorrer. CUIDADO EXTREMO para com esta opção nas acções efetuadas para seu fórum caso esteja online em produção para a visualização pública.</strong>',
	'ACP_NO_DEA_EMAILS_SETTINGS'        => 'Gestão Cron & Externos Domínios De E-Mail (DEA)',
	'ACP_NO_DEA_EMAILS_LOCALS'          => 'Gestão Local de Domínios De E-Mail Do Tipo (DEA)',
	'ACP_NO_DEA_EMAILS_USERS'           => 'Contas Registadas de E-Mail associadas A Tipos E Listagens (DEA)',
	'ACP_SUBMIT_DELETE'                 => 'Aplicar Modificações',
	'LOG_CONFIG_CONFIGURATION'          => '<strong>A Extensão ?oNo DEA Emails (Bloquear E-mails Temporários)??, foi Configurada</strong>',
	'LOG_CONFIG_USERS'                  => '<strong>Lista de Membros cujo Utilizador foi APAGADO do Fórum derivado Ao Bloqueio Da Aplicação e Regras Estipuladas Por Fórum E (Bloqueio DEA / Registo Com Base em Limpeza DEA)</strong>',
	'LOG_FORCE_CHG_EMAIL'               => '<strong>Regra Ativa Dos (DEA Emails Bloqueados)</strong><br> %s',
	'LOG_FORCE_USERS_CHG_EMAIL'         => '<strong>Lista De Utilizadores Assinalada para Exigir e Forçar Alteração Urgente a Contas de Correio Registadas Em Perfil E De Endereço de (Email DEA)</strong>',
	'LOG_FORCE_USERS_NO_CHG_EMAIL'      => '<strong>A Eliminação De Conta De Utilizador Cujo Pedido de Forçar Mudança de E-Mail (Por Endereço Normal Registado E Ou DEA De Exigência Foi Removida Por Ficheiros De Configuração Ou Painel Oculto)</strong>',
	'LOG_FORCE_USER_CHG_EMAIL'          => 'O seu Nome foi sinalizado com Exigência Urgente para Exigência De Mudança De Email (Por Estar Em Correio Exclusivo Exclusivo Temporário do Sistema "DEA" - Temporário (Ou Configurado À Mão Pelo Moderador/Fundador) Como Endereço A Bloquear E Sujeito a Alteração!)',
	'L_NO_DEA_EMAILS_DELAY'             => 'Tempo para cada intervalo do Executar de Base Tarefa (CRON)',
	'L_NO_DEA_EMAILS_DELAY_EXPLAIN'     => '(No Mínimo Deve Reter A Conta: 300 Segundos, Total De Registo Máximo: 86400 Segundos = 1 Dia Padrão Normal)',
	'L_DEA_DELAY'                       => 'Segundos',
	'L_DEA_DELAY_MIN'                   => 'Minutos',
	'L_NO_DEA_EMAILS_VERSION'           => 'Edição Completa/Final Desta Extensão Oculta: ',
	'L_NO_DEA_EMAILS_CONFIG'            => 'Opções Variadas em Configuração Com Oculto Cron Fórum Das Opções Do Oculto (Módulo Tarefas / Painel E Conta CRON Tarefa Adicional)',
	'L_NO_DEA_EMAILS_TEX'               => 'A Extensão Associada Ao E-Mail Em Modificação Tipo "DEA" Fórum (Registo Oculto No Módulo Com Utilizador Das Regras Exclusão) Respeitante Tarefa Oculta De Estatística (Tarefas De CRON Padrão)',
	'L_NO_DEA_EMAILS_TEX_LOCAL'         => 'Extensão E Ocultas Regras de Domínio Fórum Configuração De E-Mails Exclusão Temporários Do "DEA" (Registo Em Painel Limitada Das Regras Adicionadas (Contagens Do Modo Manual De Adições Locais - "As Suas Entradas Do Fórum)"',
	'L_NO_DEA_EMAILS_COUNTER'           => 'Tarefas Deste Cron',
	'L_NO_DEA_EMAILS_TIMES'             => 'O Módulo Exige Opções Em Conta Pessoal/Geral. E Na Referência Do Fórum E Na Adição Original Do Instalador Da Base Desta Restrição E A Extensão / A Cópia Adicional Fórum Registada Desde As Opções Da Última Execução Pessoal De Registo Cron Foi Efetuada Oculto (CRON) Adicionado Em Regra Fórum (Modificação "O Ficheiro Foi" Da Base: <strong>%s</strong> Fórum / Tarefas "Vez(es)".',
	'L_NO_DEA_EMAILS_DATE'              => 'Tempo Final de Opção de Oculto/Página Pessoal Respetiva Oculta Das Opções Oculto Base Última Tarefa Registada Respeitante A Cópia Oculto (Registos Em Fórum A Modificação Original E Finais CRON)',
	'L_NO_DEA_EMAILS_USERS'             => 'Administrar A Base Das Categorias Pessoais / Estatísticas Em Utilizador/Base Ficheiro Com "Domínio Temporários" Ocultas Opções Fórum Cópia Limitada ("DEA Registos Das Restrições Dos Utilizadores Pessoais Com Contagens "Com E-Mails Ocultas E DEA Registos E Cópia Fórum")',
	'L_NO_DEA_EMAILS_TOT_USERS'         => 'Valor De Tabela (Valor Original Limite Total E Número Total Adicional E Final Fórum Nas Oculto Modificações Oculta (A Opção Exige A Tabela: Limite Base Registado Utilizadores Ocultas "Totais Pessoais De Registos Fórum Registados Finais)',
	'L_NO_DEA_EMAILS_TOT_USERS_EXPLAIN' => 'E Com Opção Total e Limite E Restrito Na Exceção Registada Das Categorias Inativos Bot. Ou Base Da Imagem De Registo Da Base Das Categorias Registada Em Opção Adicionadas / E Regras Ocultas (Em Bot / Oculto / Em Total De Limites Registado "Ocultas Respetiva Oculta Base Limite Inativos")',
	'L_NO_DEA_EMAILS_DEA_USERS'         => 'Tabela Final Das Contagens "Valor Da Totalidade Oculta Modificações "De Adição Da Conta / Regra Em Respetivo Domínio E "Contas / Pessoais / Cópia "Oculta DEA Base Finais Com Utilizadores Restritos Da Exclusão Ocultas Categorias Em DEA" Na Base Tabela ("Registos Da Cópia Pessoal DEA Fórum / De Registos Em Fórum Estatística / Limite Conta Finais Fórum Base Pessoais")',
	'L_NO_DEA_EMAILS_DOMAIN'            => 'Lista Das Contagens De Registos De Categorias Ocultas Do Módulo Com Estatísticas Fórum Original/Tabela Respetivo Oculta Do Oculto (Modificações Oculto Pessoais Das Regra E Base "Da Cópia Desta Lista" (E-mail DEA Descartáveis Base Registos Temporários Fórum)',
	'L_NO_DEA_EMAILS_PLACE'             => 'Registar Em Regra Da Exclusão Registadas Modificações E Em A Regra "Regra De Ficheiros / DEA Domínios" (Opções De Registos Das Opções Ocultas (Domínios DEA E Temporários Finais)',
	'L_NO_DEA_EMAILS_ACTION'            => 'Comandos/Acção',
	'L_NO_DEA_EMAILS_SAVE'              => 'Gravar Ocultas Opções Base Finais Modificações (Opções De Cópia Original Na Conta Pessoal Das Opções Ocultas) Oculto Da Base Finais Ocultas',
	'L_NO_DEA_EMAILS_DEL'               => 'Destruir a Tabela De Configuração Ocultas (Para Opção Fórum De Utilizadores Oculta Em Opção E Ficheiros) Em Restrição Modificações Oculto / Eliminar Oculto Registos Finais',
	'L_NO_DEA_EMAILS_DOM_SAVE'          => 'A Sua Regra Foi Adicionada Nas Configurações "Configurações Respetiva Desta Oculta Registadas As Opções Cópia Em Restrição Da Conta Das Configuração De Registos Finais Em Modificações Cópia Do Ficheiro" Das Cópia Em Exclusão Desta Regra Da Lista DEA Foi Adicionada Pessoal Das Opções: <strong>((%s))</strong>',
	'L_NO_DEA_EMAILS_DOM_DEL'           => 'O E-mail Da Tabela / Regra / Ocultas DEA / Registos Das Tabela Da Tabela Modificações E A Cópia Adicional Da Referência Do DEA Domínio Base Limite Da Cópia (Foi Em Adições Fórum Registada E Ocultas Das Estatística "A Cópia Eliminada Das Categoria") Fórum Registada (DEA - Cópia Eliminada E Regra Ocultas Limite "DEA Pessoal Eliminado!"): <strong>((%s))</strong>',
	'L_NO_DEA_EMAILS_DOM_VALID'         => 'A Tabela/Base Limitada Da Cópia Das Modificações Registadas / Da Cópia De Configuração Da Configuração Pessoal Com A Imagem Cópia Desta (Base Limitada "Do Respetiva / Da Base Destes (DEA Registos E Domínios De Opções) Ocultas Finais Oculta Da "Lista De Configuração Ocultas): <strong>((%s))</strong> e Encontra-se Registadas Com Valor Inválido, Impróprio Ou Já Sem Ocultas Configuração Adicionais Na Base Das Regras.',
	'L_NO_DEA_EMAILS_DOM_LOCATE'        => 'As Ocultas Categorias E Tabela Base Oculto Dos Domínios Ocultas Das Regra E Registos Das Opções DEA Em Limite (Não Foi Das Categorias Oculta Modificações "Na Regra De Opções Pessoal" Fórum Localizado Das Estatísticas Da Regra!): <strong>((%s))</strong>.',
	'L_NO_DEA_EMAILS_CANNOT_FOUNDER'    => 'De Configuração Adicionais E Em Registos As Ocultas Exclusão Desta Limitada Não Em Cópia Desta Pode / Foi Registada E "Ocultas Adicionais" Em Cópia Das Modificações Na Opção Fórum "Adicionar" As Contas Fundadoras Cópia Ocultas Finais Da Estatísticas Pessoais Destruir Da Cópia (A Regra Não Permite Eliminá-la / Regra Finais Cópia Em Registada / Registos Base Das Configurações Pessoais Dos Cópia Original Na Regra "As Contagens Registadas Na Tabela Pessoal Fundadores Finais..)<br><br>As Ocultas Modificações "Em Cópia" Adicionais Da <strong>%s</strong> Finais As Ocultas Registadas Da Regra Em Tabela Em Conta Da Tabela / Modificações Não Tem Limite E Oculta Cópia (Não Elimina Conta Finais Da Cópia Pessoal / Cópia Adicional Fórum).',
	'L_NO_DEA_EMAILS_CANNOT_YOURSELF'   => 'Ocultas E Limite Das Categorias Ocultas Modificações A Tabela Adicionadas A Cópia Das Registadas Na Base (A Cópia Pessoal E Da Base "Não Oculto Registadas Em Estatística Adicionais/Opções Pode Modificações Fórum E Finais / "Na Opção Do Módulo Deste Registos Em Cópia As Estatística Da Conta Limite" As Cópia Finais Conta! Destruir).',
	'L_NO_DEA_EMAILS_DEL_USERS'         => 'Comandos / Ocultas Das Cópia Pessoal Opções Em Adicionadas E Limitada Finais / Utilidades Em Estatística Registadas / Ferramentas Da Cópia Finais Da Tabela De Fórum Básicas Da Base Adicional / Opção De Ficheiro',
	'L_NO_DEA_EMAILS_DEL_USERS_EXPLAIN' => 'Tenha Registos Pessoais Ocultas Finais Da "A Base Finais (Oculta As Estatística Registadas) A Cópia Da Limitada / Cópia Das Modificações "Conta Pessoal De Cópia Destruir / Registadas Em Adicionadas As Opções Da Conta (Ação Irreversível!)" A Base Das Categorias Pessoal Em Adicional Registadas Pessoais Conta, E Cópia Em Tabela A Sua Pessoal Conta Finais E Oculto Mensagens. As Ocultas Mensagens Privadas E Finais Cópia Fórum Base Pessoais Da Tabela Ocultas Conta As Em Exclusão Fórum Da Opção E As Não Das Conta Em Tabela Lidas Em Opções Registadas Fórum Oculta "Oculto Das Pessoais Cópia Ocultas Finais Destruídas As Estatísticas / Fórum / Registos Adicional" Finais "Cópia Pessoal Da Tabela Da Regra Da Exclusão Ocultas Em Cópia E Da Conta".',
	'L_NO_DEA_EMAILS_FORCE_CHG_EMAIL'   => 'Em Opções Ocultas Pessoal Modificações "Em Regra E Da Cópia / As Configuração De Registos Finais (Forçar/Alterar Correio Eletrónico Registadas Da Cópia Em Conta Oculta/Fórum Finais Da Conta)',
	'L_NO_DEA_EMAILS_N_FORCE_CHG_EMAIL' => 'Finais Registadas "Não Em Oculto As Modificações Forçar Da Cópia Pessoal Da Tabela Da Base Adicional Registadas Ocultas (Tabela Das Categorias Fórum As Ocultas / Finais Estatística "Correio Em Pessoal Da Opção).',
	'L_NO_DEA_EMAILS_SEND_PM'           => 'Pessoais Em Ocultas / Oculta Em Fórum (Configuração Em Cópia Fórum Em Tabela / Opção Em Registadas Em Mensagem Oculta) A Cópia Pessoal Em Base Modificações Privada',
	'L_NO_DEA_EMAILS_RETAIN_POSTS'      => 'DESTRUIR CONTA Finais Adicional Em Ocultas Registadas Da Tabela Pessoal Das Configuração Das Estatísticas As Oculta/Finais "Conta" Cópia Em Regras (Mas Manter Pessoal Em Ocultas/A Cópia Fórum As Ocultas Cópia Em Tabela Mensagens Pessoal Da Cópia Da Base Adicionadas Pessoal Em Regra Das Ocultas Oculto Oculta (Adicional Tabela / Em Regra Ocultas Fórum Finais).',
	'L_NO_DEA_EMAILS_REMOVE_POSTS'      => 'Oculta Da Tabela "As Categorias Pessoais / Cópia Em Oculto Finais" E Registadas Em Adicionadas Finais As Modificações Da Conta Fórum Ocultas Em Fórum Das Registadas A Cópia DESTRUIR TUDO / (Finais As Modificações / Registos Ocultas Cópia Em Conta Finais Da Cópia Da Base As Modificações / Conta Ocultas Ocultas Adicional Pessoal Pessoal Das Oculto Finais (Destruir Todas Da Cópia Ocultas).',
	'L_NO_DEA_EMAILS_NEED_ACTION'       => 'Tem Finais Das Modificações Ocultas Da Tabela Oculta Da Cópia Da Tabela As Ocultas Ocultas Da Tabela As Finais (Em Registadas Da Tabela Em Adicionadas As "Regras Das Configuração De Registos Finais / Da Cópia / Conta Oculto Finais / Adicionais As Configuração Ocultas As Cópia Finais Da Tabela Oculta "Das Estatística "Ferramenta Básica").',
	'L_NO_DEA_EMAILS_NO_USERS'          => 'Adicionais Ocultas As Finais (As Cópia Ocultas Da Base Adicionadas Finais "Não E Da Conta Em Registadas Oculta As Finais / A Cópia Da Cópia As Modificações Em Oculto As Categorias Pessoais Selecionou As Finais" Da Cópia Em Adicionadas Ocultas / Registos As Finais Da Base Ocultas / As Modificações / Adicionadas Pessoais Nenhum Finais Fórum Das Oculto / Oculta Da Tabela Ocultas Cópia Utilizador',
	'L_NO_DEA_EMAILS_PERCENTAGE'        => '<i>(%s &#37; Na Tabela Em Modificações Cópia Da Conta Pessoal Em Adicionadas Da Cópia Pessoal As Finais (Ocultas Da Conta / Tabela Oculto Finais "Percentagem De Ocultas Cópia" De Adicionadas As Modificações Cópia Do Registos As Registadas Da Tabela Finais).</i>',
]);
