<?php

namespace App\Http\Controllers;

use App\Experiment;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function download($id)
    {
        $experiment = Experiment::find($id);
        $output = "Time,Memory,Feeling\r\n";
        $popups = $experiment->popups;
        foreach ($popups as $popup) {
            $output .= $popup['time'] . ',' . $popup['memory'] . '%,' . $popup['mood'] . "\r\n";
        }
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ExportFileName.csv"',
        );

        return response(rtrim($output, "\n"), 200, $headers);
    }
}
