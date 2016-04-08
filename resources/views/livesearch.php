<?php
        $string = $_GET['string'];
        $stocks = App\Stock::where('ticker',$string)->get();
        return json_encode($stocks);