<?php
    function formatar12h ($horas) {
        $h = (int)$horas[0];
        $m = (int)$horas[1];
        $periodo = 'am';
        if ($h > 12) {
            $h -= 12;
            $periodo = 'pm';
        }

        return $h.':'.$m.' '.$periodo;
    }
?>