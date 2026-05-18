<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_match_date')) {
    function format_match_date($date)
    {
        return date('d M Y', strtotime($date));
    }
}

if (!function_exists('format_match_time')) {
    function format_match_time($time)
    {
        return date('H:i', strtotime($time));
    }
}

if (!function_exists('get_result_label')) {
    function get_result_label($home, $away)
    {
        if ($home === null || $away === null) {
            return 'Pendiente';
        }

        if ($home === $away) {
            return 'Empate';
        }

        return $home > $away ? 'Local' : 'Visitante';
    }
}
