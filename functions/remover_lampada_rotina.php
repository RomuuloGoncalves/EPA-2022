<?php
    if (empty($_GET)) 
        header('location:../index.php');
    
    require '../lib/conn.php';

    $idLampada = $_GET['idLampada'];
    $idRotina = $_GET['idRotina'];

    $delete = 'DELETE FROM LAMPADAS_ROTINA WHERE ID_LAMPADA = :idLampada AND ID_ROTINA = :idRotina';
    $stmt = $conn->prepare($delete);
    $stmt->bindValue(':idLampada', $idLampada);
    $stmt->bindValue(':idRotina', $idRotina);
    $stmt->execute();

    header('location:../lampada.php?id='.$idLampada);
?>