<?php

/**
 * @package   Upload Extensions
 * @author    John Peskens, Igor Lavrov, Leinad4Mind
 * @copyright (c) 2014 - 2021 John Peskens, Igor Lavrov | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_br]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

// Some characters you may want to copy&paste:
// ’ » “ ” …

$help = [
	[
		0 => '--',
		1 => 'Módulos gerais'
	],
	[
		0 => 'O que posso fazer com a funcionalidade “Carregar uma extensão”?',
		1 => 'Você pode carregar extensões de várias fontes sem precisar usar um cliente FTP. Quando você carrega uma extensão que já existe no seu fórum, a versão antiga é guardada automaticamente na pasta especificada no seu fórum - consulte o módulo “Gestão de arquivos ZIP”. Você também pode guardar o arquivo zip da versão atualmente carregada - marque a opção “Guardar o arquivo zip carregado” antes do carregamento. Você pode garantir que está carregando o pacote verdadeiro da extensão se especificar o seu checksum no campo correspondente.'
	],
	[
		0 => 'Qual é a diferença entre o “Gestor do Carregar Extensões” e o “Gestor de Extensões” padrão do phpBB?',
		1 => 'Tal como o “Gestor de Extensões” padrão, o “Gestor do Carregar Extensões” é uma ferramenta no seu Fórum phpBB que lhe permite gerenciar todas as suas extensões e ver informação sobre elas. Mas pode ser considerado uma “versão melhorada” do módulo padrão.<br /><br /><strong>Principais vantagens:</strong><ul><li>Todas as extensões carregadas são ordenadas alfabeticamente, estejam habilitadas, desabilitadas ou desinstaladas. A exceção: as extensões corrompidas.</li><li>As extensões corrompidas são mostradas separadamente na mesma página do “Gestor de Extensões”, abaixo da lista de extensões normais. São indicados os motivos da indisponibilidade de cada extensão corrompida. É acrescentada uma mensagem de aviso detalhada a esses motivos quando a extensão corrompida está instalada ou tem dados guardados no seu banco de dados. Você pode clicar na linha de qualquer extensão corrompida para ver os seus detalhes, da mesma forma que nas restantes extensões.</li><li>Qualquer extensão (se não estiver corrompida) pode ser habilitada com um único clique no alternador mostrado à esquerda do seu nome na lista.</li></ul>'
	],
	[
		0 => 'Para que preciso do módulo “Gestão de arquivos ZIP”?',
		1 => 'Por vezes é útil poder guardar arquivos das suas extensões ou compartilhá-los. Esses arquivos podem ser versões antigas de extensões carregadas (empacotadas automaticamente para segurança dos dados), pacotes que você tenha escolhido guardar ao marcar a opção “Guardar o arquivo zip carregado” antes de um carregamento, ou quaisquer arquivos zip de extensões guardados na pasta especificada (veja a pergunta “Onde posso especificar a pasta para guardar os arquivos zip das extensões?” abaixo). Você pode descompactar, baixar e apagar esses pacotes.'
	],
	[
		0 => 'Como posso usar o módulo “Apagar extensões”?',
		1 => 'O módulo “Apagar extensões” permite que você remova os arquivos de extensões desinstaladas do seu servidor, para que possa concluir a desinstalação completa sem usar FTP. Quando você não precisar mais de uma extensão, pode removê-la por completo do seu fórum. Para isso, siga estes passos:<ul><li>Primeiro, certifique-se de que realmente não precisa dessa extensão. É recomendado que você faça cópias de segurança dos arquivos e do banco de dados antes de qualquer remoção.</li><li>Depois, vá ao “Gestor do Carregar Extensões”, encontre a extensão que deseja apagar e certifique-se de que está desabilitada: clique no alternador dessa extensão <em>se o alternador estiver verde</em>.</li><li>Certifique-se de que os dados da extensão foram apagados: <em>se o botão da lixeira dessa extensão for mostrado</em>, clique nele e confirme a ação.</li><li>Depois disso, vá ao módulo “Apagar extensões”, clique no link “Apagar extensão” mostrado na linha da sua extensão e confirme a ação.</li></ul>'
	],
	[
		0 => '--',
		1 => 'Processo de carregamento'
	],
	[
		0 => 'Como posso carregar extensões validadas a partir da CDB no phpbb.com?',
		1 => 'Na página principal do Carregar Extensões, clique no link “Mostrar extensões validadas”. Selecione a extensão que deseja carregar e clique no botão “Baixar” na linha dessa extensão. Nota: jogo de palavras aqui: a extensão será <em>baixada</em> do recurso remoto e <em>carregada</em> para o seu servidor.'
	],
	[
		0 => 'Como posso fazer um carregamento a partir de outros recursos remotos?',
		1 => 'Copie o link <strong>direto</strong> para o pacote zip da extensão (se o link não for do site phpbb.com, deve terminar em <code>.zip</code>) no campo correspondente do formulário “Carregar uma extensão” e clique no botão “Carregar”.'
	],
	[
		0 => 'Como posso carregar uma extensão a partir do meu PC local?',
		1 => 'Para isso, clique no botão “Procurar...” no formulário “Carregar uma extensão”, selecione o arquivo zip da extensão no seu computador e depois clique no botão “Carregar”.'
	],
	[
		0 => 'Copiei o link do pacote zip da extensão para o campo e cliquei no botão “Carregar”, mas aparece um erro. O que há de errado com o link?',
		1 => 'Para poder carregar a extensão, certifique-se de que as seguintes condições são atendidas:<ol><li>O link deve ser <strong>direto</strong>: para carregamentos a partir de recursos que não sejam o phpbb.com, deve terminar em <code>.zip</code>.</li><li>O link deve levar ao <strong>arquivo zip</strong> da extensão, e não à sua página de descrição.</li></ol>'
	],
	[
		0 => 'O que é o checksum? Onde posso obtê-lo?',
		1 => 'O checksum é usado para verificar a integridade do arquivo carregado. Ele é verificado para garantir que o arquivo no servidor remoto e o arquivo carregado para o seu servidor são o mesmo. O checksum geralmente pode ser obtido no mesmo recurso onde o arquivo original está guardado.'
	],
	[
		0 => '--',
		1 => 'Gestor do Carregar Extensões'
	],
	[
		0 => 'Como usar o “Gestor do Carregar Extensões”?',
		1 => 'O estado de cada extensão é apresentado como um alternador.<ul><li>Um alternador verde significa que a extensão está habilitada. Ao clicar em um alternador verde, a extensão será <strong>desabilitada</strong>.</li><li>Um alternador vermelho significa que a extensão está desabilitada. Ao clicar em um alternador vermelho, a extensão será <strong>habilitada</strong>.</li><li>Se a extensão com alternador vermelho estiver desabilitada mas ainda tiver dados guardados no banco de dados, você terá a opção de apagar esses dados ao clicar em uma lixeira junto ao alternador.<br /><em>Clicar em uma lixeira é uma forma de desinstalar a extensão do banco de dados. Se você quiser apagar os arquivos da extensão do servidor, precisará usar a Ferramenta de Limpeza de Extensões.</em></li></ul><br />Você também pode verificar novamente todas as versões das extensões ao clicar no botão correspondente, ou configurar as opções de verificação de versão da mesma forma que no “Gestor de Extensões” padrão.'
	],
	[
		0 => 'E as extensões corrompidas? Posso desinstalá-las?',
		1 => 'Sim, claro! As extensões corrompidas são mostradas no “Gestor do Carregar Extensões” abaixo da lista de extensões normais. Você pode ver os motivos pelos quais essas extensões estão corrompidas e se têm dados guardados no seu banco de dados. Clique na linha de uma extensão corrompida para ver os seus detalhes e gerenciá-la.'
	],
	[
		0 => 'O alternador de uma extensão está cinza. Por quê?',
		1 => 'O alternador cinza significa que você não pode realizar nenhuma ação com essa extensão no momento. Provavelmente já há outra ação em andamento. Além disso, o Carregar Extensões não pode desabilitar a si mesmo - por isso o seu alternador também está cinza.'
	],
	[
		0 => '--',
		1 => 'Página de detalhes da extensão'
	],
	[
		0 => 'Que informação é mostrada para as minhas extensões?',
		1 => 'A informação mostrada depende de várias circunstâncias.<ul><li>Descrição geral fornecida pelos desenvolvedores da extensão no arquivo <code>composer.json</code> (ou mensagem de aviso se a extensão estiver corrompida).</li><li>O número de versão da extensão (se não estiver corrompida).</li><li>O conteúdo do arquivo <code>README.md</code> (se existir na pasta da extensão).</li><li>O conteúdo do arquivo <code>CHANGELOG.md</code> (se existir na pasta da extensão).</li><li>Pacotes de idioma carregados para a extensão.</li><li>A árvore de arquivos da extensão e o conteúdo dos seus arquivos.</li></ul>'
	],
	[
		0 => 'O que posso fazer com a extensão na página de detalhes?',
		1 => 'Você pode:<ul><li>Habilitar a extensão se o seu alternador estiver vermelho.</li><li>Desabilitar a extensão se o seu alternador estiver verde.</li><li>Apagar os dados da extensão do banco de dados se o botão vermelho da lixeira for mostrado.</li><li>Consultar o estado da versão atual da extensão, se o link para o arquivo de verificação de versão for fornecido pelos desenvolvedores da extensão. Se a versão da extensão for mostrada em uma bolha verde - a extensão está atualizada. Se a bolha for vermelha - a extensão não está atualizada. Caso contrário - não foi possível obter a informação de verificação de versão.</li><li>Receber uma atualização para a extensão se você vir uma engrenagem junto à bolha de versão da extensão. Clique na engrenagem: se um botão “Atualizar” for mostrado, você pode clicar nele, confirmar a ação e o Carregar Extensões irá atualizar a sua extensão. Você também pode ver o anúncio de lançamento ao clicar no botão correspondente, se o link for fornecido pelos desenvolvedores da extensão. <strong>NOTA:</strong> se o JavaScript estiver desabilitado no seu navegador, esses botões estarão localizados dentro do bloco de detalhes da extensão.</li><li>Gerenciar os pacotes de idioma da extensão. Você pode carregar um novo pacote de idioma para a extensão - veja a pergunta “Que pacotes de idioma posso carregar para uma extensão?” abaixo. Você também pode apagar alguns pacotes de idioma já instalados.</li><li>Baixar o pacote da extensão (veja a pergunta “Qual é a finalidade da funcionalidade “Baixar extensão empacotada”?” abaixo).</li></ul>'
	],
	[
		0 => 'Que pacotes de idioma posso carregar para uma extensão?',
		1 => 'Você pode carregar quaisquer pacotes zip que contenham arquivos de idioma para a extensão, desde que tenham uma das seguintes estruturas:<ul><li><code>RAIZ_DO_ZIP/arquivos_de_idioma</code>, ou</li><li><code>RAIZ_DO_ZIP/pasta_única/arquivos_de_idioma</code>, ou</li><li><code>RAIZ_DO_ZIP/pasta_única/pt_br/arquivos_de_idioma</code>.</li></ul><br />Para mais informações sobre o processo de carregamento, veja a seção “Processo de carregamento” acima.'
	],
	[
		0 => 'Qual é a finalidade da funcionalidade “Baixar extensão empacotada”?',
		1 => 'O Carregar Extensões permite que você baixe pacotes zip adequados de quaisquer extensões carregadas no seu fórum para o seu PC local. Você também pode marcar uma opção para apagar o sufixo da versão de desenvolvimento - essa ação pode ajudá-lo, por exemplo, a reduzir o tempo de preparação da extensão para a CDB. Vá até a página de detalhes da extensão e clique no botão da seção “Ferramentas”. O botão “Baixar” será então mostrado.'
	],
	[
		0 => '--',
		1 => 'Gestão de arquivos ZIP'
	],
	[
		0 => 'Onde posso especificar a pasta para guardar os arquivos zip das extensões?',
		1 => 'Vá no ACP em <code>Geral -> Configuração do servidor -> Configurações do servidor -> Configurações de caminhos -> Caminho de armazenamento dos pacotes zip das extensões</code>.'
	],
	[
		0 => 'Como posso apagar vários pacotes zip de extensões de uma vez?',
		1 => 'Primeiro, certifique-se de que realmente precisa realizar essa ação; é recomendado que você tenha feito as cópias de segurança necessárias. Depois, vá ao módulo “Gestão de arquivos ZIP”, marque as opções nas linhas dos pacotes zip que deseja apagar, clique no botão “Apagar marcados” e confirme a ação.'
	],
	[
		0 => '--',
		1 => 'Ferramenta de Limpeza de Extensões'
	],
	[
		0 => 'O que é a “Ferramenta de Limpeza de Extensões”?',
		1 => 'A “Ferramenta de Limpeza de Extensões” é o nome do módulo “Apagar extensões” do Carregar Extensões, às vezes usado na sua documentação.'
	],
	[
		0 => 'Tenho uma extensão instalada no meu fórum mas não consigo apagá-la. Por quê?',
		1 => 'A extensão que você deseja remover deve estar desabilitada e os seus dados devem ser apagados do banco de dados antes de usar a “Ferramenta de Limpeza de Extensões”. Veja a pergunta “Como posso usar o módulo “Apagar extensões”?” acima.'
	],
	[
		0 => 'Como posso apagar várias extensões de uma vez?',
		1 => 'Primeiro, certifique-se de que realmente precisa realizar essa ação; é recomendado que você tenha feito as cópias de segurança necessárias. Depois, vá ao módulo “Apagar extensões”, marque as opções nas linhas das extensões que deseja apagar, clique no botão “Apagar marcados” e confirme a ação. <strong>Essas extensões não serão guardadas como arquivos zip! As suas pastas serão removidas por completo do servidor.</strong>'
	],
	[
		0 => '--',
		1 => 'Interface interativa'
	],
	[
		0 => 'Quais são as vantagens da funcionalidade JavaScript?',
		1 => 'As páginas são carregadas mais rapidamente, os elementos de design mudam rapidamente quando você interage com eles e são mostradas dicas para ajudá-lo. Todas essas funcionalidades poupam o seu tempo e só estão disponíveis se o JavaScript estiver habilitado no seu navegador.'
	],
];
