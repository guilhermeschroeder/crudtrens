<?php

session_start();

require 'conexao.php';

$quantidadeGerada = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idtrem = (int) $_POST['trem'];
    $quantidade = (int) $_POST['quantidade'];
    $erros = [];
       
    if ($idtrem <= 0) {
        $erros[] = 'Selecione um trem válido.';
    }

    if ($quantidade < 1 || $quantidade > 200) {
        $erros[] = 'A quantidade deve estar entre 1 e 200.';
    }

    if(count($erros) === 0) {
        $stmt = $conexao->prepare('INSERT INTO leitura_sensor (fk_id_trem, data_hora, velocidade_kmh, temperatura_motor_c, consumo_litros_hora, vibracao_mm_s) VALUES (?, ?, ?, ?, ?, ?)');

        $momento = time() - ($quantidade * 300);

        for($i = 0; $i < $quantidade; $i++) {
            $dataHora = date('Y-m-d H:i:s', $momento);
            $velocidade = rand(0, 9000) / 100;
            $temperatura = rand(6000, 11500) / 100;
            $consumo = rand(2000, 9000) / 100;
            $vibracao = rand(50, 900) / 100;

            $stmt->bind_param('isdddd', $idtrem, $dataHora, $velocidade, $temperatura, $consumo, $vibracao);
            $stmt->execute();

            $momento = $momento + 60;
        }

        $stmt->close();

        $_SESSION['mensagem'] = "Foram geradas {$quantidade} leituras para o trem selecionado.";
        sucesso.';

        header('Location: leituras.php?id_trem=' . $idtrem);'
        exit;
    }
    
}

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

        

$trens = $conexao->query('SELECT id, prefixo_trem, modelo_trem FROM trens ORDER BY prefixo_trem');

?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de sensores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <span class="marca">Frota Ferroviária</span>
    </header>

    <main>
        <h1>Simulador de sensores IoT</h1>

        <?php
            if ($mensagem !== ''):
        ?>
            <p class="aviso"><?= htmlspecialchars($mensagem) ?></p>
        <?php
            endif;
        ?>

        <?php
            if (isset($erros) && count($erros) > 0):
        ?>
            <div class="aviso aviso-erro">
                <ul>
                    <?php
                        foreach ($erros as $erro):
                    ?>
                        <li><?= htmlspecialchars($erro) ?></li>
                    <?php
                        endforeach;
                    ?>
                </ul>
            </div>

        <form method="POST" class="formulario">
            <div class="linha">
                <div class="campo">
                    <label for="trem">Trem</label>
                    <select id="trem" name="trem">
                        <option value="">Selecione</option>

                        <?php
                            while ($trem = $trens->fetch_assoc()):
                        ?>
                            <option value="<?= (int) $trem['id_trem'] ?>"><?= htmlspecialchars($trem['prefixo_trem']) ?></option>
                        <?php
                            endwhile;
                        ?>
                    </select>

                </div>

                <div class="campo">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" id="quantidade" name="quantidade" min="1" max="200" value="50">
                </div>
            </div>
    </main>

</div>
</div>

<div class="acoes">
    <button type="submit" class="botao botao-primario">Gerar leituras</button>
    </div>
</form>
    
</body>
</html>