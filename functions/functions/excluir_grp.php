<?php
    if (empty($_GET))
        header('location:../index.php');
    
    require '../lib/conn.php';
    
    $id = (int)$_GET['id'];

    $delete = 'DELETE FROM LAMPADAS_GRUPO WHERE ID_GRUPO = :id';
    $stmt = $conn->prepare($delete);
    $stmt->bindValue(':id', $id);
    $stmt->execute();


    $delete = 'DELETE FROM GRUPOS WHERE ID_GRUPO = :id';
    $stmt = $conn->prepare($delete);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    header('location:../index.php');
?>