function limparAssinatura() {
    var canvas = document.getElementById('assinaturaCanvas');
    var ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function gerarPDF() {
    // Captura os dados do formulário
    var nome = document.getElementById('nome').value;
    var cpf = document.getElementById('cpf').value;
    var endereco = document.getElementById('endereco').value;
    var valor = document.getElementById('valor').value;
    var referente = document.getElementById('referente').value;
    var descricao = document.getElementById('descricao').value;

    // Cria um novo documento PDF
    var doc = new jsPDF();

    // Adiciona os dados ao PDF
    doc.text(`Eu, ${nome}, portador do CPF ${cpf}, residente em ${endereco}, declaro que recebi do Sr. Francisco Carlos Londe Raposo, a importância de R$ ${valor} referente a ${referente}. Descrição: ${descricao}`, 10, 10);

    // Salva o PDF
    doc.save('recibo.pdf');
}
