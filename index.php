<?php
include("conexao.php");

$questoes_corretas = 0;
$avaliacao = "";
$mensagem = "";
$resultados = []; // <<-- garante que a variável exista mesmo sem POST

// Gabarito (valores devem coincidir com os atributos value nos inputs)
$gabarito = [
    'pergunta1' => 'HTML',
    'pergunta2' => 'Tornar sites mais acessíveis para pessoas com deficiência',
    'pergunta3' => 'G!t@2025#XP',
    'pergunta4' => '1991',
    'pergunta5' => 'JavaScript e Python',
    'pergunta6' => 'type', // lowercase para bater com o value do input
    'pergunta7' => 'SELECT',
    'pergunta8' => 'Python',
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica acertos e guarda resultados por pergunta
    foreach ($gabarito as $pergunta => $respostaCorreta) {
        $respostaUsuario = isset($_POST[$pergunta]) ? trim($_POST[$pergunta]) : '';
        if ($respostaUsuario === $respostaCorreta) {
            $questoes_corretas++;
            $resultados[$pergunta] = ["resposta" => $respostaUsuario, "status" => "correto"];
        } else {
            $resultados[$pergunta] = ["resposta" => $respostaUsuario, "status" => "errado", "correta" => $respostaCorreta];
        }
    }

    // Define avaliação
    if ($questoes_corretas <= 2) {
        $avaliacao = "Não desista!";
    } elseif ($questoes_corretas <= 4) {
        $avaliacao = "Precisa melhorar!";
    } elseif ($questoes_corretas <= 6) {
        $avaliacao = "Bom trabalho!";
    } else {
        $avaliacao = "Parabéns!";
    }

    // Salvar no banco (uma única vez)
    $qc_esc = mysqli_real_escape_string($conexao, $questoes_corretas);
    $av_esc = mysqli_real_escape_string($conexao, $avaliacao);
    $sql = "INSERT INTO `questoes` (`questoes_corretas`, `avaliacao`) VALUES ('$qc_esc', '$av_esc')";
    if (mysqli_query($conexao, $sql)) {
        $mensagem = "Registro cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz para programadores</title>
    <meta name="description" content="Teste seus conhecimentos em programação com este quiz interativo!">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Quiz para programadores</h1>
        <p>Teste seus conhecimentos em programação com este quiz interativo!</p>
    </header>
    <main>
        <?php if (!empty($mensagem)) { ?>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
        <?php } ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <section>
                <h2>Bem-vindo ao Quiz!</h2>
                <p>Responda as perguntas a seguir para testar seus <strong>conhecimentos em programação</strong> em <abbr title="HyperText Markup Language">HTML</abbr> e <abbr title="Cascading Style Sheets">CSS</abbr>.</p>
                <p>Prepare-se!</p>
            </section>

            <!-- Pergunta 1 -->
            <section>
                <h2>Pergunta 1: Qual linguagem é usada para estruturar páginas web?</h2>
                <input type="radio" value="Python" id="p1a" name="pergunta1" required>
                <label for="p1a">Python</label><br>
                <input type="radio" value="HTML" id="p1b" name="pergunta1">
                <label for="p1b">HTML</label><br>
                <input type="radio" value="JavaScript" id="p1c" name="pergunta1">
                <label for="p1c">JavaScript</label><br>
                <input type="radio" value="Ruby" id="p1d" name="pergunta1">
                <label for="p1d">Ruby</label>
            </section>

            <!-- Pergunta 2 (corrigi os value para bater com o texto da label) -->
            <section>
                <h2>Pergunta 2: Qual o propósito de usar ARIA em um site?</h2>
                <input type="radio" id="p2a" name="pergunta2" value="Aumentar a velocidade de carregamento">
                <label for="p2a">Aumentar a velocidade de carregamento</label><br>
                <input type="radio" id="p2b" name="pergunta2" value="Tornar sites mais acessíveis para pessoas com deficiência">
                <label for="p2b">Tornar sites mais acessíveis para pessoas com deficiência</label><br>
                <input type="radio" id="p2c" name="pergunta2" value="Melhorar o design visual">
                <label for="p2c">Melhorar o design visual</label><br>
                <input type="radio" id="p2d" name="pergunta2" value="Substituir o CSS">
                <label for="p2d">Substituir o CSS</label>
            </section>

            <!-- Pergunta 3 -->
            <h2>Pergunta 3: Qual destas é uma senha forte?</h2>
            <input type="radio" id="p3a" name="pergunta3" value="123456">
            <label for="p3a">123456</label><br>
            <input type="radio" id="p3b" name="pergunta3" value="senha123">
            <label for="p3b">senha123</label><br>
            <input type="radio" id="p3c" name="pergunta3" value="Qwerty2024">
            <label for="p3c">Qwerty2024</label><br>
            <input type="radio" id="p3d" name="pergunta3" value="G!t@2025#XP">
            <label for="p3d">G!t@2025#XP</label><br><br>

            <!-- Pergunta 4 -->
            <h2>Pergunta 4: Em que ano o HTML teve sua primeira versão?</h2>
            <input type="radio" id="p4a" name="pergunta4" value="1985">
            <label for="p4a">1985</label><br>
            <input type="radio" id="p4b" name="pergunta4" value="1991">
            <label for="p4b">1991</label><br>
            <input type="radio" id="p4c" name="pergunta4" value="2001">
            <label for="p4c">2001</label><br>
            <input type="radio" id="p4d" name="pergunta4" value="2010">
            <label for="p4d">2010</label><br><br>

            <!-- Pergunta 5 -->
            <h2>Pergunta 5: Quais dessas tecnologias são linguagens de programação?</h2>
            <input type="radio" id="p5a" name="pergunta5" value="JavaScript e Python">
            <label for="p5a">JavaScript e Python</label><br>
            <input type="radio" id="p5b" name="pergunta5" value="HTML e SQL">
            <label for="p5b">HTML e SQL</label><br>
            <input type="radio" id="p5c" name="pergunta5" value="CSS e HTML">
            <label for="p5c">CSS e HTML</label><br>
            <input type="radio" id="p5d" name="pergunta5" value="SQL e XML">
            <label for="p5d">SQL e XML</label><br><br>

            <!-- Pergunta 6 -->
            <h2>Pergunta 6: Qual atributo do input define o tipo do campo?</h2>
            <input type="radio" id="p6a" name="pergunta6" value="name">
            <label for="p6a">name</label><br>
            <input type="radio" id="p6b" name="pergunta6" value="value">
            <label for="p6b">value</label><br>
            <input type="radio" id="p6c" name="pergunta6" value="type">
            <label for="p6c">type</label><br>
            <input type="radio" id="p6d" name="pergunta6" value="placeholder">
            <label for="p6d">placeholder</label><br><br>

            <!-- Pergunta 7 -->
            <h2>Pergunta 7: Qual comando SQL é usado para buscar dados em uma tabela?</h2>
            <input type="radio" id="p7a" name="pergunta7" value="INSERT">
            <label for="p7a">INSERT</label><br>
            <input type="radio" id="p7b" name="pergunta7" value="UPDATE">
            <label for="p7b">UPDATE</label><br>
            <input type="radio" id="p7c" name="pergunta7" value="SELECT">
            <label for="p7c">SELECT</label><br>
            <input type="radio" id="p7d" name="pergunta7" value="DELETE">
            <label for="p7d">DELETE</label><br><br>

            <!-- Pergunta 8 -->
            <section>
                <h2>Pergunta 8: Qual linguagem de programação é representada pelo logotipo abaixo?</h2>
                <img src="./Pictures/Python.png" alt="Logo de uma linguagem de programação"><br>
                <input type="radio" id="p8a" name="pergunta8" value="JavaScript">
                <label for="p8a">JavaScript</label><br>
                <input type="radio" id="p8b" name="pergunta8" value="HTML">
                <label for="p8b">HTML</label><br>
                <input type="radio" id="p8c" name="pergunta8" value="SQL">
                <label for="p8c">SQL</label><br>
                <input type="radio" id="p8d" name="pergunta8" value="Python">
                <label for="p8d">Python</label>
            </section>

            <input type="submit" value="Enviar Respostas">
        </form>
    </main>

    <footer>
        <p>© 2025 Quiz para programadores. Todos os direitos reservados.</p>
    </footer>

    <!-- Popup: mostrado apenas se houver resultados -->
    <?php if (!empty($resultados) && is_array($resultados)) { ?>
    <div class="popup" id="resultadoPopup" style="display:flex;">
        <div class="popup-content">
            <h2>Resultado do Quiz</h2>
            <p><strong>Você acertou <?php echo (int)$questoes_corretas; ?>/8</strong></p>
            <p><em><?php echo htmlspecialchars($avaliacao); ?></em></p>
            <hr>
            <h3>Detalhes:</h3>
            <ul style="text-align:left;">
                <?php foreach ($resultados as $pergunta => $dados) { ?>
                    <li class="<?php echo $dados['status']; ?>">
                        <?php 
                            echo htmlspecialchars(ucfirst($pergunta)) . ': ';
                            echo ($dados['resposta'] !== '' ? htmlspecialchars($dados['resposta']) : "Não respondeu");
                            if ($dados['status'] == "correto") {
                                echo " ✅";
                            } else {
                                echo " ❌ — resposta correta: " . htmlspecialchars($dados['correta']);
                            }
                        ?>
                    </li>
                <?php } ?>
            </ul>
            <button class="close-btn" onclick="document.getElementById('resultadoPopup').style.display='none'">Fechar</button>
        </div>
    </div>
    <?php } ?>
</body>
</html>
