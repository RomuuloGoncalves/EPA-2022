<?php
require "./lib/conn.php";
$id_lampada = (int)$_GET["id"];

$sql_lampada = "SELECT * FROM LAMPADAS WHERE ID_LAMPADA = :id";
$stmt = $conn -> prepare($sql_lampada);
$stmt -> bindValue(":id", $id_lampada);
$stmt -> execute();
$lampada = $stmt->fetch(PDO::FETCH_OBJ);

$sql = "SELECT *, G.NOME as 'nome_grupo', L.NOME as 'nome_lampada' FROM LAMPADAS L INNER JOIN LAMPADAS_GRUPO LG INNER JOIN GRUPOS G ON L.ID_LAMPADA = LG.ID_LAMPADA AND LG.ID_GRUPO = G.ID_GRUPO WHERE L.ID_LAMPADA = :id";
$stmt = $conn -> prepare($sql);
$stmt -> bindValue(":id", $id_lampada);
$stmt -> execute();

$grupos = $stmt->fetchAll(PDO::FETCH_OBJ);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar lampadas</title>
    <link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style_gerenciar_lampadas.css">
</head>

<body>
    <header>
		<a href="./index.php" id="container__logo">
			<img id="logo" src="./assets/img/Logo DS - EPA.png" alt="Logo" />
		</a>
		<h1>EPA-2022</h1>
	</header>
    <main>
        <a id="voltar" href="./index.php">
            <img src="./assets/img/seta.png" alt="voltar">
        </a>
        <div class="imagem">
            <a href="functions/mudar_estado_lampada.php?id=<?=$lampada->ID_LAMPADA?>&est=<?=$lampada->ESTADO?>&indicativoPag=g">
                <img src="./assets/img/lampada_<?=$lampada->ESTADO?>.png" alt="">
            </a>
        </div>
        <div class="informacoes">
            <div class="nome__lampada">
                <h1>Lâmpada: <?=$lampada->NOME?></h1>
                <a href="./atualizar_nome_lampada.php?id_lampada=<?=$lampada->ID_LAMPADA?>">
                    <img src="./assets/img/editar.png" alt="Editar nome">
                </a>
            </div>
            <div class="grupos__pertencentes">
                <h2>Grupos:</h2>
                <div class="containers grupos">
                    <?php
                    foreach($grupos as $grupo){
                        ?>
                        <div class="campo__informacoes campo__grupo">
                            <p><?=$grupo->nome_grupo?></p>
                            <a href="functions/remover_lampada_grupo.php?id_lampada=<?=$lampada->ID_LAMPADA?>&id_grupo=<?=$grupo->ID_GRUPO?>">
                                <img src="./assets/img/remover.png" alt="">
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div> -->

                </div>
            </div>
            <div class="rotinas__pertencentes">
                <h2>Rotinas:</h2>

                <div class="containers rotinas">
                    <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div>

                    <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div>

                    <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div>

                    <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div>

                    <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div>

                    <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div>

                    <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div>

                    <div class="campo__informacoes campo__grupo">
                        <p>Quarto</p>
                        <img src="./assets/img/remover.png" alt="">
                    </div>
                </div>
            </div>
            <a class="excluir" href="functions/excluir_lampada.php?id=<?=$lampada->ID_LAMPADA?>">
                <p>excluir lampada</p>
                <img src="./assets/img/lixeira.png" alt="exluir">
            </a>
        </div>

    </main>
</body>

</html>