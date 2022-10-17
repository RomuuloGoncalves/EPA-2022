<?php
    function atualizar_json () {
        require './lib/conn.php';
        
        $select = 'SELECT PORTA, ESTADO FROM LAMPADAS';
        $stmt = $conn->query($select);
        $objects = $stmt->fetchAll(PDO::FETCH_OBJ);

        $newJson = [];
        foreach ($objects as $obj) {
            array_push($newJson, json_decode(json_encode($obj)));
        }

        file_put_contents('./json/lampadas.json', json_encode(json_encode($newJson)));
    }
?>