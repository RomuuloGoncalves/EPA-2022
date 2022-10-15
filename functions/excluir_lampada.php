<?php
if (empty($_GET)) {
    header('location: ./index.php');
}

require "../lib/conn.php";
$id_lampada = (int) $_GET["id"];

$sql_excluir = "DELETE FROM LAMPADAS_GRUPO WHERE ID_LAMPADA = :id";
$stmt = $conn->prepare($sql_excluir);
$stmt->bindValue(":id", $id_lampada);
$stmt->execute();

$sql_excluir = "DELETE FROM LAMPADAS_ROTINA WHERE ID_LAMPADA = :id";
$stmt = $conn->prepare($sql_excluir);
$stmt->bindValue(":id", $id_lampada);
$stmt->execute();

$sql_excluir = "DELETE FROM LAMPADAS WHERE ID_LAMPADA = :id";
$stmt = $conn->prepare($sql_excluir);
$stmt->bindValue(":id", $id_lampada);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exluir lampada</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style_modal.css">
</head>

<body>
    <div class="page">
    </div>
    <div class="modal" id="sucesso">
        <div class="texto">
            <div class="titulo">Sucesso!!!!</div>
            <div class="close">
               <a href="../index.php">
                 <img src="../assets/img/close.png" alt="">
                 </a>
            </div>
        </div>
        <div class="simbolo">
            <img src="../assets/img/sucesso.png" alt="">
            <div class="erro">
                <div class="aviso" id="aviso__certo">
                    Lâmpada excluída com sucesso!!!
                </div>
            </div>
        </div>
</body>

</html>