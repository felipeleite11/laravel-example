<?php

namespace App\Http\Controllers;

use App\Charts\DefaultChart;
use App\Models\Schedule;
use Utils\DateTimeUtils;

class HomeController extends Controller
{
    public function home() {
        return view('Home.index');
    }

    public function index() {
        $schedules = Schedule::orderBy('datetime', 'DESC')
            ->where('datetime', '>=', date('Y-m-d H:i:s'))
            ->limit(5)
            ->get();

        $monthsNames = [];

        foreach(DateTimeUtils::getMonths() as $monthData) {
            $monthsNames[] = $monthData['short'];
        }

        $lineChart = new DefaultChart;
        $lineChart->labels($monthsNames);
        $lineChart->dataset('Atendimentos', 'line', [0, 3, 10, 6, 8, 2, 7, 4, 0, 0, 0, 0]);
        $lineChart->options([
            'caption' => 'Atendimentos por mês',
            'captionFontSize' => 15,
            "baseFont" => "-apple-system,BlinkMacSystemFont,\"Segoe UI\",Roboto,Oxygen-Sans,Ubuntu,Cantarell,\"Helvetica Neue\",sans-serif",
            'baseFontSize' => 12
        ]);

        $barChart = new DefaultChart;
        $barChart->labels($monthsNames);
        $barChart->dataset('Contatos', 'bar', [0, 3, 10, 6, 8, 2, 7, 4, 0, 0, 0, 0]);
        $barChart->options([
            'caption' => 'Contatos cadastrados por mês',
            'captionFontSize' => 15,
            "baseFont" => "-apple-system,BlinkMacSystemFont,\"Segoe UI\",Roboto,Oxygen-Sans,Ubuntu,Cantarell,\"Helvetica Neue\",sans-serif",
            'baseFontSize' => 12
        ]);

        // Exemplo PIE2D: http://jsfiddle.net/fusioncharts/fyczLffy/

        $pieChart = new DefaultChart;
        $pieChart->labels($monthsNames);
        $pieChart->dataset('Dados', 'pie2D', [0, 3, 10, 6, 8, 2, 7, 4, 0, 0, 0, 0]);
        $pieChart->options([
            'theme' => 'fusion',
            'caption' => 'Compromissos por mês',
            'captionFontSize' => 15,
            'showPercentValues' => true,
            "baseFont" => "-apple-system,BlinkMacSystemFont,\"Segoe UI\",Roboto,Oxygen-Sans,Ubuntu,Cantarell,\"Helvetica Neue\",sans-serif",
            'baseFontSize' => 12
        ]);

        return view('HomeAuth.index', [
            'lineChart' => $lineChart,
            'barChart' => $barChart,
            'pieChart' => $pieChart,
            'schedules' => $schedules
        ]);
    }
}
