<?php

if (!function_exists('numeroALetras')) {
    function numeroALetras($numero) {
        $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
        $partes = explode('.', number_format($numero, 2, '.', ''));
        
        $entero = $formatter->format($partes[0]);
        $decimal = isset($partes[1]) ? $partes[1] : '00'; 
        
        return strtoupper($entero) . ' PESOS ' . strtoupper($decimal) . '/100 M.N.';
    }
}