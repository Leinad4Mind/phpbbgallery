<?php

/**
 * @package   Upload Extensions
 * @author    John Peskens, Igor Lavrov, Leinad4Mind
 * @copyright (c) 2014 - 2021 John Peskens, Igor Lavrov | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
		0 => 'O que posso fazer com a funcionalidade “Upload de uma extensão”?',
		1 => 'Podes fazer upload de extensões de várias fontes sem precisares de usar um cliente FTP. Quando fazes upload de uma extensão que já existe no teu fórum, a versão antiga é guardada automaticamente na pasta especificada no teu fórum - consulta o módulo “Gestão de ficheiros ZIP”. Também podes guardar o ficheiro zip da versão actualmente enviada - marca a opção “Guardar o ficheiro zip enviado” antes do upload. Podes garantir que estás a fazer upload do pacote verdadeiro da extensão se especificares o teu checksum no campo correspondente.'
	],
	[
		0 => 'Qual é a diferença entre o “Gestor do Upload de Extensões” e o “Gestor de Extensões” padrão do phpBB?',
		1 => 'Tal como o “Gestor de Extensões” padrão, o “Gestor do Upload de Extensões” é uma ferramenta no teu Fórum phpBB que te permite gerir todas as tuas extensões e ver informação sobre elas. Mas pode ser considerado uma “versão melhorada” do módulo padrão.<br /><br /><strong>Principais vantagens:</strong><ul><li>Todas as extensões enviadas são ordenadas alfabeticamente, estejam activadas, desactivadas ou desinstaladas. A excepção: as extensões corrompidas.</li><li>As extensões corrompidas são mostradas separadamente na mesma página do “Gestor de Extensões”, abaixo da lista de extensões normais. São indicados os motivos da indisponibilidade de cada extensão corrompida. É acrescentada uma mensagem de aviso detalhada a esses motivos quando a extensão corrompida está instalada ou tem dados guardados na tua base de dados. Podes clicar na linha de qualquer extensão corrompida para ver os teus detalhes, da mesma forma que nas restantes extensões.</li><li>Qualquer extensão (se não estiver corrompida) pode ser activada com um único clique no alternador mostrado à esquerda do teu nome na lista.</li></ul>'
	],
	[
		0 => 'Para que preciso do módulo “Gestão de ficheiros ZIP”?',
		1 => 'Por vezes é útil poderes guardar ficheiros das tuas extensões ou partilhá-los. Esses ficheiros podem ser versões antigas de extensões enviadas (empacotadas automaticamente para segurança dos dados), pacotes que tenhas escolhido guardar ao marcar a opção “Guardar o ficheiro zip enviado” antes de um upload, ou quaisquer ficheiros zip de extensões guardados na pasta especificada (consulta a pergunta “Onde posso especificar a pasta para guardar os ficheiros zip das extensões?” abaixo). Podes descompactar, transferir e apagar esses pacotes.'
	],
	[
		0 => 'Como posso usar o módulo “Apagar extensões”?',
		1 => 'O módulo “Apagar extensões” permite-te remover os ficheiros de extensões desinstaladas do teu servidor, para que possas concluir a desinstalação completa sem usar FTP. Quando já não precisares de uma extensão, podes removê-la por completo do teu fórum. Para isso, segue estes passos:<ul><li>Primeiro, certifica-te de que realmente não precisas dessa extensão. É recomendado que faças cópias de segurança dos ficheiros e da base de dados antes de qualquer remoção.</li><li>Depois, vai ao “Gestor do Upload de Extensões”, encontra a extensão que pretendes apagar e certifica-te de que está desactivada: clica no alternador dessa extensão <em>se o alternador estiver verde</em>.</li><li>Certifica-te de que os dados da extensão foram apagados: <em>se o botão do caixote do lixo dessa extensão for mostrado</em>, clica nele e confirma a acção.</li><li>Depois disso, vai ao módulo “Apagar extensões”, clica no link “Apagar extensão” mostrado na linha da tua extensão e confirma a acção.</li></ul>'
	],
	[
		0 => '--',
		1 => 'Processo de upload'
	],
	[
		0 => 'Como posso fazer upload de extensões validadas a partir da CDB no phpbb.com?',
		1 => 'Na página principal do Upload de Extensões, clica no link “Mostrar extensões validadas”. Seleciona a extensão que pretendes enviar e clica no botão “Transferir” na linha dessa extensão. Nota: jogo de palavras aqui: a extensão será <em>transferida</em> do recurso remoto e <em>enviada</em> para o teu servidor.'
	],
	[
		0 => 'Como posso fazer um upload a partir de outros recursos remotos?',
		1 => 'Copia o link <strong>directo</strong> para o pacote zip da extensão (se o link não for do site phpbb.com, deve terminar em <code>.zip</code>) para o campo respectivo do formulário “Upload de uma extensão” e clica no botão “Upload”.'
	],
	[
		0 => 'Como posso fazer upload de uma extensão a partir do meu PC local?',
		1 => 'Para isso, clica no botão “Procurar...” no formulário “Upload de uma extensão”, seleciona o ficheiro zip da extensão no teu computador e depois clica no botão “Upload”.'
	],
	[
		0 => 'Copiei o link do pacote zip da extensão para o campo e cliquei no botão “Upload”, mas surge um erro. O que se passa com o link?',
		1 => 'Para poderes fazer upload da extensão, certifica-te de que as seguintes condições são cumpridas:<ol><li>O link deve ser <strong>directo</strong>: para uploads a partir de recursos que não sejam o phpbb.com, deve terminar em <code>.zip</code>.</li><li>O link deve levar ao <strong>ficheiro zip</strong> da extensão, e não à tua página de descrição.</li></ol>'
	],
	[
		0 => 'O que é o checksum? Onde posso obtê-lo?',
		1 => 'O checksum é usado para verificar a integridade do ficheiro enviado. É verificado para garantir que o ficheiro no servidor remoto e o ficheiro enviado para o teu servidor são o mesmo. O checksum pode geralmente ser obtido no mesmo recurso onde o ficheiro original está guardado.'
	],
	[
		0 => '--',
		1 => 'Gestor do Upload de Extensões'
	],
	[
		0 => 'Como usar o “Gestor do Upload de Extensões”?',
		1 => 'O estado de cada extensão é apresentado como um alternador.<ul><li>Um alternador verde significa que a extensão está activada. Ao clicares num alternador verde, a extensão será <strong>desactivada</strong>.</li><li>Um alternador vermelho significa que a extensão está desactivada. Ao clicares num alternador vermelho, a extensão será <strong>activada</strong>.</li><li>Se a extensão com alternador vermelho estiver desactivada mas ainda tiver dados guardados na base de dados, terás a opção de apagar esses dados ao clicar num caixote do lixo junto ao alternador.<br /><em>Clicar num caixote do lixo é uma forma de desinstalar a extensão da base de dados. Se quiseres apagar os ficheiros da extensão do servidor, terás de usar a Ferramenta de Limpeza de Extensões.</em></li></ul><br />Também podes verificar novamente todas as versões das extensões ao clicar no botão correspondente, ou configurar as definições de verificação de versão tal como no “Gestor de Extensões” padrão.'
	],
	[
		0 => 'E as extensões corrompidas? Posso desinstalá-las?',
		1 => 'Sim, claro! As extensões corrompidas são mostradas no “Gestor do Upload de Extensões” abaixo da lista de extensões normais. Podes ver os motivos pelos quais essas extensões estão corrompidas e se têm dados guardados na tua base de dados. Clica na linha de uma extensão corrompida para ver os teus detalhes e geri-la.'
	],
	[
		0 => 'O alternador de uma extensão está cinzento. Porquê?',
		1 => 'O alternador cinzento significa que não podes realizar nenhuma acção com essa extensão no momento. Provavelmente já está outra acção em curso. Além disso, o Upload de Extensões não pode desactivar-se a si próprio - por isso o teu alternador também está cinzento.'
	],
	[
		0 => '--',
		1 => 'Página de detalhes da extensão'
	],
	[
		0 => 'Que informação é mostrada para as minhas extensões?',
		1 => 'A informação mostrada depende de várias circunstâncias.<ul><li>Descrição geral fornecida pelos programadores da extensão no ficheiro <code>composer.json</code> (ou mensagem de aviso se a extensão estiver corrompida).</li><li>O número de versão da extensão (se não estiver corrompida).</li><li>O conteúdo do ficheiro <code>README.md</code> (se existir na pasta da extensão).</li><li>O conteúdo do ficheiro <code>CHANGELOG.md</code> (se existir na pasta da extensão).</li><li>Pacotes de idioma enviados para a extensão.</li><li>A árvore de ficheiros da extensão e o conteúdo dos teus ficheiros.</li></ul>'
	],
	[
		0 => 'O que posso fazer com a extensão na página de detalhes?',
		1 => 'Podes:<ul><li>Activar a extensão se o teu alternador estiver vermelho.</li><li>Desactivar a extensão se o teu alternador estiver verde.</li><li>Apagar os dados da extensão da base de dados se o botão vermelho do caixote do lixo for mostrado.</li><li>Consultar o estado da versão actual da extensão, se o link para o ficheiro de verificação de versão for fornecido pelos programadores da extensão. Se a versão da extensão for mostrada numa bolha verde - a extensão está actualizada. Se a bolha for vermelha - a extensão não está actualizada. Caso contrário - não foi possível obter a informação de verificação de versão.</li><li>Receber uma actualização para a extensão se vires uma roda dentada junto à bolha de versão da extensão. Clica na roda dentada: se for mostrado um botão “Actualizar”, podes clicar nele, confirmar a acção e o Upload de Extensões irá actualizar a tua extensão. Também podes ver o anúncio de lançamento ao clicar no botão correspondente, se o link for fornecido pelos programadores da extensão. <strong>NOTA:</strong> se o JavaScript estiver desactivado no teu navegador, esses botões estarão localizados dentro do bloco de detalhes da extensão.</li><li>Gerir os pacotes de idioma da extensão. Podes fazer upload de um novo pacote de idioma para a extensão - consulta a pergunta “Que pacotes de idioma posso enviar para uma extensão?” abaixo. Também podes apagar alguns pacotes de idioma já instalados.</li><li>Transferir o pacote da extensão (consulta a pergunta “Qual é a finalidade da funcionalidade “Transferir extensão empacotada”?” abaixo).</li></ul>'
	],
	[
		0 => 'Que pacotes de idioma posso enviar para uma extensão?',
		1 => 'Podes fazer upload de quaisquer pacotes zip que contenham ficheiros de idioma para a extensão, desde que tenham uma das seguintes estruturas:<ul><li><code>RAIZ_DO_ZIP/ficheiros_de_idioma</code>, ou</li><li><code>RAIZ_DO_ZIP/pasta_única/ficheiros_de_idioma</code>, ou</li><li><code>RAIZ_DO_ZIP/pasta_única/pt/ficheiros_de_idioma</code>.</li></ul><br />Para mais informações sobre o processo de upload, consulta a secção “Processo de upload” acima.'
	],
	[
		0 => 'Qual é a finalidade da funcionalidade “Transferir extensão empacotada”?',
		1 => 'O Upload de Extensões permite-te transferir pacotes zip adequados de quaisquer extensões enviadas no teu fórum para o teu PC local. Também podes marcar uma opção para apagar o sufixo da versão de desenvolvimento - esta acção pode ajudar-te, por exemplo, a reduzir o tempo de preparação da extensão para a CDB. Vai à página de detalhes da extensão e clica no botão da secção “Ferramentas”. O botão “Transferir” será então mostrado.'
	],
	[
		0 => '--',
		1 => 'Gestão de ficheiros ZIP'
	],
	[
		0 => 'Onde posso especificar a pasta para guardar os ficheiros zip das extensões?',
		1 => 'Vai no ACP a <code>Geral -> Configuração do servidor -> Definições do servidor -> Definições de caminhos -> Caminho de armazenamento dos pacotes zip das extensões</code>.'
	],
	[
		0 => 'Como posso apagar vários pacotes zip de extensões de uma vez?',
		1 => 'Primeiro, certifica-te de que realmente precisas de realizar essa acção; é recomendado que tenhas feito as cópias de segurança necessárias. Depois, vai ao módulo “Gestão de ficheiros ZIP”, marca as opções nas linhas dos pacotes zip que pretendes apagar, clica no botão “Apagar marcados” e confirma a acção.'
	],
	[
		0 => '--',
		1 => 'Ferramenta de Limpeza de Extensões'
	],
	[
		0 => 'O que é a “Ferramenta de Limpeza de Extensões”?',
		1 => 'A “Ferramenta de Limpeza de Extensões” é o nome do módulo “Apagar extensões” do Upload de Extensões, por vezes usado na tua documentação.'
	],
	[
		0 => 'Tenho uma extensão instalada no meu fórum mas não a consigo apagar. Porquê?',
		1 => 'A extensão que pretendes remover deve estar desactivada e os teus dados devem ser apagados da base de dados antes de usares a “Ferramenta de Limpeza de Extensões”. Consulta a pergunta “Como posso usar o módulo “Apagar extensões”?” acima.'
	],
	[
		0 => 'Como posso apagar várias extensões de uma vez?',
		1 => 'Primeiro, certifica-te de que realmente precisas de realizar essa acção; é recomendado que tenhas feito as cópias de segurança necessárias. Depois, vai ao módulo “Apagar extensões”, marca as opções nas linhas das extensões que pretendes apagar, clica no botão “Apagar marcados” e confirma a acção. <strong>Essas extensões não serão guardadas como ficheiros zip! As tuas pastas serão removidas por completo do servidor.</strong>'
	],
	[
		0 => '--',
		1 => 'Interface interactiva'
	],
	[
		0 => 'Quais são as vantagens da funcionalidade JavaScript?',
		1 => 'As páginas são carregadas mais rapidamente, os elementos de design mudam rapidamente quando interages com eles e são mostradas dicas para te ajudar. Todas estas funcionalidades poupam-te tempo e só estão disponíveis se o JavaScript estiver activado no teu navegador.'
	],
];
