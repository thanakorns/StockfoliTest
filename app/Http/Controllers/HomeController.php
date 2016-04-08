<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Stock;
use Illuminate\Http\Request;
use DB;
//use Auth;
use Illuminate\Support\Facades\Auth;

//This is the class for all of our controller methods that we call from home.blade
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    //When a client requests to visit StockFoli.com/ and is logged in the home view is returned. This function directs the server to generate the HTML for home.blade and return it
    public function index()
    {
        return view('home');
    }

    //This is a controller method that returns JSON
    //Something in the browser, either a form submission or an AJAX call, has a URL associated with it. The URL is sent by the browser to the server. The URL is associated with a Route
    //The server knows the route. The route has a function associated with it. The server calls middleware. The server calls function. The function returns either HTML or JSON or XML.
    //The server returns this HTML/JSON/XML to the browser. The browser renders the page to the user (the updated page)
    public function stocks()
    {

        $string = $_POST['input'];
        if (strlen($string) == 0){

            //if the string len = 0 return an empty array called stocks as a json object
            //There is some javascript code in home.blade that is expecting an array in json form
            //Json objects can either by maps or arrays or simple things. This is an array

            return response()->json(array("stocks" => []));
        }
        //$stocks = \App\Stock::where('ticker', 'LIKE'map, '%'.$string.'%')->get();
        $stocks = DB::table('stock')->where('ticker', $string)->get();
        $stockobject = array_map(function($row) {return Stock::find($row->id);}, $stocks);
        return response()->json(array("stocks"=>$stockobject));
    }

    public function addToWatchlist()
    {
        $user_id = intval($_POST['user_id']);
        $stock_id = intval($_POST['stock_id']);

        //updateOrCreate is a static method of the PHP class \App\Purchase
        //updateOrCreate updates the purchase table or adds a new row if necessary.
        //intval converts a string ot an integer
        if($user_id != 0 && $stock_id != 0) {

            \App\Purchase::updateOrCreate([
                "user_id" => $user_id,
                "stock_id" => $stock_id,
                "quantity" => 0,
            ]);
        }
        //Once add to watch lsit updates the database it redirects the user to stockfoli.com/
      return(redirect('/'));
    }


    public function buy()
    {

        $ticker = $_POST['ticker'];
        $stocks = DB::table('stock')->where('ticker', $ticker)->get();
        $stock_id = $stocks[0]->id;
        $quantity = intval($_POST['quantity']);

        //We had some issues with update or create so we fixed it with firstOrFail
        $purchase = \App\Purchase::where('user_id', Auth::user()->id)->where('stock_id', $stock_id)->firstOrFail();

        $preBalance = Auth::user()->balance;

        //calculate overall price of desired stock purchase
        $stockPrice = $stocks[0]->current_price * ($quantity);


        if($stockPrice <= $preBalance)
        {
            //Transaction is a method in DB to change the database so that either all updates succeed or none of them occur

            DB::transaction(function() use ($preBalance, $quantity, $stockPrice, $purchase) {


                $purchase->quantity += ($quantity);
                $postBalance = $preBalance - $stockPrice;
                Auth::user()->balance = $postBalance;
                Auth::user()->save();
                $purchase->save();

            });
            return (redirect('/'));

        }
        else{
            return redirect('/')->withErrors(['You do not have enough money to make this purchase']);
        }





    }
    public function sell()
    {

        $ticker = $_POST['ticker'];
        $stocks = DB::table('stock')->where('ticker', $ticker)->get();
        $stock_id = $stocks[0]->id;
        $quantity = intval($_POST['quantity']);
        $purchase = \App\Purchase::where('user_id', Auth::user()->id)->where('stock_id', $stock_id)->firstOrFail();

        $preQuantity = $purchase->quantity;
        $preBalance = Auth::user()->balance;
        $stockPrice = $stocks[0]->current_price * ($quantity);


        if($quantity <= $preQuantity)
        {
            DB::transaction(function() use ($preBalance, $quantity, $stockPrice, $purchase) {


                $purchase->quantity -= ($quantity);
                $postBalance = $preBalance + $stockPrice;
                Auth::user()->balance = $postBalance;
                Auth::user()->save();
                $purchase->save();

            });
            return (redirect('/'));

        }
        else{
            return redirect('/')->withErrors(['You do not have this many shares']);
        }

    }

    //This is the home controller method that is associated with the transaction route. When the transaction route is requested by a user's Post or Get request this function is called
    //this function calls the home controler methods for buy and sell so that there is not a route needed in routes.php for either of those
    public function transaction()
    {
        $transaction = $_POST['transaction'];
        if($transaction == 'buy')
        {
            return $this->buy();
        }
        else{
            return $this->sell();
        }
    }

    public function returnWatchlistInfo()
    {
        //$purchases = \App\Purchase::where('user_id',Auth::user()->id)->where('quantity', 0)->get();
       // return $purchases->toJson();

        $purchases = DB::table('purchase')
            ->join('stock', 'stock.id', '=', 'purchase.stock_id')
            ->where('purchase.quantity', 0)
            ->where('purchase.user_id', Auth::user()->id)
            ->get();

       // return response()->json(array("purchase"))

        return json_encode($purchases);

    }

    public function returnPortfolioListInfo()
    {

    }

    public function getStockPriceInfo()
    {
        $symbols = $_POST['ticker'];
        $interval = $_POST['interval'];
        $myGraph = new \App\library\Graph();

        //This splits the string of ticker symbols seperated by commas into an array of ticker symbols
    $symbolArray = explode(",", $symbols);

        //array_map maps each ticker symbol to whatever is returned by the appropriate graph method
        //use is necessary to reference local variables outside of the lambda function
        //array_map is a php function that takes a function and an array as input
        //it calls the function on each element in the array and returns each value in a new array
        $mapData = array_map(function($ticker) use ($interval, $myGraph){

            //Quandle calls every stock WIKI/...
            $symbol = "WIKI/" . $ticker;
            switch($interval){
                case "5 Day":
                    $myGraph->graphFiveDays($symbol);
                    break;
                case "1 Month":
                    $myGraph->graphOneMonth($symbol);
                    break;
                case "3 Month":
                    $myGraph->graphThreeMonths($symbol);
                    break;
                case "6 Month":
                    $myGraph->graphSixMonths($symbol);
                    break;
                case "All Time":
                    $myGraph->graphAllTime($symbol);
                    break;
            }

            $br_labels = array_reverse($myGraph->br_label_arr); //reverse the data
            $br_values = array_reverse($myGraph->br_value_arr); //reverse the data



            $array = array(
                "labels" => $br_labels,
                "values" => $br_values,
                "symbol" => $ticker
            );

//This array object is a map. There is a map object for every ticker passed in
            return $array;

        }, $symbolArray);
        return $mapData;



    }

    public function getDetailedStockInformation()
    {
        $ticker = $_POST['ticker'];

        if (strlen($ticker) == 0){

            //if the string len = 0 return an empty array called stocks as a json object
            //There is some javascript code in home.blade that is expecting an array in json form
            //Json objects can either by maps or arrays or simple things. This is an array

            return response()->json(array("stocks" => []));
        }
        $stocks = DB::table('stock')->where('ticker', $ticker)->get();
        $stock_id = $stocks[0]->id;
        $stockobject = array_map(function($row) {return Stock::find($row->id);}, $stocks);

        //return response()->json(array("stocks"=>$stockobject));

        $purchases = DB::table('purchase')
            ->join('stock', 'stock.id', '=', 'purchase.stock_id')
            ->where('stock.ticker', $ticker)
            ->where('purchase.user_id', Auth::user()->id)
            ->get();


       return response()->json(array("stocks"=>$purchases));

        /*
        $quantity = DB::table('purchase')->where('stock_id', $stock_id)->where('user_id', Auth::user()->id)->value('quantity');
        $company_name = DB::table('stock')->where('stock_id', $stock_id)->value('company_name');
        $ticker_symbol = DB::table('stock')->where('stock_id', $stock_id)->value('ticker');
        $current_price = DB::Table('stock')->where('stock_id', $stock_id)->value('current_price');
        $previous_price = DB::Table('stock')->where('stock_id', $stock_id)->value('previous_price');
        $percent_change = (($current_price - $previous_price)/$current_price)*100;
        */
    }

}
