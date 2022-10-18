<?php
    function dividir_horario ($hora) {
        $periodo = explode(' ', $hora)[1];
        $h = (int)explode(':', explode(' ', $hora)[0])[0];
        $m = (int)explode(':', explode(' ', $hora)[0])[1];

        return ['h' => $h, 'm' => $m,  'periodo' => $periodo];
    }
?>