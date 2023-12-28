<?php

namespace Utils;

use Carbon\Carbon;

class DateTimeUtils {
    public static function formatDate($date, $pattern = ['from' => 'pt-BR', 'to' => 'en-US']) {
        if($pattern['from'] === 'pt-BR') {
            $date = DateTimeUtils::dateBRToUs(substr($date, 0, 10));
        }

        return date(DateTimeUtils::getFormat($pattern['to'], 'date'), strtotime($date));
    }

    public static function formatDateTime($datetime, $pattern = ['from' => 'pt-BR', 'to' => 'en-US']) {
        $parts = explode(' ', $datetime);
        $date = $parts[0];
        $time = $parts[1];

        if(strlen($time) === 5) {
            $time = $time.':00';
        }

        if($pattern['from'] === 'pt-BR') {
            $date = DateTimeUtils::dateBRToUs($date);
        }

        return date(DateTimeUtils::getFormat($pattern['to']), strtotime($date.' '.$time));
    }

    private static function getFormat($pattern, $type = 'datetime') {
        switch($pattern) {
            case 'en-US':
                switch($type) {
                    case 'datetime':
                        return 'Y-m-d H:i:s';
                    case 'date':
                        return 'Y-m-d';
                    case 'time':
                        return 'H:i:s';
                }
            case 'pt-BR':
                switch($type) {
                    case 'datetime':
                        return 'd/m/Y H:i';
                    case 'date':
                        return 'd/m/Y';
                    case 'time':
                        return 'H:i';
                }
        }
    }

    private static function dateBRToUs($date) {
        $parts = explode('/', $date);

        return $parts[2].'-'.$parts[1].'-'.$parts[0];
    }

    public static function getCarbonInstanceFromDatetimeBR($datetime) {
        if(strlen($datetime) === 10) { // Date only
            list($day, $month, $year) = explode('/', $datetime);
        }

        if(strlen($datetime) >= 16) { // Date and time
            list($day, $month, $year, $hour, $minute) = preg_split("/[\/\: ]/", $datetime);
        }

        return Carbon::create($year, $month, $day, $hour ?? 0, $minute ?? 0, 0, 'America/Belem');
    }

    public static function getMonths() {
        return [
            ['month' => 'Janeiro', 'short' => 'Jan', 'number' => 1],
            ['month' => 'Fevereiro', 'short' => 'Fev', 'number' => 2],
            ['month' => 'Março', 'short' => 'Mar', 'number' => 3],
            ['month' => 'Abril', 'short' => 'Abr', 'number' => 4],
            ['month' => 'Maio', 'short' => 'Mai', 'number' => 5],
            ['month' => 'Junho', 'short' => 'Jun', 'number' => 6],
            ['month' => 'Julho', 'short' => 'Jul', 'number' => 7],
            ['month' => 'Agosto', 'short' => 'Ago', 'number' => 8],
            ['month' => 'Setembro', 'short' => 'Set', 'number' => 9],
            ['month' => 'Outubro', 'short' => 'Out', 'number' => 10],
            ['month' => 'Novembro', 'short' => 'Nov', 'number' => 11],
            ['month' => 'Dezembro', 'short' => 'Dez', 'number' => 12]
        ];
    }
}
