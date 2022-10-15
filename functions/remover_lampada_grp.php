<?php
if (empty($_GET)) {
    header('location: ../index.php');
}
require "../lib/conn.php";
$idLampada = (int) $_GET["idLampada"];
$idGrupo = (int) $_GET["idGrupo"];

$sqlDelete = "DELETE FROM LAMPADAS_GRUPO WHERE ID_LAMPADA = :idLampada AND ID_GRUPO = :idGrupo";
$stmt = $conn->prepare($sqlDelete);
$stmt->bindValue(":idLampada", $idLampada);
$stmt->bindValue(":idGrupo", $idGrupo);
$stmt->execute();

header("location: ../grupo.php?id=$idGrupo");
?>