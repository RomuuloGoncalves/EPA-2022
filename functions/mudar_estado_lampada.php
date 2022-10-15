<?php
    if (empty($_GET)) {
        header('location:../index.php');
    }
    require "../lib/conn.php";
    
    $id = (int)$_GET['id'];
    $est = (int)$_GET['est'];

    $novo_estado = $est == 1 ? 0 : 1;

    $sqlUpdate = "UPDATE LAMPADAS SET ESTADO = $novo_estado WHERE ID_LAMPADA = :id";

    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    isset($_GET["indicativoPag"]) ? header("location: ../gerenciar_lampada.php?id=$id") : header("location: ../index.php");

?>