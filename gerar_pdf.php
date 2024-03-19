<?php
// Verifica se os dados foram recebidos via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $valor = $_POST['valor'];
    $referente = $_POST['referente'];
    $descricao = $_POST['descricao'];
    $assinatura = $_POST['assinatura'];

    // Cria um nome único para o arquivo de assinatura
    $assinatura_file = 'assinatura_' . uniqid() . '.png';

    // Decodifica a assinatura e a salva como um arquivo PNG temporário
    $assinatura_decodificada = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $assinatura));
    file_put_contents($assinatura_file, $assinatura_decodificada);

    // Inclui a biblioteca FPDF
    require('fpdf.php');

    // Cria uma nova instância do FPDF com suporte a UTF-8
    class PDF extends FPDF
    {
        function Header()
        {
            // Título
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 10, utf8_decode('FAZENDA TRÊS ARCANJOS'), 0, 1, 'C');
            $this->Ln(10);

            // Título
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, utf8_decode('RECIBO'), 0, 1, 'C');
            $this->Ln(10);
        }

        function Footer()
        {
            // Adicione o texto UTF-8 do rodapé aqui, se necessário
        }
    }

    // Cria uma nova instância do PDF
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Converte os dados para UTF-8
    $nome = utf8_decode($nome);
    $cpf = utf8_decode($cpf);
    $endereco = utf8_decode($endereco);
    $referente = utf8_decode($referente);
    $descricao = utf8_decode($descricao);

    // Adiciona os dados ao PDF
    $texto = "Eu, $nome, portador do CPF $cpf, residente em $endereco, declaro que recebi do Sr. Francisco Carlos Londe Raposo, o valor de R$ $valor referente a $referente.\nObs: $descricao";
    $pdf->MultiCell(0, 10, $texto);

    // Adiciona a assinatura ao PDF
    $pdf->Image($assinatura_file, 10, $pdf->GetY() + 10, 50, 20);

    // Adiciona o nome abaixo da assinatura
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, "Nome: $nome", 0, 1, 'L');

    // Define o nome do arquivo PDF
    $filename = 'recibo.$nome.pdf';

    // Envia o PDF para o navegador
    $pdf->Output('I', $filename);

    // Remove o arquivo de assinatura temporário
    unlink($assinatura_file);

    exit;
}
?>
