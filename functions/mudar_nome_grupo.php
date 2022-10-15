<?php
    $erros = false;
    if (!isset($_POST)) {
        header("location:../index.php");
    } else {
        foreach ($_POST as $chave => $valor) {
            $valor = trim(strip_tags($valor));
            $$chave = $valor;
    
            if (empty($valor)) {
                $erros .= "Campo '$chave' está em branco <br>";
            }
        }
    }

    if (!$erros) {
        require "../lib/conn.php";

        $sqlUpdate = "UPDATE GRUPOS SET NOME = :nomeNovo WHERE ID_GRUPO = :id";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bindValue(":nomeNovo", $nomeNovo);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        header("location:../grupo.php?id=$id&sucesso=true");
    } else {
        header("location:../grupo.php?id=$id&erros=$erros");
    }
?>