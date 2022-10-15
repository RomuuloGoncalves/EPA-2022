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
    <link rel="stylesheet" href="./assets/css/style_modal.css">
</head>

<body>
    <header>
        <div id="container__logo">
            <img id="logo" src="./assets/img/Logo DS - EPA.png" alt="Logo" />
        </div>
        <h1>EPA-2022</h1>
    </header>



    <?php
    if (!empty($_POST)) {
        require "./lib/conn.php";
        $erro = false;
        if (empty($_POST) || !isset($_POST)) {
            $erro = "Preencha os campos necessários";
        }

        if (empty($_POST["nome"])) {
            $erro = "Preencha o campo 'nome'";
        }

        if (!$erro) {
            if (empty($_POST["lampadas_selecionadas"]) || !isset($_POST["lampadas_selecionadas"])) {
                $erro .= "É necessário escolher as lampadas para este grupo";
            } else {
                $lampadas_selecionadas = array_filter($_POST["lampadas_selecionadas"]);
            }
        }

        if (!$erro) {
            $sql_cadastrar = "INSERT INTO GRUPOS VALUES(0, :nome)";
            $stmt = $conn->prepare($sql_cadastrar);
            $stmt->bindValue(":nome", $_POST["nome"]);
            $stmt->execute();

            $sql_pegar_id = "SELECT ID_GRUPO FROM GRUPOS ORDER BY ID_GRUPO DESC LIMIT 1";
            $stmt = $conn->query($sql_pegar_id);
            $id_grupo = $stmt->fetch(PDO::FETCH_OBJ);

            foreach ($lampadas_selecionadas as $lampada) {
                // var_dump($id_grupo);
                $sql_cadastrar = "INSERT INTO LAMPADAS_GRUPO VALUES($id_grupo->ID_GRUPO, :id_lampada)";
                $stmt = $conn->prepare($sql_cadastrar);
                $stmt->bindValue(":id_lampada", $lampada);
                $stmt->execute();
            }

    ?>
                  <script src="./assets/js/script.js"></script>
        <script>
            toggleModal("sucesso")
        </script>
        <?php
               } else {
        ?>
        <script src="./assets/js/script.js"></script>
        <script>
            toggleModal("erro")
        </script>
    <?php
        }
    }
    ?>

    <main>
        <div id="titulo__cadastro">
            <h1>Cadastro de grupos:</h1>
            <nav>
                <a href="./index.php">
                    <img src="./assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>

        <form action="" method="post">

            <div class="campos">
                <label for="nome">Nome:*</label>
                <input type="text" id="nome" name="nome">
            </div>

            <div class="campos">
                <label for="selecao">Selecione as lâmpadas que pertencerão a este grupo*</label>
                <div class="opcoes">
                    <?php
                    foreach ($lampadas as $lampada) {
                    ?>
                        <div class="opcao">
                            <label for="lampada-<?= $lampada->ID_LAMPADA ?>">
                                <input type="checkbox" id="lampada-<?= $lampada->ID_LAMPADA ?>" name="lampadas_selecionadas[]" value="<?= $lampada->ID_LAMPADA ?>">
                                <div class="card card__lampada">
                                    <img src="./assets/img/lampada_<?= $lampada->ESTADO ?>.png" alt="Lampada">
                                    <p><?= $lampada->NOME ?></p>
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

    <div class="modal desativar" id="sucesso">
                <div class="texto">
                    <div class="titulo">Cadastrado!!!!</div>
                    <div class="close">
                        <img onclick="fecharModal()" src="./assets/img/close.png" alt="">
                    </div>
                </div>
                <div class="simbolo">
                    <img src="./assets/img/sucesso.png" alt="">
                    <div class="erro">
                        <div class="aviso" id="aviso__certo">
                            Grupo adicionado com sucesso
                        </div>
                    </div>
                </div>
                <div class="botaoModal">
                    <button onclick="fecharModal()" id="botao" style="background-color: rgba(79, 204, 79, 0.719);border:2px solid rgb(68, 131, 68);">Fechar</button>
                </div>
            </div>


            <div class="modal desativar" id="erro">
                <div class="texto">
                    <div class="titulo">Erro!!!!</div>
                    <div class="close">
                        <img onclick="fecharModal()"  src="./assets/img/close.png" alt="">
                    </div>
                </div>
                <div class="simbolo">
                    <img src="./assets/img/erro.png" alt="">
                    <div class="erro">
                        <div class="aviso" id="aviso__errado">
                            <?=$erro?>
                        </div>
                    </div>
                </div>
                <div class="botaoModal">
                    <button onclick="fecharModal()"  id="botao"> Fechar</button>
                </div>
               </div>
    <script src="./assets/js/script.js"></script>
</body>

</html>