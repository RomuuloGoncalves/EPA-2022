<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastrar grupo</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style_cadastrar.css">
    <style>
        body{
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .aviso{
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem 1rem;
            border-radius: 5px;


        }
        
        #aviso__certo{            
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;;
        }

        #aviso__errado{
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }
    </style>
</head>
<body>
    <?php
        require "./lib/conn.php";

        // var_dump($_POST);
        $erro = false;
        if(empty($_POST) || !isset($_POST)){
            $erro = "Preencha os campos necessários";
        }

        if(empty($_POST["nome"])){
            $erro = "Preencha o campo 'nome'";
        }

        if(!$erro){
            if(empty($_POST["lampadas_selecionadas"]) || !isset($_POST["lampadas_selecionadas"])){
                $erro .= "É necessário escolher as lampadas para este grupo";
            }else{
                $lampadas_selecionadas = array_filter($_POST["lampadas_selecionadas"]);
            }
        }

        if(!$erro){
            $sql_cadastrar = "INSERT INTO GRUPOS VALUES(0, :nome)";
            $stmt = $conn->prepare($sql_cadastrar);
            $stmt -> bindValue(":nome", $_POST["nome"]);
            $stmt -> execute();

            $sql_pegar_id = "SELECT ID_GRUPO FROM GRUPOS ORDER BY ID_GRUPO DESC LIMIT 1";
            $stmt = $conn -> query($sql_pegar_id);
            $id_grupo = $stmt -> fetch(PDO::FETCH_OBJ);
            
            foreach($lampadas_selecionadas as $lampada){
                // var_dump($id_grupo);
                $sql_cadastrar = "INSERT INTO LAMPADAS_GRUPO VALUES($id_grupo->ID_GRUPO, :id_lampada)";
                $stmt = $conn->prepare($sql_cadastrar);
                $stmt -> bindValue(":id_lampada", $lampada);
                $stmt -> execute();
            }

            ?>
                <div class="aviso" id="aviso__certo">
                    Cadastrado com sucesso!!!
                </div>
                <meta http-equiv="refresh" content="3; url=./index.php">
            <?php
        }else{
            ?>
            <div class="aviso" id="aviso__errado">
                <i class="fas fa-times">
                    <?= $erro ?>
                </i>
            </div>
            <meta http-equiv="refresh" content="3; url=./cadastro_grupos.php">
        <?php
        }
        ?>
</body>
</html>