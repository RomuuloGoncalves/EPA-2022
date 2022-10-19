<?php
    if (!isset($_POST)) 
        header('location:../index.php');
    
    $erros = false;
    foreach ($_POST as $chave => $valor) {
        $valor = trim(strip_tags($valor));
        $$chave = $valor;

        if (empty($valor)) 
            $erros .= 'Campo "'.$chave.'" está em branco <br>';
    }

    if (!$erros) {
        require '../lib/conn.php';

        $update = 'UPDATE GRUPOS SET NOME = :nomeNovo WHERE ID_GRUPO = :id';
        $stmt = $conn->prepare($update);
        $stmt->bindValue(':nomeNovo', $nomeNovo);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        header('location:../grupo.php?id='.$id.'&sucesso=true');
    } else {
        header('location:../grupo.php?id=$id&erros='.$erros);
    }
?>