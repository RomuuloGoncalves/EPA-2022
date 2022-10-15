<?php
    function porta_cadastrada ($porta) {
        require './lib/conn.php';

        $selectPortas = "SELECT * FROM LAMPADAS WHERE PORTA = :porta";
        $stmt = $conn->prepare($selectPortas);
        $stmt->bindValue(':porta', $porta);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
?>