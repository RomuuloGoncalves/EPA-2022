<?php
    if (empty($_GET))
        header('location:../index.php');
    
    require '../lib/conn.php';
    
    $id = (int)$_GET['id'];
    $est = (int)$_GET['est'];
    $idGrupo = (int)$_GET['idGrupo'];

    $est = $est === 1 ? 0 : 1;

    $sqlUpdate = 'UPDATE LAMPADAS SET ESTADO = :est WHERE ID_LAMPADA = :id';

    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':est', $est);
    $stmt->execute();

    
    $pag = $_GET['pag'];

    if($pag === 'lampada')
        header('location: ../lampada.php?id='.$id);
    else if($pag === 'grupo')
        header('location: ../grupo.php?id='.$idGrupo);
    else if($pag === 'listar_lampada')
        header('location: ../listar_lampadas.php');
    else
        header('location: ../index.php')

?>