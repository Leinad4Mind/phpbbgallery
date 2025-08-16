function chunkArray(array, size) {
  const chunks = [];
  for (let i = 0; i < array.length; i += size) {
    chunks.push(array.slice(i, i + size));
  }
  return chunks;
}

async function debrider_url(self) {
  const container = $(self).closest('.codebox');
  if (container.length === 0) {
    alert('Erro: Container não encontrado. Faz refresh à página.');
    return;
  }

  const elem = container.find('pre code');
  if (elem.length === 0) {
    alert('Erro: Elemento não encontrado. Faz refresh à página.');
    return;
  }

  const originalLinks = elem.text().split('\n').filter(el => el.trim() !== '');
  const chunks = chunkArray(originalLinks, 1);
  container.find('.button').hide();

  // Clear and show status
  elem.text('');
  const statusElem = $('<span id="debrider_url-generating" style="float: right; margin-left: 10px;">A processar...</span>');
  const buttonElem = container.find('.button');

  if (buttonElem.length) {
    statusElem.insertAfter(buttonElem);
  } else {
    container.append(statusElem);
  }

  for (let i = 0; i < chunks.length; i++) {
    statusElem.text(`A processar o url ${i + 1} de ${chunks.length}...`);

    try {
      const result = await $.ajax({
        url: './debrider/convert',
        method: 'POST',
        data: { urls: chunks[i] },
      });

      if (result.error) {
        elem.append(`[ERRO GLOBAL] ${result.error}\n`);
      } else if (result.results) {
        result.results.forEach(link => {
          if (typeof link === 'object' && link.error) {
            elem.append(`[ERRO] ${link.error}\n`);
          } else {
            elem.append(link.new_url + '\n');
          }
        });
      }

    } catch (err) {
      elem.append(`[Erro] Erro ao contactar o servidor no url ${i + 1}\n`);
    }
  }

  statusElem.remove();
}
