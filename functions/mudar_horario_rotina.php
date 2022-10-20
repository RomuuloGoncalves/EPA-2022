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

    var_dump($id);

    if (!$erros) {
        require 'valida_horas.php';
        $hora_inicio_novo = explode(':', $hora_inicio_novo);
        $hora_inicio_novo[0] = (int)$hora_inicio_novo[0];
        $hora_inicio_novo[1] = (int)$hora_inicio_novo[1];

        $hora_fim_novo = explode(':', $hora_fim_novo);
        $hora_fim_novo[0] = (int)$hora_fim_novo[0];
        $hora_fim_novo[1] = (int)$hora_fim_novo[1];

        if (!valida_horas($hora_inicio_novo)) {
            $erros = 'Hora de inicio invalído';
        } else if (!valida_horas($hora_fim_novo)) {
            $erros = 'Hora de fim invalído';
        }
    }

    if (!$erros) {
        require '../lib/conn.php';
        require 'formatar12h.php';
        $hora_inicio_novo = formatar12h($hora_inicio_novo);
        $hora_fim_novo = formatar12h($hora_fim_novo);
        

        $update = 'UPDATE ROTINAS
        SET H_INICIO = :hora_inicio_novo,
        H_FIM = :hora_fim_novo
        WHERE ID_ROTINA = :id';
        
        $stmt = $conn->prepare($update);
        $stmt->bindValue(':hora_inicio_novo', $hora_inicio_novo);
        $stmt->bindValue(':hora_fim_novo', $hora_fim_novo);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        header('location:../rotina.php?id='.$id.'&sucesso=Horário alterado com sucesso');
    } else {
        header('location:../rotina.php?id='.$id.'&erros='.$erros);
    }
?>