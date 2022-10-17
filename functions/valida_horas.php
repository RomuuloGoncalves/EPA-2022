<?php
    function valida_horas ($horas) {
        return $horas[0] <= 24 && $horas[0] >= 0 && $horas[1] <= 60 && $horas[1] >= 0;
    }
?>