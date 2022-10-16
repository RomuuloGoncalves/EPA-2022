<?php
    if (empty($_GET)) {
        header('location:../index.php');
    }
    require "../lib/conn.php";
    
    $id = (int)$_GET['id'];
    $est = (int)$_GET['est'];
    $id_grupo = (int)$_GET["id_grupo"];

    $novo_estado = $est == 1 ? 0 : 1;

    $sqlUpdate = "UPDATE LAMPADAS SET ESTADO = $novo_estado WHERE ID_LAMPADA = :id";

    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    if(isset($_GET["indicativoPag"])){
        header("location: ../lampada.php?id=$id");
    }else if(isset($_GET["indicativoPag-2"])){
        header("location: ../grupo.php?id=$id_grupo");
    }else{
        header("location: ../index.php");
    }

?>