<?php
    require "./lib/conn.php";
	$selectLampadas = 'SELECT * FROM LAMPADAS';
	$stmt = $conn->query($selectLampadas);
	$lampadas = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de grupos</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style_cadastro_grupos.css">
</head>
<body>
    <header>
        <div id="container__logo">
            <img id="logo" src="./assets/img/Logo DS - EPA.png" alt="Logo" />
        </div>
        <h1>EPA-2022</h1>
    </header>

    <main>
        <div id="titulo__cadastro">
            <h1>Cadastro de grupos:</h1>
            <nav>
                <a href="./index.php">
                    <img src="./assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>

        <form action="./cadastrar_grupo.php" method="post">

            <div class="campos">
                <label for="nome">Nome:*</label>
                <input type="text" id="nome" name="nome">
            </div>

            <div class="campos">
                <label for="selecao">Selecione as lâmpadas que pertencerão a este grupo*</label>
                <div class="opcoes">
                    <?php
                        foreach($lampadas as $lampada){
                            ?>
                            <div class="opcao">  
                                <label for="lampada-<?=$lampada->ID_LAMPADA?>">
                                    <input type="checkbox" id="lampada-<?=$lampada->ID_LAMPADA?>" name="lampadas_selecionadas[]" value="<?=$lampada->ID_LAMPADA?>">
                                    <div class="card card__lampada">
                                        <img src="./assets/img/lampada_<?=$lampada->ESTADO?>.png" alt="Lampada">
                                        <p><?=$lampada->NOME?></p>
                                    </div>
                                </label>
                            </div>
                            <?php
                        }
                    ?>
                    <!-- <div class="opcao">  
                        <label for="selecao">
                            <input type="checkbox" id="selecao" name="selecionado" value="">
                            <div class="card card__lampada">
                                <img src="./assets/img/lampada_0.png" alt="Lampada 0">
                                <p>Quarto-1</p>
                            </div>
                        </label>
                    </div> -->
            </div>

            <div class="botoes">
                <button type="submit" class="botao" id="btn__submit">Cadastrar</button>
                <button type="reset" class="botao" id="btn__reset">Limpar</button>
            </div>
        </form>
    </main>
</body>
</html>

