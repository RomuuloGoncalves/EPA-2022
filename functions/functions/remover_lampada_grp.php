<?php
    if (empty($_GET)){
        header('location:../index.php');
    }
    
    require '../lib/conn.php';
    $idLampada = (int) $_GET['idLampada'];
    $idGrupo = (int) $_GET['idGrupo'];

    $select = 'SELECT ID_LAMPADA FROM LAMPADAS_GRUPO WHERE ID_GRUPO = :idGrupo';
    $stmt = $conn->prepare($select);
    $stmt->bindValue(':idGrupo', $idGrupo);
    $stmt->execute();

    if ($stmt->rowCount() > 1) {
        $delete = 'DELETE FROM LAMPADAS_GRUPO WHERE ID_LAMPADA = :idLampada AND ID_GRUPO = :idGrupo';
        $stmt = $conn->prepare($delete);
        $stmt->bindValue(':idLampada', $idLampada);
        $stmt->bindValue(':idGrupo', $idGrupo);
        $stmt->execute();

        header('location:../grupo.php?id='.$idGrupo);
    }else{
        $erros = 'O grupo deve possuir no minimo uma lâmpada';
        header('location:../grupo.php?id='.$idGrupo.'&erros='.$erros);
    }
?>