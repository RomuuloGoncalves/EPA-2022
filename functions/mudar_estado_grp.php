<?php
    if (empty($_GET))
        header('location:../index.php');
    
    require '../lib/conn.php';
    require 'atualizar_json.php';

    $id = (int)$_GET['id'];
    $est = (int)$_GET['est'];

    $sqlUpdate = 'UPDATE LAMPADAS INNER JOIN LAMPADAS_GRUPO ON LAMPADAS_GRUPO.ID_LAMPADA = LAMPADAS.ID_LAMPADA SET ESTADO = :est WHERE LAMPADAS_GRUPO.ID_GRUPO = :id';

    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bindValue(':est', $est);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    atualizar_json('SELECT PORTA, ESTADO FROM LAMPADAS', '../json/lampadas.json');

    header('location:../index.php')
?>