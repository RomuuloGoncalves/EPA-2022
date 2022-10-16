<?php
    if (empty($_GET)){
        header('location: ./index.php');
    }

    require '../lib/conn.php';
    // require './atualizar_json.php';
    $id = (int) $_GET['id'];

    $delete = 'DELETE FROM LAMPADAS_GRUPO WHERE ID_LAMPADA = :id';
    $stmt = $conn->prepare($delete);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $delete = 'DELETE FROM LAMPADAS_ROTINA WHERE ID_LAMPADA = :id';
    $stmt = $conn->prepare($delete);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $delete = 'DELETE FROM LAMPADAS WHERE ID_LAMPADA = :id';
    $stmt = $conn->prepare($delete);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    // atualizar_json('SELECT PORTA, ESTADO FROM LAMPADAS', '../json/lampadas.json');

    header('location:../index.php');
?>