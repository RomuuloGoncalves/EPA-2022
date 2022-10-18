<?php
    if (empty($_GET))
        header('location:../index.php');
    
    require '../lib/conn.php';

    $id = (int)$_GET['id'];
    $est = (int)$_GET['est'];

    $sqlUpdate = 'UPDATE LAMPADAS INNER JOIN LAMPADAS_GRUPO ON LAMPADAS_GRUPO.ID_LAMPADA = LAMPADAS.ID_LAMPADA SET ESTADO = :est WHERE LAMPADAS_GRUPO.ID_GRUPO = :id';

    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bindValue(':est', $est);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $pag = $_GET["pag"];

    if($pag == "listar_grupos"){
        header('location: ../listar_grupos.php');
    }else{
        header('location:../index.php');
    }
?>