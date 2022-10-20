<?php
    require 'functions/atualizar_db_rotinas.php';
    require 'lib/conn.php';
    atualizar_db_rotinas();
        
    $select = 'SELECT PORTA, ESTADO FROM LAMPADAS';
    $stmt = $conn->query($select);
    $objects = $stmt->fetchAll(PDO::FETCH_OBJ);

    $newJson = [];
    foreach ($objects as $obj) {
        array_push($newJson, json_decode(json_encode($obj)));
    }

    array_push($newJson, json_decode(json_encode(['PORTA'=>'LED_BUILTIN','ESTADO'=>1])));
    // $newJson .=
    echo str_replace('"', '\"',json_encode($newJson));
?>