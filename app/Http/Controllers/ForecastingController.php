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

            // foreach ($hasil['MA'] as $value) {
            //     array_push($data2,$value);
            // }
        }

        return view('forecasting.index', [
            'index' => $index,
            // "data2" => isset($_POST['generate']) ? $data2 : '',
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
        $DMA = $this->DoubleAverage($MA, $space, $ma);
        $AT = $this->AKoefisien($MA, $DMA, $ma);
        $BT = $this->BKoefisien($MA, $DMA, $ma);
        $FT = $this->Ft($AT, $BT, $ma);

        array_push($data, array($this->label_now(), NULL));
        return array(
            'data'=>$data,
            'MA'=>$MA,
            'DMA' => $DMA,
            'AT' => $AT,
            'BT' => $BT,
            'FT' => $FT
        );
    }

    public function MovingAverage($data,$index,$ma) {
        $MA = array_fill(0, $index + 1, NULL);
        for ($i = $ma - 1; $i < $index; $i++) { 
            $MA[$i] = array_sum(array_column(array_slice($data, $i - $ma + 1, $ma), 1)) / $ma;
        }

        return $MA;
    }

    public function DoubleAverage($data,$index,$ma) {
        // $MA = array_fill(0, $index + 1, NULL);
        // for ($i = $ma - 1; $i < $index; $i++) { 
        //     $MA[$i] = round(array_sum(array_slice($data, $i - $ma + 1, $ma)) / ($ma-2));
        // }
        $MA = array_fill(0, $index + 1, NULL);
        for ($i = ($ma*2)-2; $i < $index; $i++) { 
            $MA[$i] = array_sum(array_slice($data, $i - $ma + 1, $ma)) / $ma;
        }

        
        return $MA;
    }

    public function AKoefisien($data, $data2, $ma) {
        // $index = count($dma);
        // $AT = array_fill(0, $index, NULL);
        // for ($i = $ma + 1; $i < $index; $i++) { 
        //     $AT[$i] = array_sum(array_slice($sma, $i - $ma + 1, $ma)) / $ma;
        // }
        $index = count($data2)-1;
        $AT = array_fill(0, $index + 1, NULL);
        for ($i = ($ma*2)-2; $i < $index; $i++) { 
            $AT[$i] = (2 * $data[$i]) - $data2[$i];
        }

        
        return $AT;
                
    }

    public function BKoefisien($data, $data2, $ma) {
        $index = count($data2)-1;
        $BT = array_fill(0, $index + 1, NULL);
        for ($i = ($ma*2)-2; $i < $index; $i++) { 
            $BT[$i] = (2/($ma-1)) * ($data[$i]) - $data2[$i];
        }

        
        return $BT;
    }

    public function Ft($data, $data2, $ma) {
        $index = count($data2);
        $FT = array_fill(0, $index + 1, NULL);
        for ($i = ($ma*2)-1; $i < $index; $i++) { 
            $FT[$i] = $data[$i-1] + $data2[$i-1];
        }

        
        return $FT;
    }

    public function label_now() {
        $latestWeek = Sale::latest()->first()->week;
        $nextWeek = $latestWeek+1;

        return $nextWeek;
    }
}
