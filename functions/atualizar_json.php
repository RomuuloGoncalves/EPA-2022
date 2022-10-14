<?php
    function atualizar_json ($sql, $path) {
        require "./lib/conn.php";
        
        $stmt = $conn->query($sql);
        $objects = $stmt->fetchAll(PDO::FETCH_OBJ);
        $newJson = [];
        foreach ($objects as $obj) {
            array_push($newJson, json_decode(json_encode($obj)));
        }

        file_put_contents($path, json_encode(json_encode($newJson)));
    }
?>