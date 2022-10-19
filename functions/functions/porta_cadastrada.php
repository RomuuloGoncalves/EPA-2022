<?php
    function porta_cadastrada ($porta) {
        require './lib/conn.php';

        $select = "SELECT * FROM LAMPADAS WHERE PORTA = :porta";
        $stmt = $conn->prepare($select);
        $stmt->bindValue(':porta', $porta);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
?>