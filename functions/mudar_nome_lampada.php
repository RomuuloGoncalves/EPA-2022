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

        $update = 'UPDATE LAMPADAS SET NOME = :nome WHERE ID_LAMPADA = :id';
        $stmt = $conn->prepare($update);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        header('location:../lampada.php?id='.$id.'&sucesso=true');
    } else {
        header('location:../lampada.php?id='.$id.'&erros='.$erros);
    }
?>