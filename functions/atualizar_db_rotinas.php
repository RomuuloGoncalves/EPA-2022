<?php
    function atualizar_db_rotinas () {
    require 'lib/conn.php';
    require 'functions/formatar12h.php';
    require 'functions/dividir_horario.php';
    
    date_default_timezone_set('America/Sao_Paulo');

    $select = 'SELECT ID_ROTINA, ESTADO, H_INICIO, H_FIM FROM ROTINAS';
    $stmt = $conn->query($select);
    $rotinas = $stmt->fetchAll(PDO::FETCH_OBJ);

    $aux = formatar12h(explode(':', date('H:i')));
    $hora_atual = explode(':', explode(' ', $aux)[0]);
    $hora_atual[0] = (int)$hora_atual[0];
    $hora_atual[1] = (int)$hora_atual[1];

    $periodo_atual = explode(' ', $aux)[1];
    foreach ($rotinas as $rotina) {
        $hora_rotina_inicio  = dividir_horario($rotina->H_INICIO);
        $hora_rotina_fim     = dividir_horario($rotina->H_FIM);

        if ($rotina->ESTADO == 0 && ($periodo_atual == $hora_rotina_inicio['periodo'] && ($hora_rotina_inicio['h'] == $hora_atual[0] && $hora_rotina_inicio['m'] == $hora_atual[1]))) {
            $update = 'UPDATE ROTINAS SET ESTADO = 1 WHERE ID_ROTINA = :idRotina';
            $stmt = $conn->prepare($update);
            $stmt->bindValue(':idRotina', $rotina->ID_ROTINA);
            $stmt->execute();
            
            $update = 'UPDATE LAMPADAS 
            INNER JOIN LAMPADAS_ROTINA
            ON LAMPADAS.ID_LAMPADA = LAMPADAS_ROTINA.ID_LAMPADA
            SET LAMPADAS.ESTADO = 1
            WHERE LAMPADAS_ROTINA.ID_ROTINA = :id';
            $stmt = $conn->prepare($update);
            $stmt->bindValue(':id', $rotina->ID_ROTINA);
            $stmt->execute();

            unset($update);
            unset($stmt);
        } else if ($periodo_atual == $hora_rotina_fim['periodo'] && ($hora_rotina_fim['m'] == $hora_atual[1] && $hora_atual) && $hora_rotina_fim['h'] == $hora_atual[0]) {
            $update = 'UPDATE ROTINAS SET ESTADO = 0 WHERE ID_ROTINA = :idRotina';
            $stmt = $conn->prepare($update);
            $stmt->bindValue(':idRotina', $rotina->ID_ROTINA);
            $stmt->execute();
            
            $update = 'UPDATE  LAMPADAS 
            INNER JOIN LAMPADAS_ROTINA
            ON LAMPADAS.ID_LAMPADA = LAMPADAS_ROTINA.ID_LAMPADA
            SET LAMPADAS.ESTADO = 0
            WHERE LAMPADAS_ROTINA.ID_ROTINA = :id';
            $stmt = $conn->prepare($update);
            $stmt->bindValue(':id', $rotina->ID_ROTINA);
            $stmt->execute();

            unset($update);
            unset($stmt);
        }
    }
    }
?>