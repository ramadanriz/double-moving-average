<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class ForecastingController extends Controller
{
    public function index() {
        $data = $this->getData();
        $index = count($data);
        $label = [];
        $data1 = [];
        $data2 = [];

        if (isset($_POST['generate'])) {
            $nextPeriod = $this->label_now();
            $periode = $_POST['periode'];
            $hasil = $this->countStart($data,$periode);

            foreach ($hasil['MA'] as $value) {
                array_push($data2,$value);
            }
        }

        return view('forecasting.index', [
            'index' => $index,
            "data2" => isset($_POST['generate']) ? $data2 : '',
            "nextPeriod" => isset($_POST['generate']) ? $nextPeriod : '',
            "hasil" => isset($_POST['generate']) ? $hasil : '',
        ]);
    }

    public function getData() {
        $data = Sale::all();
        $output = [];
        foreach ($data as $row) {
            $output[] = [
                $row->week,
                $row->sale
            ];
        }

        return $output;
    }

    public function countStart($data,$ma) {
        $space = count($data);
        $MA = $this->MovingAverage($data, $space, $ma);

        array_push($data, array($this->label_now(), NULL));
        return array(
            'data'=>$data,
            'MA'=>$MA,
        );
    }

    public function MovingAverage($data,$index,$ma) {
        $MA = array_fill(0, $index + 1, NULL);
        for ($i = $ma - 1; $i < $index; $i++) { 
            $MA[$i+1] = round(array_sum(array_column(array_slice($data, $i - $ma + 1, $ma), 1)) / $ma);
        }
        return $MA;
    }

    public function label_now() {
        $latestWeek = Sale::latest()->first()->week;
        $nextWeek = $latestWeek+1;

        return $nextWeek;
    }
}
