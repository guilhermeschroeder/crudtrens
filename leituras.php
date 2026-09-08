
unset($_SESSION['mensagem']);

$trens = $conexao->query('SELECT id_trem, prefixo_trem, modelo_trem FROM trens ORDER BY prefixo_trem');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leituras dos Sensores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <head>
        <span class="marca">Frota Ferroviária</span>
    </head>

    <main>
        <div class="titulo">
            <h1>Leituras dos Sensores</h1>
        </div>

        <?php
            if ($mensagem !== ''):
        ?>
            <p class="aviso"><?= htmlspecialchars($mensagem) ?></p>
        <?php
            endif;
        ?>

        <form method="GET" class="formulario">
            <div class="linha">
                <div class="campo">
                    <label for="id_trem">Filtrar por trem</label>
                    <select id="id_trem" name="id_trem">
                        <option value="">Todos</option>

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

        </div>
        </div>
        </form>
    </main>
</body>
</html>