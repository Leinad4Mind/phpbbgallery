<?php

/**
 * BBmembership extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
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
	'ACP_BBMEMBERSHIP_TITLE'           => 'BBmembership',
	'ACP_BBMEMBERSHIP_EXPLAIN'         => 'Configura e ajusta as definições das tuas adesões. Terás a possibilidade de poder adicionar, criar ou alterar um máximo de até 4 acessos/inscrições de estatuto VIP com diferentes pacotes. Alertamos e deixamos o reparo para que o preço tabelado e ajustado a cada pacote de serviço/inscrição seja e tenha obviamente um valor diferente entre eles. O PayPal e os BBpoints (pontos estes que terão como fator o n.º 100 de multiplicação) são atualmente os dois únicos meios de liquidação permitidos e suportados pelo sistema de pagamentos. Configura os grupos/escalões criados bem como as devidas permissões dos mesmos para assim conseguires rentabilizar as tuas inscrições a darem e proporcionarem um acesso restrito a áreas confidenciais do teu fórum que de outrora forma estariam indisponíveis, ocultas e invisíveis a todos os restantes.',
	'ACP_BBMEMBERSHIP_SANDBOX'         => 'Acesso e uso das API do PayPal (sandbox)',
	'ACP_BBMEMBERSHIP_SANDBOX_EXPLAIN' => 'Dedicado apenas com o intuito para fins de teste na utilização do gateway ou ambiente PayPal. <a href="https://developer.paypal.com/" target="_blank">Mais informação.</a>',

	'ACP_BBMEMBERSHIP_CLUBMODE'             => 'Utilizar o Modelo de Clube (Privado)',
	'ACP_BBMEMBERSHIP_CLUBMODE_EXPLAIN'     => 'Aos novos visitantes lhes continuará a ser permitido e a dar total e total garantia à sua inscrição bem como o seu normal e habitual registo no fórum como é apanágio mas com uma condição ou regalia em detrimento a favor da "gerência", onde estes recém-chegados não terão acesso nem conseguirão visualizar absolutamente nada a não ser e se subscreverem o seu modelo/pacote ou a sua "Joia" no teu serviço restrito com as devidas e comprovadas liquidações pagas com extremo sucesso.',
	'ACP_BBMEMBERSHIP_PAYPAL_EMAIL'         => 'Introduz o E-mail de conta da tua receção para o PayPal',
	'ACP_BBMEMBERSHIP_PAYPAL_EMAIL_EXPLAIN' => 'Insere o e-mail da tua conta associada ao PayPal para receber as transações ou então o E-mail destinado à sandbox do PayPal no caso de estares a efetuar o uso exclusivo desse modo unicamente para meros e comuns fins de teste.',
	'ACP_BBMEMBERSHIP_BBPOINTS'             => 'BBpoints',
	'ACP_BBMEMBERSHIP_BBPOINTS_EXPLAIN'     => 'Ao definires os pacotes com valores, sabe que estes permitirão em contrapartida que todos os teus utilizadores que reúnam as condições devidas possam efetuar o resgate das suas respetivas aquisições de grupo com o auxílio do módulo ou extensão dos <a href="https://sitesplat.com/phpBB3/marketplace.php" target="_blank">BBpoints</a><br /> A multiplicação de (BBpoints) pontos exigida, para cada pacote, na conversão da moeda é por (fator 100). Em suma e tendo como Exemplo prático. A quantia e o valor que perfaz na moeda de $5 equivale na prática a 500 BBpoints, os ditos $10 equivalerão já a 1000 BBpoints e por aí em diante.',
	'ACP_BBMEMBERSHIP_COUNTDOWN'            => 'Utilizar um Relógio ou Temporizador',
	'ACP_BBMEMBERSHIP_COUNTDOWN_EXPLAIN'    => 'O Relógio entrará e dará um início e respetiva contagem decrescente em base de semanas e dias na altura da compra da aquisição, alertamos no entanto para o facto disto por vezes poder induzir as pessoas em erro, sendo por base e muitas das vezes propício a poder tornar-se até bastante confuso e complexo de interpretar no ponto de vista prático pelo comum dos utilizadores.',

	'ACP_BBMEMBERSHIP_LEVELS'         => 'Ajustar níveis dos Escalões/Grupos da respetiva Associação',
	'ACP_BBMEMBERSHIP_LEVELS_EXPLAIN' => 'Ajusta, define e cria aqui todos os níveis dos teus membros no momento de adesão, preenche os valores mínimos obrigatórios (amount) com intuito e propósitos que visam permitir o futuro ingresso. Seguido da data do prazo de validade (expiry) que se converterá e ficará refletida a atuar mediante a indicação de dias da duração do serviço assim como também preencher e facultar obrigatoriamente a dita descrição (description) do respetivo plano sem esquecer a associação de preencher a que grupo base (group) será inserido. Terás também a oportunidade de definir se tudo isto em conformidade passará a ser como o teu grupo padrão e ou primário (default). <br /> Define as horas, tempos e validade em: <br />  &nbsp;&nbsp;&nbsp;<strong>0</strong> Não expirará. Membro em base ilimitada. <br /> &nbsp;&nbsp;<strong>-1</strong> Passará o equivalente de 5 minutos, dedicado unicamente como propósitos com a finalidade de execução de testes (Apenas será válido e só aplicável no modo Sandbox do PayPal). <br /> &nbsp;&nbsp;&nbsp;<strong>1</strong> Define, regula e assinala o número base em dias equivalente à tua adesão que terá de conter os parâmetros estritamente superiores e a começar com o valor de 1 ou então com os demais sucessores numéricos. Na Prática: 2, equivaleria na exatidão a serem considerados dois dias (48 horas), etc. <br /><strong>Lembrete:</strong> NUNCA utilizes ou introduzas casas nem números decimais em lado algum. Assinala caso queiras a opção de marcação de seleção no último bloco de forma a omitir, ignorar ou ocultar o respetivo plano/pacote de subscrição na página da extensão das adesões caso as não pretendas dar a conhecer ou não as tenciones comercializar/desponibilizar publicamente perante os teus utilizadores.',

	'ACP_BBMEMBERSHIP_AMT'              => 'Valor / Preço',
	'ACP_BBMEMBERSHIP_EXPIRE'           => 'Valid. Expirar',
	'ACP_BBMEMBERSHIP_PACKAGE'          => 'Descrição do pacote',
	'ACP_BBMEMBERSHIP_PACKAGE_LEVEL'    => 'Nível da adesão',
	'ACP_BBMEMBERSHIP_GROUP'            => 'Escolha o Grupo',
	'ACP_BBMEMBERSHIP_DEFAULT'          => 'Padrão (Default)',
	'ACP_BBMEMBERSHIP_HIDE'             => 'Esconder (Hide)',
	'ACP_BBMEMBERSHIP_CURRENCY'         => 'Indicação, denominação e designação do código da respetiva Moeda',
	'ACP_BBMEMBERSHIP_CURRENCY_EXPLAIN' => 'Os códigos na tua moeda deverão ser exatos e seguir na íntegra a formatação permitida, verifica e tira todas as tuas dúvidas em <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">PayPal Múltiplas Moedas Correntes</a>. <br /> Assegura-te atempadamente que a Moeda de troca e ou com as quais os pagamentos vão ser efetuados se encontram totalmente compatíveis e ativas na tua configuração/definição de opções na própria conta de gestão do teu PayPal. <br /><strong>Por favor presta atenção, caso a conversão da moeda que venhas a designar não se encontre suportada ativamente pela conta do teu serviço de PayPal não te é permitido nem facultado o seu respetivo tratamento e isto inviabiliza com que as futuras transações se tornem recusadas e dadas como não tendo sido possível ser efetuada a sua comprovação e sendo devolvidas como estando num parâmetro "Não verificadas (Not verified)" ou mesmo retidas em modo "Pendentes (Pending)". Portanto não é de todo demais alertar que tenhas estritamente o cuidado de verificar e reter todas estas informações e que deves assim como tens obrigação em deixar a Moeda devidamente ativada, tratada e corretamente configurada com a tua Conta do PayPal primeiro!</strong> ',

	'ACP_BBMEMBERSHIP_FLAGS'         => 'Modo ou Situação referente à Identificação do Pagamento/Transação',
	'ACP_BBMEMBERSHIP_FLAGS_EXPLAIN' => '<span class="label label-danger">Não Verificadas/Identificadas (Not verified)</span>: Denota a um utilizador que até tomou parte e tentou prosseguir no desenvolvimento de uma intenção de compra mas que logo de seguida demonstrou desistência, querendo anular de imediato e em recuo, retrocedeu por mudar de ideias, de tal modo que o PayPal acabou por ficar incapaz e não ter sido possível de lhe ser permitida a respetiva verificação sobre a dita transação na conta.<br />
	                                            <span class="label label-warning">Pendentes/Atrasadas (Pending)</span>: Significa isto que é o resultado de uma transação Pendente e na qual se verifica em base que a respetiva conta do PayPal não possui os fundos, e ou ainda a referida moeda encontra-se numa situação em que acabou por não ser possível a mesma tornar-se aprovada nem ter sido sequer ainda permitida/ativada. <a href="https://webinterpret.zendesk.com/hc/en-us/articles/203728826-How-to-set-up-your-PayPal-to-accept-foreign-currencies-PayPal-interface-" target="_blank">Consulta para mais informações.</a><br />
												<span class="label label-success">Concluídas (Completed)</span>: Significa isto que resultará que o PayPal analisou ativamente e com isto conseguiu aprovar e verificar as transações de forma rápida, eficiente e com extremo sucesso de parte a parte.<br />
												<span class="label label-default">Expiradas/Inválidas (Expired)</span>: Acusa o sinal de expiração perante uma validade nula e indica perante o término em que a própria subscrição de determinado membro que se situava associada ao seu respetivo grupo do pacote acabou automaticamente removido (pelo sistema). 
												<br />
												<p><strong>ATENÇÃO (NOTA):</strong> Caso uma transação em andamento se encontre rotulada ou indicada como a situação do estado duma compra ser tida como "Não Verificada (Not verified)", informamos que te está devidamente ao teu alcance a ação e possibilidade de poderes alternar e teres forma de gerir esse mesmo estado ou verificação perante a listagem bastando que para tal apenas cliques na indicação (vermelha) perante a tua visualização, passando de imediato este mesmo aspeto do estado para surgir automaticamente rotulado em modo verde sob a forma e designação correspondente à de (Completed), o que significará com isto estar desde logo validada/aprovada ou então já e devidamente Concluída, o que vai acabar na mesma por forçar os desenvolvimentos e transferir na mesma e de forma automatizada esse utilizador para ingressar no destino ou subscrição do seu pretendido grupo (mesmo sem ter pago).
												Por favor e mais uma vez te alertamos que perante o mais pequeno sinal te certifiques sempre com certezas absolutas quanto à faturação das movimentações da tua conta de PayPal para com este tipo de anomalias que não resultaram a que o estado de mudança automática por parte do sistema não sucedesse nas últimas 24H num processo dito de modo normal, pois o facto de teres tomado a decisão em alterar os estatutos e teres optado por forçar manual e intencionalmente como uma operação ou validação tida já por ti como estritamente "Concluída/Aprovada" terá as tuas consequências ao teu próprio risco em caso de te teres equivocado e enganado na tomada da tua resolução final.</p>
												<p>A menção a verde "Concluída/Aprovada" assim como no que reflete à indicação designada de uma transação surgir "Expirada/Inválida (Expired)" constatam nada mais que a confirmação assinalada em como se trataram unicamente e por mera norma a métodos de atuações tomadas numa base e forma automatizada pelo nosso sistema através duma implementação assente nos agendamentos temporários, mais conhecidos por (Cron Jobs) que em suma visam dar lugar ou remoções baseadas em critérios perfeitamente enquadrados consoante determinado tempo estipulado ou X da meta dum utilizador.
												Por conseguinte, a alternação de forma manual não verificadas perante um sinal de "Não Verificada/Identificada (Not verified)" bem como num "Concluídas/Aprovadas" terá como intuito o de mover, transportar e acrescentar o utilizador ou então por outro prisma o de ser removido duma maneira e em base forçadamente conforme sucedesse essa mesma designação dentro de um "X" nível num grupo. E depois, em relação a uma transação em modo "Expiradas/Inválidas (Expired)", esta ser-te-á permitida e possível na mesma voltar atrás ou alternar perante as tuas decisões em modo rotulado a indicação do Estado para "Não Verificada/Identificada" bem como a "Concluídas/Aprovadas", contudo, sabe de antemão que uma vez tomado este passo jamais conseguirás reverter para um estado antigo nem com que esta regresse à sua base original do que teria se mantido em "Expirada/Inválida", visto esta opção se ter esgotado.</p>',

	'ACP_BBMEMBERSHIP_SYNC'         => 'Efetuar uma Sincronização ou Atualização aos Dados',
	'ACP_BBMEMBERSHIP_SYNC_EXPLAIN' => 'Isto forçará imediatamente a criar e encetar um recálculo inicial para uma pré e ou sincronização face às definições relativas aos pacotes/grupos face aos atuais membros subscritos.<br />Instale a Extensão <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Estado Cron (Cron Status)</a> para assim conseguires interagir com toda a fiabilidade e eficácia no teu sistema das respetivas tarefas e agendamentos ou em último caso para conseguir pelo menos consultar as atuações do (cron jobs). <br />Alertamos no entanto de que: Uma devida sincronização que seja automática e decorra pelos trâmites legais do cron passará a indicação da bandeira numa determinada transação desde e já outrora "Concluída" para de imediato se alterar como "Expirada", tudo isto bastando apenas e só que os fatores para que tal medida se apliquem surjam como metidos ou inseridos nos novos critérios referentes perante esse X de utilizador.<br />No que concerne à devida sincronização como de agendamento na gestão deste processo na fila de espera, a mesma tratará apenas duma contagem correspondente por um bloco/limite que abrangerá e tratará em simultâneo os "50 utilizadores processados". Num outro aspeto perante grandes Comunidades contendo um vasto leque de números de fóruns e possuindo também inúmeros utilizadores assim como bastantes adesões, queiram ter em conta a demora de todo e qual o tempo necessário ou indispensável para se conseguir atingir no limite aos 100% perante uma conclusão na devida e total sincronização global.',
	'LAST_MEMBERSHIP_CHECK'         => 'A Última Sincronização e verificação de dados sucedeu a:',

	'ACP_BBMEMBERSHIP_TRANSACTIONS'   => 'Transações dos Últimos Movimentos Registados',
	'ACP_BBMEMBERSHIP_TOTAL'          => 'Montante (Quantia)',
	'ACP_BBMEMBERSHIP_ADDRESS'        => 'E-mail e ou Respetivo Endereço de Contacto',
	'ACP_BBMEMBERSHIP_COUNTRY'        => 'País (Residência)',
	'ACP_BBMEMBERSHIP_TRANSACTION_ID' => 'O ID (N.º) Transação',
	'ACP_BBMEMBERSHIP_PAY_STATUS'     => 'Estado (Validado)',
	'ACP_BBMEMBERSHIP_EXPIRED'        => 'Foi Expirada Em',
	'ACP_BBMEMBERSHIP_CH_STATUS'      => 'Forçar Mudança ou Alternar Manualmente sobre o Estado das Transações',
	'ACP_BBMEMBERSHIP_TIME'           => 'Data Pagamento (E Respetiva Hora Local Registada)',

	'ACP_BBPOINTS_NOTICE_CLOSE'   => 'Fechar ou Sair',
	'BBPOINTS_NOTICE'             => 'Lamentamos informar, mas a extensão dos <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>BBpoints</strong></a> encontra-se por instalar ou em falta no momento, impossibilitando desta maneira a devida integração ou não lhe permitindo a continuação nem um bom e correto usufruto das capacidades interligadas de todo o sistema da loja virtual baseada em Carrinho de Compras pelo modo Pontos/BBpoints.',
	'ACP_BBMEMBERSHIP_SAVE_ERROR' => 'Humm, deparámo-nos e fomos ao encontro a que algo não estaria correto aquando de uma tentativa de gravar a tua anterior e última configuração na base de dados, pelo que, as mesmas por precaução não se sucederam. Encarecidamente te pedimos que por favor verifiques e refaças novamente do zero todas as tuas intenções e as tentes aplicar de novo.',
	'BBMEMBERSHIP_NOTICE'         => '<div class="attach-image"><p>As definições que estão ou dão base à atuação desta extensão por base encontram-se situadas unicamente nas áreas e perante os sub-menus de <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Começa por definir nos menus das opções a tua correta gestão dos Grupos de modo a que a associação entre todos os pacotes das adesões (MemberShip/VIP) em conjunto consigam ficar preparadas em primeiro lugar, logo que termines atua em conformidade na interligação do PayPal e também, no caso de adquirires a mesma, a integração complementar da extensão BBpoints de modo a rentabilizar com a extra e fundamental funcionalidade acrescida.</p></div>',


	'BBMEMBERSHIP_DESCRIPTION' => 'Deixa que o teu fórum flua com a integração e introdução dum modo e sistema mais que fiável nos pagamentos com assinaturas VIP, tornando na íntegra a tua área numa comunidade mais requintada onde, querendo, até se pode propor que transformes opcionalmente por intermédio disto em acessos restritos criando subfóruns unicamente em formato de clube privado para apenas darem e concederem entrada só unicamente a membros ou donativos monetários onde apenas os utilizadores pagantes têm permissão. Destacam-se e estão incluídas nesta área imensas e poderosas configurações, tornando a extensão numa característica muito única e singular devido às inúmeras peculiaridades face às mais que distintas e amplas possibilidades em pagar as assinaturas dos respetivos grupos, até em formato de pagamento gerido ou aliado a um mercado dos pontos da extensão extra (BBpoints).',
	'BBMEMBERSHIP_DEVELOPERS'  => 'Criadores',
	'BBMEMBERSHIP_TASKS_1'     => 'Possuí e detém verdadeiros recursos de sistema como um associado Membro e ou Adesões de Assinaturas (VIP)',
	'BBMEMBERSHIP_TASKS_2'     => 'Aliada com a Interligação e Portabilidade (Gateway) PayPal e BBpoints',
	'BBMEMBERSHIP_TASKS_3'     => 'Com Modelos em Clube Privado direcionado aos Fóruns mais restritos ou confidenciais',
	'BBMEMBERSHIP_TASKS_4'     => 'Atuando numa gestão da base de dados e Sincronização a par dos (cron tasks) sendo aliás plenamente compatível face ao auxílio proveniente da extensão <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Estado Cron (Cron Status)</a>',
	'BBMEMBERSHIP_TASKS_5'     => 'Bastante Expansível face e perante uma fusão em detrimento à utilização das funções da extensão em anexo dos BBpoints como intenção em tornar e possivelmente tentar levar os membros da comunidade a poderem comprar ou fazer aquisições e assinaturas ao entrarem nos modos em que apenas lhes seriam imputados através dos seus pontos ou créditos amealhados de bónus para darem usufruto. Obtenha e adquira num bónus acrescido o modo premium ou avançado da extensão dos BBpoints no repositório de: <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BBMEMBERSHIP_TASKS_6'     => 'Mais, muito Mais..!',

	'SITESPLAT_COM'                 => 'https://sitesplat.com',
	'SITESPLAT_COPY'                => '&#169; SiteSplat',
	'LICENSE_INFO'                  => 'Proprietary - SiteSplat All rights reserved (Direitos de Autor Reservados)',
	'EXTENSION_DEVELOPER'           => 'Desenvolvedor',
	'ACP_BBMEMBERSHIP_NOTICE_CLOSE' => 'Fechar (Close)',

	'ACP_BBMEMBERSHIP_VERSION' => '1.4.8',
	'ACP_LOADING'              => 'Por Favor, Aguarde Um Momento. A Carregar as Informações...',

]);
