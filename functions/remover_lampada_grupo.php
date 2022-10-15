<?php
if (empty($_GET)) {
    header('location: ../index.php');
}
require "../lib/conn.php";
$id_lampada = (int) $_GET["id_lampada"];
$id_grupo = (int) $_GET["id_grupo"];

$sql_excluir = "DELETE FROM LAMPADAS_GRUPO WHERE ID_LAMPADA = :id_lampada AND ID_GRUPO = :id_grupo";
$stmt = $conn->prepare($sql_excluir);
$stmt->bindValue(":id_lampada", $id_lampada);
$stmt->bindValue(":id_grupo", $id_grupo);
$stmt->execute();

header("location: ../gerenciar_lampada.php?id=$id_lampada");
?>