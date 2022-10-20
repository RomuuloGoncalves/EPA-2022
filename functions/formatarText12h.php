<?php
    function formatarText12h ($hora) {
        $aux = explode(' ', $hora);
        $h = (int)explode(':', $aux[0])[0];
        $m = (int)explode(':', $aux[0])[1];
        $periodo = $aux[1];

        if ($h < 10) 
            $h = '0'.$h;
        if ($m < 10)
            $m = '0'.$m;
        return $h.':'.$m.' '.$periodo;
    }
?>