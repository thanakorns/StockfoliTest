@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">

                        <!--Top wrapper (logo, account)-->
                        <div class="row well" style="margin:5px;" align="center">
                            <div id='logo_widget' class="col-xs-12 col-lg-4">
                            <?php
                                $url = asset('images/logo.png');
                                echo "<img src='" . $url . "' width='45%'/>";
                            ?>
                            </div>
                            <div id='account_widget'  class="col-xs-12 col-lg-4">
                                <?php 
                                    echo "Account Balance: ". Auth::user()->balance . '<br>';
                                    echo "Net Worth: ". Auth::user()->net_value .'<br>';
                                ?>
                                    @if ($errors->any())
                                        {{ implode('', $errors->all(':message')) }}
                                    @endif

                            </div>
                            <div id='user_manual_widget' class="col-xs-12 col-lg-4">
                            <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#user_help">
                                  User Manual
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="user_help" tabindex="-1" role="dialog" aria-labelledby="User Manual">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">User Manual</h4>
                                      </div>
                                      <div class="modal-body">
                                        <h1>User Manual</h1>
                                            <p>This is a list of functionality provided in the StockFoli stock portfolio management system:</p>

                                            <h2>Checking Account Information</h2>
                                            <p>Your account balance and net portfolio value can be found in the Account Information Widget, located in the top center of the dashboard.</p>

                                            <h2>View the Current Eastern Standard Time</h2>
                                            <p>StockFoli provides you with the current Eastern Standard Time, whcih aligns with the New York Stock Exchange hours. You will find this time displayed to the right of the search field, below the user manual button.</p>

                                            <h2>Upload CSV Portfolio File</h2>
                                            <p>To add existing portfolio data to your account, StockFoli allows you to upload a CSV (Comma Separated Values) Portfolio File that follows the specified CSV Portfolio File format, as listed below.</p>
                                            <h2>CSV Portfolio File Format</h2>
                                            <p>STOCK_TICKER_NAME, DATE_BOUGHT_DOLLARS, PRICE_BOUGHT, NUMBER_OF_SHARES\n
                                            e.g.\n
                                            NFLX, 11/2/2015, 108.92, 10\n
                                            CMG, 2/27/2016, 505.79, 25\n
                                            COST, 2/4/2016, 143.28, 90\n
                                            EBAY, 1/5/2013, 26.12, 20\n
                                            GLD, 2/11/2012, 119.06, 5</p>

                                            <h2>Search and Add Stocks</h2>
                                            From the stock search field above the Portfolio List and Watch List, you can search for stocks to add to your portfolio list and/or watch list.</p>

                                            <h2>Manage Your Portfolio Stock List</h2>
                                            <p>View the Portfolio List in the tabbed table to the left of the Stock Graph Widget to see which stocks you own shares in. You can sell shares from the Buy/Sell Widget below the Portfolio List.</p>

                                            <h2>Manage Your Stock Watch List</h2>
                                            <p>View the Watch List in the tabbed table to the left of the Stock Graph Widget to see which stocks you are currently watching but do not have shares in. You can buy shares from these stocks from the Buy/Sell Widget below the Watch List.</p>
                                            <h2>Viewing Stock on Graph</h2>
                                            With a stock selected from either the Portfolio List or the Watch List in the tabbed pane, a stock's 6-month graph will appear in the Stock Graph Widget to the right of these lists.</p>

                                            <h2>Changing Graph Time Interval</h2>
                                            <p>The time interval buttons (5-day, 1-month, 3-months, 6-months, All-Time) below the Stock Graph Widget provide the functionality for you to change the graph's time interval.</p>

                                            <h2>View Stock Detailed Information</h2>
                                            <p>With a stock selected and previewing in the Stock Graph Widget, the Detailed Information Widget located below the Stock Graph Widget will feature more statistics about the selected stock, including previous day's closing price, current price, percent changed, ticker name, company name, etc.</p>

                                            <h2>Buy New Stocks</h2>
                                            <p>The Buy/Sell Widget below the Portfolio List and Watch List allow you to choose a stock and number of shares to buy from a stock's shares.</p>
                                            <h2>Sell Shares of Stocks</h2>
                                            <p>The Buy/Sell Widget below the Portfolio List and Watch List allow you to choose a stock and number of shares to sell from your owned shares.</p>

                                            <h2>Logging out</h2>
                                            <p>To log out of your dashboard, click your name dropdown menu item from the top right corner of the page and click Logout. You will be redirected to the StockFoli Login page.</p> 

                                            <h2>User Timeout</h2>
                                            <p>After 5 minutes, the logged-in user will be logged out of their account and redirected to the StockFoli Login page.</p>

                                            <h2>Forgot Password Reset Link</h2>
                                            <p>From the StockFoli Login page, select the Forgot Password link to input your account's email for a password recovery temp email</p>

                                            <h2>Viewing Recent Stock News</h2>
                                            <h2>Getting Stock Recommendations</h2>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload CSV, Search, and Time-->
                        <div class="row" style="margin:10px;" align="center">
                            <div id='upload_CSV_widget' class="col-xs-12 col-lg-4">
                                <form>
                                    <div class="form-group">
                                        <input type="file" id="exampleInputFile">
                                    </div>
                                    <button type="submit" class="btn btn-default">Upload</button>
                                </form>
                            </div>
                            <div id='search_widget' class="col-xs-12 col-lg-4">
                                <script>
                                    //if you look down, there is a javascript call onkeyup in response to an input from the user. The input is str

                                    function showResult(str) {
                                        if (str.length == 0){
                                            var current =  $("#r0");
                                            current.css({display: "none"});
                                        }
                                        var yo;

                                        //ajax is a convention for browser server communication.
                                        //This ajax call has three parameters.
                                        //The request to the server from the browser is a post request
                                        //The url contains the route that is associated with the action that will execute on the server
                                        //the route tells the server which server side function to call
                                        //str from above is the input to this server side function
                                        //the return from this server side function is a json object. This object is decoded and the information is bound to the data variable below
                                        $.ajax({//Ajax request
                                            url: "ajax/stocks",
                                            type: "POST",//Uses post method
                                            data: {input: str}
                                        }).success(function(data){
                                            yo = data;

                                            //data.stocks is an array of stock objects - from home controller method stocks
                                            //so data becomes an array of stock objects
                                            data = data.stocks;
                                            for(var count = 0; count < 1; count++){

                                                //in javascript the $ () is a call to jquery - used for navigating html document object model
                                                var current =  $("#r"+String(count));

                                                //This finds the table data cell corresponding to company name
                                                //.html fills this data cell's html with the argument of the html function
                                                current.find(".company_name").html(data[count].company_name);
                                                current.find(".current_price").html(data[count].current_price);
                                                current.find(".ticker").attr("value", data[count].id);
                                                current.css({display: "block"});
                                            }
                                            if (data.length == 0){
                                                current.css({display: "none"});
                                            }
                                        });
                                    }
                                </script>
                                <!-- The form below builds the search box for stocks-->
                                <form>
                                    <input type="text" class="form-control" name="searchStock" placeholder="Search Stock" width="80%" onkeyup="showResult(this.value)">
                                </form>
                            <table id='livesearch' class='table'>
                                <tbody>
                                <tr id='r0' style="display: none;">
                                    <td class="company_name"/>
                                    <td class="current_price"/>
                                    <td>
                                        <!-- This is the add button for adding to watchlist
                                        for html input elements
                                        type = type of input
                                        value = the value of an input
                                        class = useful information on how to render the element to the user
                                        -->

                                        <form action="/user/watchlist" method='POST'>
                                            <input type='hidden' value='<?php echo Auth::user()->id?>' name="user_id">
                                            <input type='hidden' class='ticker' value='' name="stock_id">
                                            <input id='add_to_watchlist' type="submit" class="btn btn-default btn-sm" value = "add">
                                        </form>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            </div>
                            <div id='time_widget'class="col-xs-12 col-lg-4">
                            <?php
                                date_default_timezone_set('US/Eastern');
                                echo date("h:i:s A");
                            ?>
                            </div>
                        </div>

                        <!-- Portfolio Widget, Graph Widget, Watch List Widget-->
                        <div class="row" style='margin-top: 10px'>
                            <div id='profile_tables' class="col-xs-12 col-lg-6">
                                <ul class="nav nav-pills nav-justified">
                                  <li class="active"><a data-toggle="tab" id="portfolioTab" href="#portfolio">Portfolio</a></li>
                                  <li><a data-toggle="tab" id="watchlistTab" href="#watchlist">Watchlist</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="portfolio" class="tab-pane fade in active">
                                        <div style='width: 100%; height: 200px; overflow: auto;'>
                                            <!-- Form for buy and sell for portfolio-->
                                            <form action="/user/transaction" method="POST">
                                                <button type="submit" disabled id="portfolioBuy" name="transaction" value="buy">
                                                    Buy
                                                </button>
                                                <button type="submit" disabled id="portfolioSell" name="transaction" value="sell">
                                                    Sell
                                                </button>
                                                <input type="number" min="1"  name="quantity" placeholder="Shares" >
                                                <input type ="hidden" name="ticker" id="portfolioSelectedStock">
                                               <!-- We needed to insert a hidden field containing a csrf protection token
                                               the middleware demands that this token be present when processing the transaction route
                                               -->
                                                {{ csrf_field() }}
                                            </form>

                                            <table class="table table-striped table-condensed" id="portfolioTable">
                                                <thead >
                                                <tr>

                                                    <!-- data-column-id were necessary for bootgrid to run correctly-->
                                                    <th data-column-id="company_name">Name</th>
                                                    <th data-column-id="ticker" data-identifier="true">Symbol</th>
                                                    <th data-column-id="quantity">Quantity</th>
                                                    <th data-column-id="current_price">Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $purchases = App\Purchase::where('user_id',Auth::user()->id)->where('quantity', '>', 0)->get();
                                                foreach ($purchases as $purchase){
                                                    $stock = App\Stock::where('id', $purchase->stock_id)->first();
                                                    $name = explode('(',$stock->company_name)[0];
                                                    echo "<tr>";
                                                    echo "<td>$name</td>";
                                                    echo "<td>$stock->ticker</td>";
                                                    echo "<td>$purchase->quantity</td>";
                                                    echo "<td>$stock->current_price</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="watchlist" class="tab-pane fade">
                                        <div style='width: 100%; height: 200px; overflow: auto;'>
                                            <form action="/user/transaction" method="POST">
                                                <button type="submit" disabled id="watchlistBuy" name="transaction" value="buy">
                                                    Buy
                                                </button>
                                                <input type="number" min="1"  name="quantity" placeholder="Shares" >
                                                <input type ="hidden" name="ticker" id="watchlistSelectedStock">
                                                {{ csrf_field() }}
                                            </form>
                                            <table class="table table-striped table-condensed" id="watchlistTable">
                                                <thead >
                                                    <tr>
                                                        <th data-column-id="company_name">Name</th>
                                                        <th data-column-id="ticker" data-identifier="true">Symbol</th>
                                                        <th data-column-id="current_price">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $purchases = App\Purchase::where('user_id',Auth::user()->id)->where('quantity', 0)->get();
                                                    foreach ($purchases as $purchase){
                                                        $stock = App\Stock::where('id', $purchase->stock_id)->first();
                                                        $name = explode('(',$stock->company_name)[0];
                                                        echo "<tr>";
                                                        echo "<td>$name</td>";
                                                        echo "<td>$stock->ticker</td>";
                                                        echo "<td>$stock->current_price</td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id='graph_widget' class="col-xs-12 col-lg-6">
                                <div style="width:100%">
                                    <ul class="nav nav-pills" id="selectedTimeRange" width='100%'>
                                        <li><a href="#" data-toggle="tab">5 Day</a></li>
                                        <li><a href="#" data-toggle="tab">1 Month</a></li>
                                        <li><a href="#" data-toggle="tab">3 Month</a></li>
                                        <li class="active"><a href="#" data-toggle="tab">6 Month</a></li>
                                        <li><a href="#" data-toggle="tab">All Time</a></li>
                                    </ul>
                                    <div>
                                        <canvas id="canvas" height="400" width="800"></canvas>
                                    </div>
                                </div>
                                <?php
                                echo "<script src='" . $url = asset('script/Chart.js') . "'></script>";
                                echo "<script src='" . $url = asset('script/StockFoli.js') . "'></script>";
                            ?>
                            <script>
                                //this used to hard code the graph of apple
                                //now it graphs nothing on default
                                var lineChartData = {
                                    labels : [],
                                    datasets : [

                                    ]

                                }
                                window.onload = function(){
                                    var ctx = document.getElementById("canvas").getContext("2d");
                                    window.myLine = new Chart(ctx).Line(lineChartData, {
                                        responsive: true
                                    });
                                }
                                </script>
                            </div>
                            <div id="legend" class="chart-legend">

                            </div>
                        </div>

                        <div class="row" id="detailedInformation">
                            <div style='width: 100%; overflow: auto;'>

                                <table class="table table-striped" id="detailedInformationTable">
                                    <tbody >
                                    <tr>
                                        <th>Name</th>
                                        <th>Symbol</th>
                                        <th>Quantity</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Current Price</th>
                                        <th>Previous Price</th>
                                        <th>Percentage Change</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>



                            </div>
                        </div>



<!--                                <div style='width: 45%; height: 400px;' class=".col-xs-12">
                                        <h2>Watchlist</h2>
                                        <div style="height: 8%;">
                                            <table class='table table-striped'>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Symbol</th> 
                                                    <th>Current Price</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div style='width: 100%; height: 85%; overflow: auto;'>
                                        <table class='table table-striped'>
                                            <?php
                                                $stocks = App\Stock::all();
                                                foreach ($stocks as $stock){
                                                    $name = explode('(',$stock->company_name)[0];
                                                    echo "<tr>";
                                                    echo "<th>$name</th>";
                                                    echo "<th>$stock->ticker</th>";
                                                    echo "<th>$stock->current_price</th>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </table>
                                    </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
