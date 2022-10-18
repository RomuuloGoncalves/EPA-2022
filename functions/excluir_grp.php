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

    $pag = $_GET["pag"];

    if($pag == "listar_grupos"){
        header('location: ../listar_grupos.php');
    }else{
        header('location:../index.php');
    }
?>