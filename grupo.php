<?php
    if (empty($_GET)) {
        header("location:./index.php");
    }

    $id = (int)$_GET['id'];

	require_once "./lib/conn.php";
	require_once "./functions/atualizar_json.php";

	atualizar_json('SELECT PORTA, ESTADO FROM LAMPADAS', './json/lampadas.json');

    $sqlSelect = "SELECT * FROM GRUPOS WHERE ID_GRUPO = :id";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $grupo = $stmt->fetch(PDO::FETCH_OBJ);

    $sqlSelect = "SELECT * FROM LAMPADAS
    INNER JOIN LAMPADAS_GRUPO
    ON LAMPADAS_GRUPO.ID_LAMPADA = LAMPADAS.ID_LAMPADA
    WHERE LAMPADAS_GRUPO.ID_GRUPO = :id";

    $stmt = $conn->prepare($sqlSelect);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $lampadas = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Grupo - <?=$grupo->NOME?></title>
	<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="./assets/css/style.css" />
	<link rel="stylesheet" href="./assets/css/style_grupos.css">
    <link rel="stylesheet" href="./assets/css/style_modal.css">
</head>
<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

<body>
	<header>
		<div id="container__logo">
			<img id="logo" src="./assets/img/Logo DS - EPA.png" alt="Logo" />
		</div>
		<h1>EPA-2022</h1>
	</header>
	<main>
        <?php
            if (isset($_GET['erros'])) {
                ?>
                    <div class="page">
                    </div>

                    <div class="modal" id="erro">
                        <div class="texto">
                            <div class="titulo">Erro!!!!</div>
                            <div class="close">
                                <img onclick="fecharModal('erro')" src="./assets/img/close.png" alt="X">
                            </div>
                        </div>
                        <div class="simbolo">
                            <img src="./assets/img/erro.png" alt="">
                            <div class="erro">
                                <div class="aviso" id="aviso__errado">
                                    <?= $_GET['erros'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="botaoModal">
                            <button onclick="fecharModal('erro')" id="botao"> Fechar</button>
                        </div>
                    </div>
                <?php
            } else if (isset($_GET['sucesso'])) {
                ?>
                <div class="page">
                </div>
                <div class="modal" id="sucesso">
                    <div class="texto">
                        <div class="titulo">Sucesso!!!!</div>
                        <div class="close">
                            <img onclick="fecharModal('sucesso')" src="./assets/img/close.png" alt="">
                        </div>
                    </div>
                    <div class="simbolo">
                        <img src="./assets/img/sucesso.png" alt="">
                        <div class="erro">
                            <div class="aviso" id="aviso__certo">
                                Nome alterado com sucesso!
                            </div>
                        </div>
                    </div>
                    <div class="botaoModal">
                        <button onclick="fecharModal('sucesso')" id="botao" style="background-color: rgba(79, 204, 79, 0.719);border:2px solid rgb(68, 131, 68);">Fechar</button>
                    </div>
                </div>
                <?php
            }
        ?>
            <div class="page remover">
            </div>
            <div class="modal apagar" id="alterarNomeGrupo">
                <div class="texto">
                    <div class="titulo">Alterar nome do grupo</div>
                    <div class="close">
                        <img onclick="fecharModal('alterarNomeGrupo')" src="./assets/img/close.png" alt="">
                    </div>
                </div>
                <div class="formsModal">
                    <form action="./functions/mudar_nome_grp.php" method="post">
                        <div class="campos">
                            <label for="nomeNovo">Novo Nome</label>
                            <input id="nomeNovo" type="text" name="nomeNovo">
                        </div>
                        <input type="hidden" name="id" value="<?=$id?>">
                        <button type="submit" id="salvar">Salvar</button>
                    </form>
                </div>
            </div>
            <div id="titulo__grupo">
            <div class="wrapper_nome">
                <h1><?=$grupo->NOME?></h1>
                <ion-icon id="editar" name="create" onclick="abrirModal('alterarNomeGrupo');"></ion-icon>
            </div>
            <nav>
                <a href="./index.php">
                    <img src="./assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>
        </div>

        <div class="wrapper">
            <div class="titulo">
            <h2>Lâmpadas</h2>
            <a href="./adicionar_lampadas_grupo.php?id=<?=$grupo->ID_GRUPO?>">
                <img src="./assets/img/mais.png" alt="adicionar lampadas">
            </a>
        </div>
            <div class="container_lampadas">
                <?php
					foreach($lampadas as $lampada) {
						?> 
                            <div class="card card__lampada">
                            <a class="remover" href="functions/remover_lampada_grp.php?idLampada=<?=$lampada->ID_LAMPADA?>&idGrupo=<?=$id?>">
                                <img class="icon_remover" src="./assets/img/close.png" alt="X">
                            </a>
                                <a href="lampada.php?id=<?=$lampada->ID_LAMPADA?>">
                                    <img src="./assets/img/lampada_<?=$lampada->ESTADO?>.png" alt="Lampada <?=$lampada->ESTADO?>" />
                                    <p><?=$lampada->NOME?></p>
                                </a>
                            </div>
						<?php
					}
				?>
            </div>
        </div>
	</main>
    <script src="./assets/js/script.js"></script>
</body>

</html>