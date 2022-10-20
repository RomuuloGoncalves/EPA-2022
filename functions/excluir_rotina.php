<?php
    if (empty($_GET))
        header('location:../index.php');
    
    require '../lib/conn.php';
    
    $id = (int)$_GET['id'];

    $delete = 'DELETE FROM LAMPADAS_ROTINA WHERE ID_ROTINA = :id';
    $stmt = $conn->prepare($delete);
    $stmt->bindValue(':id', $id);
    $stmt->execute();


    $delete = 'DELETE FROM ROTINAS WHERE ID_ROTINA = :id';
    $stmt = $conn->prepare($delete);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    header('location:../index.php');
?>