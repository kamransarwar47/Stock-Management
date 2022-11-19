<?php

// Stock unit value converter
if(!function_exists('unitConverter')) {
    function unitConverter($from, $to, $value)
    {
        if ($from == 'kg' && $to == 'g') {
            return round($value * 1000, 2);
        } elseif ($from == 'g' && $to == 'kg') {
            return round($value / 1000, 2);
        }
        return $value;
    }
}

// Check if item is low on stock
if(!function_exists('checkLowStock')) {
    function checkLowStock($total, $avaliable) {
        $stock = ($avaliable / $total) * 100;
        if($stock < 50) {
            return true;
        }
        return false;
    }
}
